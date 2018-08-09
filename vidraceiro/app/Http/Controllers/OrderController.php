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
        $order = new Order;
        $order = $order->create($request->except('id_orcamento', '_token'));
        if ($order) {
            $order->budgets()->attach($request->id_orcamento);
            return redirect()->back()->with('success', 'Ordem de serviço criada com sucesso');
        }


    }

    public function show()
    {

    }

    public function edit($id)
    {
        $order = Order::with('budgets')->find($id);
        if ($order) {
            $budgets = $order->budgets()->get();
            return view('dashboard.create.order', compact('order', 'budgets'))->with('title', 'Atualizar');

        }
        return redirect('orders')->with('error', 'Ordem não encontrada');
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
