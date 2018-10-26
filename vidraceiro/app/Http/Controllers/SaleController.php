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

        //$salesWithInstallments =  $this->sale->getSaleInstallmentsWithSearchAndPagination($request->get('search'),$request->get('paginate'));

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
        return view('dashboard.create.sale', compact('budgets'))->with('title', 'Nova venda');
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

        $sale = $this->sale->createSale(array_merge($request->all(),['usuario_id'=>Auth::user()->id]));

        if ($request->has('valor_parcela')) {

            $sale->createSaleInstallments($request);

        } else {

            $sale->createSalePayment($request->data_venda,$sale->budget->total,'Pagamento de venda à vista.',Auth::user()->id);

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

//    public function edit($id)
//    {
//        if(!Auth::user()->can('venda_atualizar', Sale::class)){
//            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
//        }
//
//        $validado = $this->rules_sale_exists(['id'=>$id]);
//
//        if ($validado->fails()) {
//            return redirect(route('sales.index'))->withErrors($validado);
//        }
//
//        $sale = $this->sale->findSaleById($id);
//
//        if($sale->budget->ordem_id !== null || $sale->havePayments()){
//            return redirect(route('sales.index'))->with('error','Esta venda não pode ser editada!');
//        }
//
//        $budgets = Budget::getBudgetsWhereStatusWaiting();
//
//        return view('dashboard.create.sale', compact('sale','budgets'))->with('title', 'Atualizar venda');
//    }
//
//
//    public function update(Request $request, $id)
//    {
//        if(!Auth::user()->can('venda_atualizar', Sale::class)){
//            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
//        }
//
//        $validado = $this->rules_sale_exists(['id'=>$id]);
//
//        if ($validado->fails()) {
//            return redirect(route('sales.index'))->withErrors($validado);
//        }
//
//        $sale = $this->sale->findSaleById($id);
//
//        $arrayextra = [];
//        if ($request->tipo_pagamento === 'A PRAZO') {
//
//            $arrayextra = [
//                'orcamento_id' => 'required|integer|unique:sales,orcamento_id,'.$sale->id,
//                'valor_parcela' => 'required|numeric',
//                'qtd_parcelas' => 'required|integer'
//            ];
//
//        }else {
//
//            $arrayextra = [
//                'orcamento_id' => 'required|integer|unique:sales,orcamento_id,'.$sale->id
//            ];
//
//        }
//
//        $validado = $this->rules_sale($request->all(), $arrayextra);
//        if ($validado->fails()) {
//            return redirect()->back()->withErrors($validado);
//        }
//
//        if($request->orcamento_id != $sale->budget->id){
//            $sale->budget->updateBudget(['status'=>'AGUARDANDO']);
//        }
//
//        if ($sale->tipo_pagamento === 'A PRAZO') {
//
//            if (empty($sale->installments->where('status_parcela', 'PAGO')->shift())) {
//
//                $sale->deleteSaleInstallments();
//
//            } else {
//                return redirect()->back()->with('error', 'Não foi possível atualizar a venda pois já existem parcelas que foram pagas!');
//            }
//
//            if ($request->has('valor_parcela')) {
//
//                $sale->createSaleInstallments($request);
//
//            } else {
//
//                $sale->createSalePayment($request->data_venda,$sale->budget->total,'Pagamento de venda à vista.');
//
//            }
//
//        } else {
//
//            if ($request->has('valor_parcela')) {
//                /*$payment = $sale->getSalePayment();
//                Financial::createFinancial([
//                    'tipo' => 'DESPESA',
//                    'descricao' => 'Venda atualizada de à vista para à prazo.',
//                    'valor' => $payment->valor_pago
//                ]);
//
//                $payment->deletePayment();*/
//
//                $sale->createSaleInstallments($request);
//
//            }
//
//        }
//
//        $sale->updateSale($request->all());
//
//        $budget = $sale->budget;
//        $client = new Client();
//        $client = $client->findClientById($budget->cliente_id);
//        if($client)
//            $client->updateStatus();
//
//        if ($sale) {
//            return redirect()->back()->with('success', 'Venda atualizada com sucesso');
//        }
//
//    }
//
//    public function destroy($id)
//    {
//        if(!Auth::user()->can('venda_deletar', Sale::class)){
//            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
//        }
//
//        $sale = $this->sale->findSaleById($id);
//        if ($sale) {
//
//            if($sale->budget->ordem_id !== null){
//                $order = new Order();
//                $order = $order->findOrderById($sale->budget->ordem_id);
//                if($order->situacao === 'ABERTA' || $order->situacao === 'ANDAMENTO'){
//                    return redirect(route('sales.index'))->with('error','Esta venda não pode ser deletada!');
//                }
//
//                if(!$sale->havePayments() || $sale->havePendingInstallment()){
//                    return redirect(route('sales.index'))->with('error','Esta venda não pode ser deletada!');
//                }
//
//                if($order->situacao === 'CONCLUIDA'){
//                    //SOFT DELETE
//                    $sale->deleteSale();
//                    return redirect()->back()->with('success', 'Venda deletada com sucesso');
//                }
//            }else{
//
//                if($sale->havePayments()){
//                    return redirect(route('sales.index'))->with('error','Esta venda não pode ser deletada!');
//                }
//
//            }
//
//
//            $mensagem = '';
//            if ($sale->budget->status === 'APROVADO') {
//                foreach ($sale->storages as $storage) {
//
//                    $qtdentrada = $storage->pivot->qtd_reservada;
//                    if ($storage->qtd !== null) {
//                        $storage->updateStorage('qtd',($storage->qtd + $qtdentrada));
//                    } elseif ($storage->metros_quadrados !== null) {
//                        $storage->updateStorage('metros_quadrados',($storage->metros_quadrados + $qtdentrada));
//                    }
//                    $mensagem = ', materiais em uso retornaram ao estoque!';
//                }
//                /*if ($sale->tipo_pagamento === 'A VISTA') {
//                    $payment = $sale->getSalePayment();
//                    Financial::createFinancial([
//                        'tipo' => 'DESPESA',
//                        'descricao' => 'Cancelamento de venda à vista.',
//                        'valor' => $payment->valor_pago
//                    ]);
//                }*/
//            }
//            if($sale->budget->status !== 'FINALIZADO'){
//                $sale->budget->updateBudget(['status' => 'AGUARDANDO','ordem_id'=>null]);
//            }
//
//            $budget = $sale->budget;
//            // força deletar do banco
//            $sale->forceDelete();
//
//            $client = new Client();
//            $client = $client->findClientById($budget->cliente_id);
//            if($client)
//                $client->updateStatus();
//
//            return redirect()->back()->with('success', 'Venda deletada com sucesso' . $mensagem);
//        } else {
//            return redirect()->back()->with('error', 'Erro ao deletar venda');
//        }
//    }

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
