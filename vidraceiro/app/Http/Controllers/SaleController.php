<?php

namespace App\Http\Controllers;

use App\Financial;
use App\Installment;
use App\Payment;
use App\Storage;
use Illuminate\Http\Request;
use App\Sale;
use App\Client;
use App\Budget;
use Illuminate\Support\Facades\Validator;

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
        $titulotabs = ['Vendas', 'Pagamentos'];

        $salesWithInstallments =  $this->sale->getSaleInstallmentsWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        $sales = $this->sale->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if ($request->ajax()) {
            if ($request->has('pagamentos')) {
                return view('dashboard.list.tables.table-payment', compact('salesWithInstallments'));
            } else {
                return view('dashboard.list.tables.table-sale', compact('sales'));
            }

        }

        return view('dashboard.list.sale', compact('sales','salesWithInstallments', 'titulotabs'))->with('title', 'Vendas');

    }

    public function create()
    {
        $budgets = Budget::getBudgetsWhereStatusWaiting();
        return view('dashboard.create.sale', compact('budgets'))->with('title', 'Nova venda');
    }

    public function store(Request $request)
    {
        $arrayextra = null;
        if ($request->tipo_pagamento === 'A PRAZO') {

            $arrayextra = [
                'orcamento_id' => 'required|integer|unique:sales,orcamento_id',
                'valor_parcela' => 'required|numeric',
                'qtd_parcelas' => 'required|integer'
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

        $sale = $this->sale->createSale($request->all());

        if ($request->has('valor_parcela')) {

            $sale->createSaleInstallments($request);

        } else {

            $sale->createSalePayment($request->data_venda,$sale->budget->total,'Pagamento de venda à vista.');

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
        $validado = $this->rules_sale_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('sales.index'))->withErrors($validado);
        }
        $sale = $this->sale->findSaleById($id);
        return view('dashboard.show.sale', compact('sale'))->with('title', 'Informações da venda');
    }

    public function edit($id)
    {
        $validado = $this->rules_sale_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('sales.index'))->withErrors($validado);
        }
        $sale = $this->sale->findSaleById($id);
        return view('dashboard.create.sale', compact('sale'))->with('title', 'Atualizar venda');
    }


    public function update(Request $request, $id)
    {
        $validado = $this->rules_sale_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('sales.index'))->withErrors($validado);
        }

        $arrayextra = [];
        if ($request->tipo_pagamento === 'A PRAZO') {

            $arrayextra = [
                'valor_parcela' => 'required|numeric',
                'qtd_parcelas' => 'required|integer'
            ];

        }

        $validado = $this->rules_sale($request->all(), $arrayextra);
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $sale = $this->sale->findSaleById($id);

        if ($sale->tipo_pagamento === 'A PRAZO') {

            if (empty($sale->installments->where('status_parcela', 'PAGO')->shift())) {

                $sale->deleteSaleInstallments();

            } else {
                return redirect()->back()->with('error', 'Não foi possível atualizar a venda pois já existem parcelas que foram pagas!');
            }

            if ($request->has('valor_parcela')) {

                $sale->createSaleInstallments($request);

            } else {

                $sale->createSalePayment($request->data_venda,$sale->budget->total,'Pagamento de venda à vista.');

            }

        } else {

            if ($request->has('valor_parcela')) {
                $payment = $sale->getSalePayment();
                Financial::createFinancial([
                    'tipo' => 'DESPESA',
                    'descricao' => 'Venda atualizada de à vista para à prazo.',
                    'valor' => $payment->valor_pago
                ]);

                $payment->deletePayment();

                $sale->createSaleInstallments($request);

            }

        }

        $sale->updateSale($request->all());

        $budget = $sale->budget;
        $client = new Client();
        $client = $client->findClientById($budget->cliente_id);
        if($client)
            $client->updateStatus();

        if ($sale) {
            return redirect()->back()->with('success', 'Venda atualizada com sucesso');
        }

    }

    public function destroy($id)
    {
        $sale = $this->sale->findSaleById($id);
        if ($sale) {
            $mensagem = '';
            if ($sale->budget->status === 'APROVADO') {
                foreach ($sale->storages as $storage) {

                    $qtdentrada = $storage->pivot->qtd_reservada;
                    if ($storage->qtd !== null) {
                        $storage->updateStorage('qtd',($storage->qtd + $qtdentrada));
                    } elseif ($storage->metros_quadrados !== null) {
                        $storage->updateStorage('metros_quadrados',($storage->metros_quadrados + $qtdentrada));
                    }
                    $mensagem = ', materiais em uso retornaram ao estoque!';
                }
                if ($sale->tipo_pagamento === 'A VISTA') {
                    $payment = $sale->getSalePayment();
                    Financial::createFinancial([
                        'tipo' => 'DESPESA',
                        'descricao' => 'Cancelamento de venda à vista.',
                        'valor' => $payment->valor_pago
                    ]);
                }
            }

            $sale->budget->updateBudget(['status' => 'AGUARDANDO']);

            $budget = $sale->budget;

            $sale->deleteSale();

            $client = new Client();
            $client = $client->findClientById($budget->cliente_id);
            if($client)
                $client->updateStatus();

            return redirect()->back()->with('success', 'Venda deletada com sucesso' . $mensagem);
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar venda');
        }
    }

    public function pay($id)
    {
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

        $validado = $this->rules_sale_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('sales.index'))->withErrors($validado);
        }

        $installments = null;

        if ($request->data_pagamento === null) {
            return redirect()->back()->with('error', 'Selecione a data do pagamento!');
        }
        if ($request->parcelas !== null) {

            $installments = Installment::getInstallmentsWherein($request->parcelas);
            $sale = $this->sale->findSaleById($id);


            foreach ($installments as $installment) {

                $sale->createSalePayment($request->data_pagamento,$installment->valor_parcela,'Parcela paga.');

                $installment->updateInstallment('status_parcela','PAGO');
            }


            $budget = $sale->budget;
            $client = new Client();
            $client = $client->findClientById($budget->cliente_id);
            $client->updateStatus();


        } else {
            return redirect()->back()->with('error', 'Marque pelo menos uma parcela!');
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
                    'data_venda' => 'required|date'
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
