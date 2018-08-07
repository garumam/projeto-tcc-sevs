<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::all();
        return view('dashboard.list.order', compact('orders'))->with('title', 'Ordens de serviço');
    }

    public function create()
    {
        $budgets = Budget::all();
        return view('dashboard.create.order', compact('budgets'))->with('title', 'Nova Ordem de serviço');
    }

    public function store(Request $request)
    {
        $ids = $request->id_orcamento;
        foreach ($ids as $id) {
            echo $id . "\n";
        }

    }

    public function show()
    {

    }

    public function edit()
    {

    }


    public function update()
    {

    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return redirect()->back()->with('success', 'Ordem de serviço deletado com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar ordem de serviço');
        }
    }
}
