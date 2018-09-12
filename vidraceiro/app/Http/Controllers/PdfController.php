<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Order;
use App\Company;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // O index EXIBE A VIEW DE CADA SUBMENU
    public function index($tipo)
    {
        switch($tipo){
            case 'budgets':
                $status = [
                    'TODOS'=>'Todos',
                    'AGUARDANDO'=>'Aguardando',
                    'APROVADO'=>'Aprovado',
                    'FINALIZADO'=>'Finalizado'
                ];

                return view('dashboard.create.relatorios', compact('status'))->with('title', 'Relatório de Orçamentos')->with('tipo',$tipo);

                break;
            case 'orders':
                $situacao = [
                    'TODAS'=>'Todas',
                    'ABERTA'=>'Aberta',
                    'ANDAMENTO'=>'Em andamento',
                    'CONCLUIDA'=>'Concluída',
                    'CANCELADA'=>'Cancelada'
                ];
                return view('dashboard.create.relatorios', compact('situacao'))->with('title', 'Relatório de Ordens de serviço')->with('tipo',$tipo);

                break;
            case 'storage':
                return view('dashboard.create.relatorios')->with('title', 'Relatório de Estoque')->with('tipo',$tipo);

                break;
            case 'financial':
                return view('dashboard.create.relatorios')->with('title', 'Relatório do Financeiro')->with('tipo',$tipo);

                break;
            case 'clients':
                return view('dashboard.create.relatorios')->with('title', 'Relatório de Clientes')->with('tipo',$tipo);

                break;
        }

    }


    //O show MOSTRA OS PDFS NOS MENUS RESPECTIVAS(BUDGETS, ORDER E ETC..)
    public function show(Request $request , $tipo, $id)
    {
        $company = Company::all()->first();
        $pdf = null;
        $nomearquivo = '';

        switch($tipo){
            case 'budget':

                $budget = Budget::with('products')->find($id);
                $pdf = PDF::loadView('dashboard.pdf.budget', compact('budget','company'));
                $nomearquivo = 'orcamento.pdf';

                break;
            case 'order':

                $order = Order::with('budgets.products')->find($id);
                $pdf = PDF::loadView('dashboard.pdf.order', compact('order','company'));
                $nomearquivo = 'ordem_servico.pdf';

                break;
        }

        return $pdf->stream($nomearquivo);

        /*$company = Company::all()->first();
        $pdf = null;
        $nomearquivo = '';
        if($request->has('idorcamento') && $request->idorcamento != ''){
            $budget = Budget::with('products')->find($request->idorcamento);
            $pdf = PDF::loadView('dashboard.pdf.budget', compact('budget','company'));
            $nomearquivo = 'orcamento.pdf';
        }else{
            $order = Order::with('budgets.products')->find($request->idordem);
            $pdf = PDF::loadView('dashboard.pdf.order', compact('order','company'));
            $nomearquivo = 'ordem_servico.pdf';
        }


        return $pdf->stream($nomearquivo);*/
    }

    //O showRelatorio MOSTRA OS RELATORIOS DO MENU RELATORIOS
    public function showRelatorio(Request $request , $tipo){
        $pdf = null;
        $nomearquivo = '';
        switch($tipo){
            case 'budgets':
                $status = $request->status;
                $budgets = null;
                $totalde = $request->total_de;
                $totalate = $request->total_ate;

                if($totalde < $totalate){
                    $budgets =  Budget::whereBetween('total', [$totalde, $totalate]);
                }else{
                    $budgets = new Budget;
                }
                if($status === 'TODOS'){
                    $budgets = $budgets->get();
                }else{
                    $budgets = $budgets->where('status',$status)->get();
                }

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('budgets','tipo'));
                $nomearquivo = 'orcamento-relatório.pdf';

                break;
            case 'orders':

                $situacao = $request->situacao;
                $orders = new Order();
                $totalde = $request->total_de;
                $totalate = $request->total_ate;
                $data_inicial = $request->data_inicial;
                $data_final = $request->data_final;
                $between = false;
                if($totalde < $totalate){
                    //$orders =  Order::whereBetween('total', [$totalde, $totalate]);
                    $orders =  Order::where(function ($query) use ($totalde,$totalate){
                        $query->where('total', '>=' ,$totalde);
                        $query->where('total', '<=' ,$totalate);
                    });
                    //$between = true;
                }

                if(strtotime($data_inicial) < strtotime($data_final)){

                        $orders =  Order::where(function ($query) use ($data_inicial,$data_final){
                            $query->where('data_inicial', '>=' ,$data_inicial);
                            $query->where('data_inicial', '<=' ,$data_final);
                        });
                        //$orders =  Order::whereBetween('data_inicial', [$data_inicial, $data_final]);

                }

                if($situacao === 'TODAS'){
                    $orders = $orders->get();
                }else{
                    $orders = $orders->where('situacao',$situacao)->get();
                }

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('orders','tipo'));
                $nomearquivo = 'orcamento-relatório.pdf';

                break;
            case 'storage':


                break;
            case 'financial':


                break;
            case 'clients':


                break;
        }

        return $pdf->stream($nomearquivo);
    }

}
