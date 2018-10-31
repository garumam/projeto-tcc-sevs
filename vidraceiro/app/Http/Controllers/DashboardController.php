<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Budget;
use App\Category;
use App\Component;
use App\Glass;
use App\MProduct;
use App\Order;
use App\User;
use App\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $totalusers = User::all()->count();
        $totalcategories = Category::all()->count();
        $totalproducts = MProduct::all()->count();
        $totalbudgets = Budget::all()->count();
        $totalmaterials = Aluminum::all()->count() + Glass::all()->count() + Component::all()->count();
        $totalorders = Order::all()->count();
        $clients = Client::all()->count();

        if($request->has('ordens') || !$request->ajax()){
            $orders = new Order();
//            $orders = $orders->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),false,'ABERTA');
            $orders = $orders->getWithSearchAndPagination($request->get('search'),1,false,'ABERTA');
        }
        if($request->has('orcamentos') || !$request->ajax()) {
            $budgets = new Budget();
//            $budgets = $budgets->getWithSearchAndPagination($request->get('search'), $request->get('paginate'), false, 'APROVADO');
            $budgets = $budgets->getWithSearchAndPagination($request->get('search'), 1, false, 'APROVADO');
        }
        if ($request->ajax()){
            if($request->has('ordens'))
                return view('dashboard.list.tables.table-order', compact('orders'));
            if($request->has('orcamentos'))
                return view('dashboard.list.tables.table-budget', compact('budgets'));
        }

        return view('dashboard.home', compact('totalusers', 'totalcategories', 'totalproducts', 'totalbudgets', 'totalorders', 'totalmaterials','clients','orders','budgets'))->with('title', 'Dashboard');
    }
}
