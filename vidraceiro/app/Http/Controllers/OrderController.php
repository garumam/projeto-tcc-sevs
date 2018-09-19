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

    public function index(Request $request)
    {
        $paginate = 10;
        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        }
        $orders = Order::where('nome', 'like', '%' . $request->get('search') . '%')
            ->orWhere('situacao', 'like', '%' . $request->get('search') . '%')
//            ->orderBy($request->get('field'), $request->get('sort'))
            ->paginate($paginate);
        if ($request->ajax()) {
            return view('dashboard.list.tables.table-order', compact('orders'));
        } else {
            return view('dashboard.list.order', compact('orders'))->with('title', 'Ordens de serviço');
        }
    }

    public function create()
    {
        $budgets = Budget::where('status', 'APROVADO')->where('ordem_id', null)->get();
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
        $budgets = Budget::wherein('id', $request->id_orcamento)->get();

        if ($order) {
            $alterastatus = [];
            if ($request->situacao === 'CONCLUIDA') {
                $alterastatus = ['status' => 'FINALIZADO'];
            }
            foreach ($budgets as $budget) {
                $budget->update(array_merge(['ordem_id' => $order->id], $alterastatus));
            }
            return redirect()->back()->with('success', 'Ordem de serviço criada com sucesso');
        }


    }

    public function show($id)
    {
        $order = Order::find($id);
        return view('dashboard.show.order', compact('order'))->with('title', 'Informações da ordem de serviço');
    }

    public function edit($id)
    {
        $order = Order::with('budgets')->find($id);

        $budgets = Budget::where('status', 'APROVADO')->where('ordem_id', null)
                    ->orWhere('ordem_id', $order->id)->get();

        if ($order) {
            $budgetsOrders = $order->budgets;
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
        foreach ($order->budgets as $budget) {
            $budget->update(['ordem_id' => null]);
        }
        $budgets = Budget::wherein('id', $request->id_orcamento)->get();
        if ($order) {
            $order->update($request->except('id_orcamento', '_token'));
            if ($order) {
                $alterastatus = [];
                $ordemid = $order->id;
                if ($request->situacao === 'CONCLUIDA') {
                    $alterastatus = ['status' => 'FINALIZADO'];
                } elseif ($request->situacao === 'CANCELADA') {
                    $alterastatus = ['status' => 'APROVADO'];
                    $ordemid = null;
                }

                foreach ($budgets as $budget) {
                    $budget->update(array_merge(['ordem_id' => $ordemid], $alterastatus));
                }
                return redirect()->back()->with('success', 'Ordem atualizada com sucesso');
            }
        }
        return redirect('orders')->with('error', 'Erro ao atualizar ordem de serviço');
    }

    public function destroy($id)
    {
        $order = Order::with('budgets')->find($id);
        foreach ($order->budgets as $budget) {
            $budget->update(['ordem_id' => null]);
        }
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
