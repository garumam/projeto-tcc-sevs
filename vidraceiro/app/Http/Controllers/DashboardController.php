<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Budget;
use App\Category;
use App\Component;
use App\Financial;
use App\Glass;
use App\MProduct;
use App\Order;
use App\Provider;
use App\Sale;
use App\User;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $totalusers = User::all()->count();
        $totalsales = Sale::all()->count();
        $financials = Financial::all('valor', 'tipo');
        $totalreceita = $totaldespesa = null;
        foreach ($financials as $total) {
            if ($total->tipo == 'RECEITA') {
                $totalreceita += $total->valor;
            } else {
                $totaldespesa += $total->valor;
            }
        }
        $totalbudgets = Budget::all()->count();
        $totalproviders = Provider::all()->count();
        $totalorders = Order::all()->count();
        $clients = Client::all()->count();
        $ordersOpen = Order::all()->where('situacao', '=', 'ABERTA');

        $budgets = new Budget();
        $budgetsOpen = $budgets->getWithSearchAndPagination(null, null, false, 'APROVADO');
        if ($request->has('ordens') || !$request->ajax()) {
            $orders = new Order();
//            $orders = $orders->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),false,'ABERTA');
            $orders = $orders->getWithSearchAndPagination($request->get('search'), 1, false, 'ABERTA');
        }
        if ($request->has('orcamentos') || !$request->ajax()) {

//            $budgets = $budgets->getWithSearchAndPagination($request->get('search'), $request->get('paginate'), false, 'APROVADO');
            $budgets = $budgets->getWithSearchAndPagination($request->get('search'), 1, false, 'APROVADO');
        }
        if ($request->ajax()) {
            if ($request->has('ordens'))
                return view('dashboard.list.tables.table-order', compact('orders'));
            if ($request->has('orcamentos'))
                return view('dashboard.list.tables.table-budget', compact('budgets'));
        }

        return view('dashboard.home', compact('totalusers', 'totalsales', 'totalreceita', 'totaldespesa', 'totalbudgets', 'totalorders', 'totalproviders', 'clients', 'orders', 'budgets', 'ordersOpen', 'budgetsOpen'))->with('title', 'Dashboard');
    }

    public function sales()
    {
        /*$sales[] = DB::table('sales')->whereMonth('data_venda', '=', '01')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '02')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '03')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '04')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '05')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '06')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '07')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '08')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '09')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '10')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '11')->count();
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '12')->count();*/

        $sales = DB::table('sales')->get();
        $salesArray = $this->getMonth($sales,true);
//        $salesArray = [];
//        for ($i = 1; $i <= 12; $i++) {
//            $salesArray[] = $sales->filter(function ($value) use ($i) {
//                $mes = substr($value->data_venda, 5, 2);
//                if ($i < 10)
//                    return $mes == '0' . $i;
//
//                return $mes == $i;
//            })->count();
//        }


        return response()->json($salesArray);
    }

    function getMonth($objeto, $data = false)
    {
        $meses = [];
        for ($i = 1; $i <= 12; $i++) {
            $meses[] = $objeto->filter(function ($value) use ($i, $data) {
                if ($data){
                    $mes = substr($value->data_venda, 5, 2);
                } else{
                    $mes = substr($value->created_at, 5, 2);
                }

                if ($i < 10)
                    return $mes == '0' . $i;

                return $mes == $i;
            })->count();
        }
        return $meses;
    }

    public function financial()
    {

        $receitaperiodos = $despesasperiodos = null;

        $financials = Financial::all();
        $this->getPeriods($financials,$receitaperiodos,$despesasperiodos,'financial');

        return response()->json(array('receitas' => $receitaperiodos, 'despesas' => $despesasperiodos));
    }


    public function orders()
    {
        /*$ordermconcluida= Order::all()->where('situacao', '=', 'CONCLUIDA');
        $ordermconcluida = $this->getMonth($ordermconcluida);

        $ordermcancelada = Order::all()->where('situacao', '=', 'CANCELADA');
        $ordermcancelada = $this->getMonth($ordermcancelada);*/

        $ordens = Order::where('situacao','CONCLUIDA')->orWhere('situacao','CANCELADA')->get();
        $ordermconcluida = $ordermcancelada = null;

        $this->getPeriods($ordens,$ordermconcluida,$ordermcancelada,'order');

        return response()->json(array('concluidas' => $ordermconcluida, 'canceladas' => $ordermcancelada));
    }

    public function clients()
    {
        $clients = Client::all();
        $clientesarray[] = $clients->where('status','=','EM DIA')->count();
        $clientesarray[] = $clients->where('status','=','DEVENDO')->count();

        return response()->json(array('clientes' => $clientesarray));
    }

    public function budgets()
    {
        $budgets = Budget::where('status','APROVADO')->orWhere('status','FINALIZADO')->get();
        $budgetsaprovado = $budgetsfinalizado = null;

        $this->getPeriods($budgets,$budgetsaprovado,$budgetsfinalizado,'budget');

        return response()->json(array('aprovados' => $budgetsaprovado, 'finalizados' => $budgetsfinalizado));
    }


    public function getPeriods($objects,&$firstArgument,&$secondArgument,$modelName){


        $periodos = ['anual','semestre','mes','semana','hoje'];

        foreach($periodos as $value) {
            $data_inicial = $data_final = date_format(date_create(today()), 'Y-m-d');

            switch ($value){
                case 'hoje':
                    break;
                case 'semana':

                    $data_inicial = date('Y-m-d', strtotime("-6 days", strtotime($data_inicial)));

                    break;
                case 'mes':

                    $data_inicial = date('Y-m-d', strtotime("-29 days", strtotime($data_inicial)));

                    break;
                case 'semestre':

                    $data_inicial = date('Y-m-d', strtotime("-179 days", strtotime($data_inicial)));

                    break;
                case 'anual':

                    $data_inicial = date('Y-m-d', strtotime("-359 days", strtotime($data_inicial)));

                    break;
            }


            $objectsfilter = $objects->filter(function ($object) use($data_inicial,$data_final,$modelName){
                if($modelName === 'order'){
                    $data = date_format(date_create($object->updated_at), 'Y-m-d');
                }elseif($modelName === 'financial'){
                    $payment = $object->payment;
                    if($payment)
                        $data = $payment->data_pagamento;
                    else
                        $data = $object->created_at;

                    $data = date_format(date_create($data), 'Y-m-d');
                }elseif($modelName === 'budget'){
                    if($object->status === 'APROVADO'){
                        $sale = $object->sale;
                        if($sale)
                            $data = $sale->created_at;
                    }else{
                        $data = $object->updated_at;
                    }

                    $data = date_format(date_create($data), 'Y-m-d');
                }

                return strtotime($data) >= strtotime($data_inicial) && strtotime($data) <= strtotime($data_final);
            });

            if($modelName === 'order'){
                $firstArgument[] = $objectsfilter->where('situacao','=','CONCLUIDA')->count();

                $secondArgument[] = $objectsfilter->where('situacao','=','CANCELADA')->count();
            }elseif($modelName === 'financial'){

                $receitas =  $objectsfilter->where('tipo','=','RECEITA');
                $valor = $receitas->sum('valor');
                $valor = number_format($valor,2,'.','');
                $firstArgument[] = (double)$valor;

                $despesas = $objectsfilter->where('tipo','=','DESPESA');
                $valor = $despesas->sum('valor');
                $valor = number_format($valor,2,'.','');
                $secondArgument[] = (double)$valor;

            }elseif($modelName === 'budget'){

                $firstArgument[] = $objectsfilter->where('status','=','APROVADO')->count();

                $secondArgument[] = $objectsfilter->where('status','=','FINALIZADO')->count();

            }


        }


    }

}
