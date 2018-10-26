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
use Illuminate\Support\Facades\Auth;

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

                if(!Auth::user()->can('orcamento_relatorio', Budget::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $status = [
                    'TODOS'=>'Todos',
                    'AGUARDANDO'=>'Aguardando',
                    'APROVADO'=>'Aprovado',
                    'FINALIZADO'=>'Finalizado'
                ];

                return view('dashboard.create.relatorios', compact('status'))->with('title', 'Relatório de Orçamentos')->with('tipo',$tipo);

                break;
            case 'orders':

                if(!Auth::user()->can('os_relatorio', Order::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

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

                if(!Auth::user()->can('estoque_relatorio', Storage::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $materials = [
                    'TODOS'=>'Todos',
                    'glass_id'=>'Vidro',
                    'aluminum_id'=>'Alumínio',
                    'component_id'=>'Componente'
                ];
                return view('dashboard.create.relatorios',compact('materials'))->with('title', 'Relatório de Estoque')->with('tipo',$tipo);

                break;
            case 'financial':

                if(!Auth::user()->can('financeiro_relatorio', Financial::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $tipos = [
                    'TODOS'=>'Todos',
                    'RECEITA'=>'Receitas',
                    'DESPESA'=>'Despesas'
                ];
                return view('dashboard.create.relatorios', compact('tipos'))->with('title', 'Relatório do Financeiro')->with('tipo',$tipo);

                break;
            case 'clients':

                if(!Auth::user()->can('cliente_relatorio', Client::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $status = [
                    'TODOS'=>'Todos',
                    'EM DIA'=>'Em dia',
                    'DEVENDO'=>'Devendo'
                ];
                return view('dashboard.create.relatorios', compact('status'))->with('title', 'Relatório de Clientes')->with('tipo',$tipo);

                break;
            case 'providers':

                if(!Auth::user()->can('fornecedor_relatorio', Provider::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $situacoes = [
                    'TODAS'=>'Todas',
                    'ativo'=>'Ativo',
                    'desativado'=>'Desativado'
                ];
                return view('dashboard.create.relatorios', compact('situacoes'))->with('title', 'Relatório de Fornecedores')->with('tipo',$tipo);

                break;
            case 'sales':

                if(!Auth::user()->can('venda_relatorio', Sale::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $formas_pagamento = [
                    'TODAS'=>'Todas',
                    'A VISTA'=>'À vista',
                    'A PRAZO'=>'A prazo'
                ];
                return view('dashboard.create.relatorios', compact('formas_pagamento'))->with('title', 'Relatório de Vendas')->with('tipo',$tipo);

                break;
        }

    }


    //O show MOSTRA OS PDFS NOS MENUS RESPECTIVAS(BUDGETS, ORDER E ETC..)
    public function show($tipo, $id)
    {
        $company = new Company();
        $company = $company->getCompany();
        $pdf = null;
        $nomearquivo = '';

        switch($tipo){
            case 'budget':
                $budget = new Budget();
                $budget = $budget->findBudgetById($id);
                $pdf = PDF::loadView('dashboard.pdf.budget', compact('budget','company'));
                $nomearquivo = 'orcamento.pdf';

                break;
            case 'order':
                $order = new Order();
                $order = $order->findOrderById($id);
                //$order = Order::with('budgets.products')->find($id);
                $pdf = PDF::loadView('dashboard.pdf.order', compact('order','company'));
                $nomearquivo = 'ordem_servico.pdf';

                break;
            case 'order-comprar':
                $order = new Order();
                $order = $order->findOrderById($id);
                $pdf = PDF::loadView('dashboard.pdf.order-comprar', compact('order','company'));
                $nomearquivo = 'OS_comprar.pdf';

                break;
            case 'client':
                $client = new Client();
                $client = $client->findClientById($id);
                $pdf = PDF::loadView('dashboard.pdf.client', compact('client','company'));
                $nomearquivo = 'cliente.pdf';

                break;
            case 'sale':
                $sale = new Sale();
                $sale = $sale->findSaleById($id);
                $pdf = PDF::loadView('dashboard.pdf.sale', compact('sale','company'));
                $nomearquivo = 'venda.pdf';

                break;
            case 'provider':
                $provider = new Provider();
                $provider = $provider->findProviderById($id);
                $pdf = PDF::loadView('dashboard.pdf.provider', compact('provider','company'));
                $nomearquivo = 'fornecedor.pdf';

                break;
        }

        return $pdf->stream($nomearquivo);

    }

    //O showRelatorio MOSTRA OS RELATORIOS DO MENU RELATORIOS
    public function showRelatorio(Request $request , $tipo){
        $pdf = null;
        $nomearquivo = '';
        switch($tipo){
            case 'budgets':

                if(!Auth::user()->can('orcamento_relatorio', Budget::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $budgets = Budget::filterBudgets($request);

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('budgets','tipo'));
                $nomearquivo = 'orcamento-relatório.pdf';

                break;
            case 'orders':

                if(!Auth::user()->can('os_relatorio', Order::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $orders = Order::filterOrders($request);

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('orders','tipo'));
                $nomearquivo = 'ordem-de-serviço-relatório.pdf';

                break;
            case 'storage':

                if(!Auth::user()->can('estoque_relatorio', Storage::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $glasses = null;
                $aluminums = null;
                $components = null;

                Storage::filterStorages($request,$glasses,$aluminums,$components);

                $pdf = PDF::loadView('dashboard.pdf.relatorios',
                    compact('tipo','glasses','aluminums','components'));
                $nomearquivo = 'estoque-relatório.pdf';
                break;
            case 'financial':

                if(!Auth::user()->can('financeiro_relatorio', Financial::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $financials = Financial::filterFinancial($request);

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('financials','tipo'));
                $nomearquivo = 'financeiro-relatório.pdf';

                break;
            case 'clients':

                if(!Auth::user()->can('cliente_relatorio', Client::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $clients = Client::filterClients($request);

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('clients','tipo'));
                $nomearquivo = 'cliente-relatório.pdf';


                break;
            case 'providers':

                if(!Auth::user()->can('fornecedor_relatorio', Provider::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $providers = Provider::filterProviders($request);

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('providers','tipo'));
                $nomearquivo = 'fornecedor-relatório.pdf';


                break;
            case 'sales':

                if(!Auth::user()->can('venda_relatorio', Provider::class)){
                    return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
                }

                $sales = Sale::filterSales($request);

                $pdf = PDF::loadView('dashboard.pdf.relatorios', compact('sales','tipo'));
                $nomearquivo = 'venda-relatório.pdf';


                break;

        }

        return $pdf->stream($nomearquivo);
    }


    public static function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)
        {
            if($mask[$i] == '#')
            {
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else
            {
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }


}
