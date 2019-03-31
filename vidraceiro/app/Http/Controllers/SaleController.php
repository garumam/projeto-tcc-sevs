<?php

namespace App\Http\Controllers;


use App\Installment;
use App\Payment;
use Illuminate\Http\Request;
use App\Sale;
use App\Client;
use App\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Configuration;


class SaleController extends Controller
{
    protected $sale;

    public function __construct(Sale $sale)
    {

        $this->middleware('auth');
        $this->sale = $sale;

    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('venda_listar', Sale::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $titulotabs = ['Vendas', 'Pagamentos'];

        $sales = $this->sale->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if ($request->ajax()) {
            if ($request->has('pagamentos')) {
                return view('dashboard.list.tables.table-payment', compact('sales'));
            } else {
                return view('dashboard.list.tables.table-sale', compact('sales'));
            }

        }

        return view('dashboard.list.sale', compact('sales','salesWithInstallments', 'titulotabs'))->with('title', 'Vendas');

    }

    public function create()
    {
        if(!Auth::user()->can('venda_adicionar', Sale::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $budgets = Budget::getBudgetsWhereStatusWaiting();
        $juros = (new Configuration())->getConfiguration()->juros_mensal_parcel;
        return view('dashboard.create.sale', compact('budgets','juros'))->with('title', 'Nova venda');
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('venda_adicionar', Sale::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $arrayextra = null;
        if ($request->tipo_pagamento === 'A PRAZO') {

            $arrayextra = [
                'orcamento_id' => 'required|integer|unique:sales,orcamento_id',
                'valor_parcela' => 'required|numeric',
                'qtd_parcelas' => 'required|integer',
                'entrada' => 'nullable|numeric'
            ];

        } else {

            $arrayextra = [
                'orcamento_id' => 'required|integer|unique:sales,orcamento_id'
            ];

        }

        $validado = $this->rules_sale($request->all(), $arrayextra);
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $desconto = $request->desconto ?? 0;
        $request->merge(['desconto'=>$desconto]);

        if($request->has('entrada')){
            $entrada = $request->entrada ?? 0;
            $request->merge(['entrada'=>$entrada]);
        }
        $sale = $this->sale->createSale(array_merge($request->all(),['usuario_id'=>Auth::user()->id]));

        if ($request->has('valor_parcela')) {

            $sale->createSaleInstallments($request,Auth::user()->id);

        } else {
            $valorPago = $sale->budget->total - $request->desconto;
            $sale->createSalePayment($request->data_venda,$valorPago,'Pagamento de venda à vista.',Auth::user()->id);

        }
        $mensagem = '';
        if ($request->usar_estoque != null) {

            $mensagem = $sale->useStorage();

        }

        if ($sale) {
            $sale->budget->updateBudget(['status' => 'APROVADO']);
            return redirect()->back()->with('success', 'Venda realizada com sucesso' . $mensagem);
        }

    }

    public function show($id)
    {
        if(!Auth::user()->can('venda_listar', Sale::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_sale_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('sales.index'))->withErrors($validado);
        }
        $sale = $this->sale->findSaleById($id);
        return view('dashboard.show.sale', compact('sale'))->with('title', 'Informações da venda');
    }


    public function pay($id)
    {
        if(!Auth::user()->can('pagamento_atualizar', Payment::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_sale_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('sales.index'))->withErrors($validado);
        }
        $sale = $this->sale->findSaleById($id);

        if ($sale)
            return view('dashboard.create.pay', compact('sale'))->with('title', 'Efetuar pagamentos');
    }

    public function payupdate(Request $request, $id)
    {
        if(!Auth::user()->can('pagamento_atualizar', Payment::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_sale_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('sales.index'))->withErrors($validado);
        }

        $sale = $this->sale->findSaleById($id);

        if($sale->tipo_pagamento === 'A VISTA' || !$sale->havePendingInstallment()){
            return redirect()->back()->with('error', 'Esta venda já está paga!');
        }

        $installments = null;

        if ($request->data_pagamento === null) {
            return redirect()->back()->with('error', 'Selecione a data do pagamento!');
        }
        if($sale->tipo_pagamento === 'A PRAZO'){
            if ($request->parcelas !== null) {

                $installments = Installment::getInstallmentsWherein($request->parcelas);



                foreach ($installments as $installment) {
                    $valorParcela = $installment->valor_parcela + $installment->multa;
                    $valorParcela = number_format($valorParcela,2,'.','');
                    $sale->createSalePayment($request->data_pagamento,$valorParcela,'Pagamento de parcela de venda a prazo.',Auth::user()->id);

                    $installment->updateInstallment('status_parcela','PAGO');
                }


                $budget = $sale->budget;
                $client = new Client();
                $client = $client->findClientById($budget->cliente_id);
                $client->updateStatus();


            } else {
                return redirect()->back()->with('error', 'Marque pelo menos uma parcela!');
            }
        }


        if ($installments)
            return redirect()->back()->with('success', 'Pagamento efetuado com sucesso');
    }

    public function rules_sale(array $data, $extra)
    {
        $validator = Validator::make($data,
            array_merge(
                [
                    'tipo_pagamento' => 'required|string|max:255',
                    'data_venda' => 'required|date',
                    'desconto' => 'nullable|numeric'
                ],
                $extra
            )
        );

        return $validator;
    }

    public function rules_sale_exists(array $data)
    {
        $validator = Validator::make($data,

            [
                'id' => 'exists:sales,id'
            ], [
                'exists' => 'Esta venda ou pagamento não existe!',
            ]

        );

        return $validator;
    }
}
