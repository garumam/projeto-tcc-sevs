<?php

namespace App\Http\Controllers\Api;

use App\Budget;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

        $budgets = $budgets->map(function($b){
            $location = $b->location()->first([
                'cep',
                'endereco',
                'bairro',
                'uf',
                'cidade',
                'complemento'
            ]);

            $contact = $b->contact()->first(['telefone','celular','email']);
           
            $b = array_merge($b->toArray(),$location->toArray(),$contact->toArray());
            
            return $b;
        });

        return response()->json(['budgets' => $budgets]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('os_adicionar', Order::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página'], 202);
        }

        $validado = $this->rules_order($request->all());
        if ($validado->fails()) {
            return response()->json(['error' => $validado->messages()], 202);
        }

        $order = $this->order->createOrder($request->all());
        $budgets = Budget::getBudgetsWhereIn($request->id_orcamento);

        if ($order && $budgets) {

            $order->updateBudgetsStatusByOrderSituation($budgets);

            return response()->json(['success' => 'Ordem de serviço criada com sucesso', 'id' => $order->id], 200);

        }


    }


    public function update(Request $request, $id, $situacao = null)
    {
        if (!Auth::user()->can('os_atualizar', Order::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página'], 202);
        }

        $validado = $this->rules_order_exists(['id' => $id]);

        if ($validado->fails()) {
            return response()->json(['error' => $validado->messages()], 202);
        }

        $order = $this->order->findOrderById($id);

        if ($order->situacao === 'ANDAMENTO') {
            $budgets = $order->budgets;
            if ($situacao === 'CONCLUIDA' || $situacao === 'CANCELADA') {
                $order->updateOrder(['situacao' => $situacao]);
                $order->updateBudgetsStatusByOrderSituation($budgets);
                return response()->json(['success' => 'Ordem atualizada com sucesso', 'id' => $order->id], 200);
            } else {
                return response()->json(['error' => 'Não é possível editar esta O.S.'], 202);
            }

        }

        $validado = $this->rules_order($request->all());
        if ($validado->fails()) {
            return response()->json(['error' => $validado->messages()], 202);
        }

        if ($order->situacao !== 'ABERTA') {
            return response()->json(['error' => 'Não é possível editar esta O.S.'], 202);
        }

        foreach ($order->budgets as $budget) {
            $budget->updateBudget(['ordem_id' => null]);
        }

        $budgets = Budget::getBudgetsWhereIn($request->id_orcamento);

        if ($budgets) {
            $order->updateOrder($request->all());
            if ($order) {
                $order->updateBudgetsStatusByOrderSituation($budgets);

                return response()->json(['success' => 'Ordem atualizada com sucesso', 'id' => $order->id], 200);

            }
        }
        return response()->json(['error' => 'Erro ao atualizar ordem de serviço'], 202);
    }

    public function destroy($id)
    {
        if (!Auth::user()->can('os_deletar', Order::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página']);
        }

        $order = $this->order->findOrderById($id);

        if ($order && ($order->situacao === 'CONCLUIDA' || $order->situacao === 'CANCELADA')) {

            $order->deleteOrder();
            return response()->json(['success' => 'Ordem de serviço deletado com sucesso', 'id' => $id], 200);
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
            'situacao' => [
                'required',
                Rule::in(['ABERTA', 'ANDAMENTO', 'CONCLUIDA', 'CANCELADA']),
            ],
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
