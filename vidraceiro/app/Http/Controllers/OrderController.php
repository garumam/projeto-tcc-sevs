<?php

namespace App\Http\Controllers;

use App\Order;

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
        return view('dashboard.create.order')->with('title', 'Nova Ordem de serviço');
    }

    public function store()
    {

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
