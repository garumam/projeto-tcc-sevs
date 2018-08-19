<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validado = $this->rules_order($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
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
        $budgets = Budget::all();
        if ($order) {
            $budgetsOrders = $order->budgets()->get();
            return view('dashboard.create.order', compact('order', 'budgetsOrders', 'budgets'))->with('title', 'Atualizar ordem de serviço');

        }
        return redirect('orders')->with('error', 'Ordem não encontrada');
    }


    public function update(Request $request, $id)
    {
        $validado = $this->rules_order($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $order = Order::with('budgets')->find($id);
        if ($order) {
            $order->update($request->except('id_orcamento', '_token'));
            if ($order) {
                $order->budgets()->sync($request->id_orcamento);
                return redirect()->back()->with('success', 'Ordem atualizada com sucesso');
            }
        }
        return redirect('orders')->with('error', 'Erro ao atualizar ordem de serviço');
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

    public function rules_order(array $data)
    {
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'data_inicial' => 'required|date',
            'data_final' => 'required|date',
            'total' => 'required',
            'situacao' => 'required',
            'id_orcamento' => 'required|array'
        ]);

        return $validator;
    }
}
