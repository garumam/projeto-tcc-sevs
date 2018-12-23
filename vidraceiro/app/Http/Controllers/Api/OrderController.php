<?php

namespace App\Http\Controllers\Api;

use App\Budget;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index(Request $request)
    {
        if (!Auth::user()->can('os_listar', Order::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página']);
        }

        $orders = $this->order->getWithSearchAndPagination($request->get('search'), false, false, false, true);

        return response()->json(['orders' => $orders]);

    }

    public function create()
    {
        if (!Auth::user()->can('os_adicionar', Order::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página']);
        }

        $budgets = Budget::getBudgetsWhereStatusApproved(null);
        return response()->json(['budgets' => $budgets]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('os_adicionar', Order::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_order($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $order = $this->order->createOrder($request->all());
        $budgets = Budget::getBudgetsWhereIn($request->id_orcamento);

        if ($order && $budgets) {

            $order->updateBudgetsStatusByOrderSituation($budgets);

            if ($order->situacao === 'CONCLUIDA') {
                return redirect('orders')->with('success', 'Ordem de serviço criada com sucesso');
            } else {
                return redirect()->back()->with('success', 'Ordem de serviço criada com sucesso');
            }
        }


    }

    public function show($id)
    {
        if (!Auth::user()->can('os_listar', Order::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_order_exists(['id' => $id]);

        if ($validado->fails()) {
            return redirect(route('orders.index'))->withErrors($validado);
        }

        $order = $this->order->findOrderById($id);
        if ($order)
            return view('dashboard.show.order', compact('order'))->with('title', 'Informações da ordem de serviço');

        return redirect(route('orders.index'))->with('error', 'Esta O.S. não existe');
    }

    public function edit($id)
    {
        if (!Auth::user()->can('os_atualizar', Order::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_order_exists(['id' => $id]);

        if ($validado->fails()) {
            return redirect(route('orders.index'))->withErrors($validado);
        }

        $order = $this->order->findOrderById($id);

        if ($order->situacao !== 'ABERTA')
            return redirect('orders')->with('error', 'Não é possível editar esta O.S.');


        $budgets = Budget::getBudgetsWhereStatusApproved($order->id);

        $budgetsOrders = $order->budgets;
        return view('dashboard.create.order', compact('order', 'budgetsOrders', 'budgets'))->with('title', 'Atualizar ordem de serviço');

    }


    public function update(Request $request, $id, $situacao = null)
    {
        if (!Auth::user()->can('os_atualizar', Order::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_order_exists(['id' => $id]);

        if ($validado->fails()) {
            return redirect(route('orders.index'))->withErrors($validado);
        }

        $order = $this->order->findOrderById($id);

        if ($order->situacao === 'ANDAMENTO') {
            $budgets = $order->budgets;
            if ($situacao === 'CONCLUIDA' || $situacao === 'CANCELADA') {
                $order->updateOrder(['situacao' => $situacao]);

                $order->updateBudgetsStatusByOrderSituation($budgets);

            }

            return redirect()->back()->with('success', 'Ordem atualizada com sucesso');
        }

        $validado = $this->rules_order($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        if ($order->situacao !== 'ABERTA') {
            return redirect('orders')->with('error', 'Não é possível editar esta O.S.');
        }

        foreach ($order->budgets as $budget) {
            $budget->updateBudget(['ordem_id' => null]);
        }

        $budgets = Budget::getBudgetsWhereIn($request->id_orcamento);

        if ($budgets) {

            $order->updateOrder($request->all());
            if ($order) {

                $order->updateBudgetsStatusByOrderSituation($budgets);

                if ($order->situacao === 'CONCLUIDA' || $order->situacao === 'CANCELADA' || $order->situacao === 'ANDAMENTO') {
                    return redirect('orders')->with('success', 'Ordem atualizada com sucesso');
                } else {
                    return redirect()->back()->with('success', 'Ordem atualizada com sucesso');
                }

            }
        }
        return redirect('orders')->with('error', 'Erro ao atualizar ordem de serviço');
    }

    public function destroy($id)
    {
        if (!Auth::user()->can('os_deletar', Order::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página']);
        }

        $order = $this->order->findOrderById($id);

        if ($order && ($order->situacao === 'CONCLUIDA' || $order->situacao === 'CANCELADA')) {

            $order->deleteOrder();
            return response()->json(['success' => 'Ordem de serviço deletado com sucesso'], 200);
        } else {
            return response()->json(['error' => 'Erro ao deletar ordem de serviço'], 202);
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

    public function rules_order_exists(array $data)
    {
        $validator = Validator::make($data,

            [
                'id' => 'exists:orders,id'
            ], [
                'exists' => 'Esta OS não existe!',
            ]

        );

        return $validator;
    }
}
