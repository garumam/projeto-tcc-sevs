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
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '01')->count();
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
        $sales[] = DB::table('sales')->whereMonth('data_venda', '=', '12')->count();
        return response()->json($sales);
    }
}
