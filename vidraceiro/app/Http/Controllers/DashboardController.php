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
    public function index()
    {

        $totalusers = User::all()->count();
        $totalcategories = Category::all()->count();
        $totalproducts = MProduct::all()->count();
        $totalbudgets = Budget::all()->count();
        $totalmaterials = Aluminum::all()->count() + Glass::all()->count() + Component::all()->count();
        $totalorders = Order::all()->count();
        $clients = Client::all()->count();
        return view('dashboard.home', compact('totalusers', 'totalcategories', 'totalproducts', 'totalbudgets', 'totalorders', 'totalmaterials','clients'))->with('title', 'Dashboard');
    }
}
