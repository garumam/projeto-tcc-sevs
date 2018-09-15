<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Client;
use App\Financial;
use App\Order;
use App\Company;
use App\Provider;
use App\Storage;
use App\Sale;
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
                $status = [
                    'TODOS'=>'Todos',
                    'ABERTA'=>'Aberta',
                    'ANDAMENTO'=>'Em andamento',
                    'CONCLUIDA'=>'Concluída',
                    'CANCELADA'=>'Cancelada'
                ];
                return view('dashboard.create.relatorios', compact('status'))->with('title', 'Relatório de Ordens de serviço')->with('tipo',$tipo);

                break;
            case 'storage':
                $materials = [
                    'TODOS'=>'Todos',
                    'glass_id'=>'Vidro',
                    'aluminum_id'=>'Alumínio',
                    'component_id'=>'Componente'
                ];
                return view('dashboard.create.relatorios',compact('materials'))->with('title', 'Relatório de Estoque')->with('tipo',$tipo);

                break;
            case 'financial':
                $tipos = [
                    'TODOS'=>'Todos',
                    'RECEITA'=>'Receitas',
                    'DESPESA'=>'Despesas'
                ];
                return view('dashboard.create.relatorios', compact('tipos'))->with('title', 'Relatório do Financeiro')->with('tipo',$tipo);

                break;
            case 'clients':
                $status = [
                    'TODOS'=>'Todos',
                    'EM DIA'=>'Em dia',
                    'DEVENDO'=>'Devendo'
                ];
                return view('dashboard.create.relatorios', compact('status'))->with('title', 'Relatório de Clientes')->with('tipo',$tipo);

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
            case 'order_comprar_pdf':
                $order = Order::find($id);
                $pdf = PDF::loadView('dashboard.pdf.order_compra', compact('order'));
                $nomearquivo = 'OS_comprar.pdf';

                break;
            case 'client_pdf':
                $client = Client::find($id);
                $pdf = PDF::loadView('dashboard.pdf.client', compact('client'));
                $nomearquivo = 'cliente.pdf';

                break;
            case 'sale_pdf':
                $sale = Sale::find($id);
                $pdf = PDF::loadView('dashboard.pdf.sale', compact('sale'));
                $nomearquivo = 'venda.pdf';

                break;
            case 'provider_pdf':
                $provider = Provider::find($id);
                $pdf = PDF::loadView('dashboard.pdf.provider', compact('provider'));
                $nomearquivo = 'fornecedor.pdf';

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
                $budgets = new Budget();
                $totalde = $request->total_de;
                $totalate = $request->total_ate;
                $data_inicial = $request->data_inicial;
                $data_final = $request->data_final;
                $totalentrou = $dataentrou = false;
                if($totalde < $totalate){
                    $totalentrou = true;
                }
                if(strtotime($data_inicial) < strtotime($data_final)){
                    $dataentrou = true;
                }

                if($totalentrou || $dataentrou){
                    $budgets =  Budget::where(function ($query) use ($data_inicial,$data_final, $totalde,$totalate,$totalentrou,$dataentrou){
                        if($dataentrou){
                            $query->whereBetween('data', [$data_inicial,$data_final]);
                        }

                        if($totalentrou){
                            $query->whereBetween('total', [$totalde,$totalate]);
                        }
                    });
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

                $situacao = $request->status;
                $orders = new Order();
                $totalde = $request->total_de;
                $totalate = $request->total_ate;
                $data_inicial = $request->data_inicial;
                $data_final = $request->data_final;
                $totalentrou = $dataentrou = false;
                if($totalde < $totalate){
                    $totalentrou = true;
                }

                if(strtotime($data_inicial) < strtotime($data_final)){

                    $dataentrou = true;
                }

                if($totalentrou || $dataentrou){

                    $orders =  Order::where(function ($query) use ($data_inicial,$data_final, $totalde,$totalate,$totalentrou,$dataentrou){
                        if($dataentrou){
                            $query->whereBetween('data_inicial', [$data_inicial,$data_final]);
                        }

                        if($totalentrou){
                            $query->whereBetween('total', [$totalde,$totalate]);
                        }
                    });
                }

                if($situacao === 'TODOS'){
                    $orders = $orders->get();
                }else{
                    $orders = $orders->where('situacao',$situacao)->get();
                }

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('orders','tipo'));
                $nomearquivo = 'ordem-de-serviço-relatório.pdf';

                break;
            case 'storage':

                $material = $request->material;
                $qtd_de = $request->qtd_de;
                $qtd_ate = $request->qtd_ate;
                $ordenar = $request->ordenar;
                $glasses = null;
                $aluminums = null;
                $components = null;
                if($material === 'TODOS') {
                    $glasses = Storage::with('glass')->where('glass_id', '!=', null);
                    $aluminums = Storage::with('aluminum')->where('aluminum_id', '!=', null);
                    $components = Storage::with('component')->where('component_id', '!=', null);
                }else{
                    if($material === 'glass_id'){
                        $glasses = Storage::with('glass')->where('glass_id', '!=', null);
                    }elseif($material === 'aluminum_id'){
                        $aluminums = Storage::with('aluminum')->where('aluminum_id', '!=', null);
                    }elseif($material === 'component_id'){
                        $components = Storage::with('component')->where('component_id', '!=', null);
                    }
                }
                if($qtd_de < $qtd_ate){
                    if($material === 'TODOS'){
                        $glasses = $glasses->whereBetween('metros_quadrados', [$qtd_de,$qtd_ate]);
                        $aluminums = $aluminums->whereBetween('qtd', [$qtd_de,$qtd_ate]);
                        $components = $components->whereBetween('qtd', [$qtd_de,$qtd_ate]);
                    }else{
                        if($material === 'glass_id'){
                            $glasses = $glasses->whereBetween('metros_quadrados', [$qtd_de,$qtd_ate]);
                        }elseif($material === 'aluminum_id'){
                            $aluminums = $aluminums->whereBetween('qtd', [$qtd_de,$qtd_ate]);
                        }elseif($material === 'component_id'){
                            $components = $components->whereBetween('qtd', [$qtd_de,$qtd_ate]);
                        }
                    }
                }
                if($ordenar !== 'nao') {
                    if ($material === 'TODOS') {
                        $glasses = $glasses->orderBy('metros_quadrados',$ordenar);
                        $aluminums = $aluminums->orderBy('qtd',$ordenar);
                        $components = $components->orderBy('qtd',$ordenar);
                    } else {
                        if ($glasses !== null) {
                            $glasses = $glasses->orderBy('metros_quadrados',$ordenar);
                        } elseif ($aluminums !== null) {
                            $aluminums = $aluminums->orderBy('qtd',$ordenar);
                        } elseif ($components !== null) {
                            $components = $components->orderBy('qtd',$ordenar);
                        }
                    }
                }
                if($material === 'TODOS'){
                    $glasses = $glasses->get();
                    $aluminums = $aluminums->get();
                    $components = $components->get();
                }else{
                    if($glasses !== null){
                        $glasses = $glasses->get();
                    }elseif($aluminums !== null){
                        $aluminums = $aluminums->get();
                    }elseif($components !== null){
                        $components = $components->get();
                    }
                }

                $pdf = PDF::loadView('dashboard.pdf.relatorios',
                    compact('tipo','glasses','aluminums','components'));
                $nomearquivo = 'estoque-relatório.pdf';
                break;
            case 'financial':


                $tipo_financa = $request->tipo_financa;
                $financials = new Financial();
                $valor_inicial = $request->valor_inicial;
                $valor_final = $request->valor_final;
                $data_inicial = $request->data_inicial;
                $data_final = $request->data_final;
                $valorentrou = $dataentrou = false;
                if($valor_inicial < $valor_final){
                    $valorentrou = true;
                }

                if(strtotime($data_inicial) < strtotime($data_final)){

                    $dataentrou = true;
                }

                if($valorentrou || $dataentrou){

                    $financials =  Financial::where(function ($query) use ($data_inicial,$data_final, $valor_inicial,$valor_final,$valorentrou,$dataentrou){
                        if($dataentrou){
                            $query->whereBetween('created_at', [$data_inicial,$data_final]);
                        }

                        if($valorentrou){
                            $query->whereBetween('valor', [$valor_inicial,$valor_final]);
                        }
                    });
                }

                if($tipo_financa === 'TODOS'){
                    $financials = $financials->get();
                }else{
                    $financials = $financials->where('tipo',$tipo_financa)->get();
                }

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('financials','tipo'));
                $nomearquivo = 'financeiro-relatório.pdf';


                break;
            case 'clients':
                $status = $request->status;
                $data_inicial = $request->data_inicial;
                $data_final = $request->data_final;
                $clients = new Client();

                if(strtotime($data_inicial) < strtotime($data_final)){
                    $clients = $clients->whereBetween('created_at', [$data_inicial,$data_final]);
                }

                if($status === 'TODOS'){
                    $clients = $clients->get();
                }else{
                    $clients = $clients->where('status',$status)->get();
                }

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('clients','tipo'));
                $nomearquivo = 'cliente-relatório.pdf';


                break;
        }

        return $pdf->stream($nomearquivo);
    }

}
