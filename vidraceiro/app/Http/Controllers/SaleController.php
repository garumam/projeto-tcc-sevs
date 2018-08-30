<?php

namespace App\Http\Controllers;

use App\Installment;
use App\Payment;
use Illuminate\Http\Request;
use App\Sale;
use App\Client;
use App\Budget;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sales = Sale::all();

        return view('dashboard.list.sale', compact('sales'))->with('title', 'Vendas');
    }

    public function create()
    {
        $budgets = Budget::where('status','AGUARDANDO')->get();
        return view('dashboard.create.sale' ,compact('budgets'))->with('title', 'Nova venda');
    }

    public function store(Request $request)
    {

        /*$validado = $this->rules_sale($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }*/
        $sale = new Sale();
        $sale = $sale->create($request->except('valor_parcela'));

        if($request->has('valor_parcela')){


            for($i = 1; $i <= $request->qtd_parcelas; $i++){
                $installments = new Installment();
                $dias = $i * 30;
                $datavencimento = date('Y-m-d', strtotime("+$dias days",strtotime($request->data_venda)));
                $installments->create([
                    'valor_parcela'=>$request->valor_parcela,
                    'status_parcela'=>'ABERTO',
                    'data_vencimento'=> $datavencimento,
                    'venda_id'=> $sale->id
                ]);
            }


        }else{

            $payment = new Payment();
            $payment->create([
                'valor_pago'=> $sale->budget->total,
                'data_pagamento'=>$request->data_venda,
                'venda_id'=>$sale->id
            ]);

        }

        if ($sale){
            $sale->budget->update(['status'=>'APROVADO']);
            return redirect()->back()->with('success', 'Venda realizada com sucesso');
        }

    }

    public function show()
    {

    }

    public function edit($id)
    {
        $states = $this->states;
        $client = Client::find($id);
        return view('dashboard.create.client', compact('client','states'))->with('title', 'Atualizar cliente');
    }


    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        $docvalidation = null;
        $arraydocnull = null;
        if($request->has('cpf')){
            $docvalidation = ['cpf' => 'required|string|unique:clients,cpf,'.$id.'|min:11|max:20'];
            $arraydocnull = ['cnpj' => null];
        }elseif($request->has('cnpj')){
            $docvalidation = ['cnpj' => 'required|string|unique:clients,cnpj,'.$id.'|min:14|max:20'];
            $arraydocnull = ['cpf' => null];
        }else{
            $docvalidation = ['cnpj' => 'required', 'cpf' => 'required'];
        }

        $validado = $this->rules_sale($request->all(),$docvalidation);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $client->update(array_merge($request->except('att_budgets'),$arraydocnull));
        if ($client){
            $mensagem = 'Cliente atualizado com sucesso';
            if($request->att_budgets != null){

                foreach($client->budgets as $budget){
                    $budget->update($request->except('nome','cpf','email','celular','att_budgets'));
                }
                $mensagem = 'Cliente e orçamentos atualizados com sucesso';
            }
            return redirect()->back()->with('success', $mensagem);
        }

    }

    public function destroy($id)
    {
        $sale = Sale::find($id);
        if ($sale) {
            $sale->budget->update(['status'=>'AGUARDANDO']);
            $sale->delete();
            return redirect()->back()->with('success', 'Venda deletada com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar venda');
        }
    }

    public function rules_sale(array $data)
    {
        $validator = Validator::make($data,

            [
                'nome' => 'required|string|max:255',
                'telefone' => 'nullable|string|min:10|max:20',
                'cep' => 'required|string|min:8|max:8',
                'endereco' => 'nullable|string|max:255',
                'bairro' => 'nullable|string|max:255',
                'cidade' => 'nullable|string|max:255',
                'uf' => 'nullable|string|max:255',
                'complemento' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'celular' => 'nullable|string|min:10|max:20'
            ]

        );

        return $validator;
    }
}
