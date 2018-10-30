<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Budget;
use App\Category;
use App\Client;
use App\Component;
use App\Financial;
use App\Glass;
use App\MProduct;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestoreController extends Controller
{
    protected $client,$budget,$order,$mproduct,$glass,$aluminum,$component,$category,$financial,$user;

    public function __construct(Client $client,Budget $budget,Order $order,MProduct $mproduct,Glass $glass,Aluminum $aluminum, Component $component,Category $category, Financial $financial, User $user)
    {
        $this->middleware('auth');

        $this->client = $client;
        $this->budget = $budget;
        $this->order = $order;
        $this->mproduct = $mproduct;
        $this->glass = $glass;
        $this->aluminum = $aluminum;
        $this->component = $component;
        $this->category = $category;
        $this->financial = $financial;
        $this->user = $user;

    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('restaurar')){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        if($request->has('clientes') || !$request->ajax())
            $clients = $this->client->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('orcamentos') || !$request->ajax())
            $budgets = $this->budget->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('ordens') || !$request->ajax())
            $orders = $this->order->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('mprodutos') || !$request->ajax())
            $mProducts = $this->mproduct->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('vidros') || !$request->ajax())
            $glasses = $this->glass->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('aluminios') || !$request->ajax())
            $aluminums = $this->aluminum->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('componentes') || !$request->ajax())
            $components = $this->component->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('categorias') || !$request->ajax())
            $categories = $this->category->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('financeiro') || !$request->ajax())
            $financials = $this->financial->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),$request->get('period'),$nothing,true);
        if($request->has('usuarios') || !$request->ajax())
            $users = $this->user->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if ($request->ajax()) {
            if($request->has('clientes'))
                return view('dashboard.list.tables.table-client', compact('clients'));
            if($request->has('orcamentos'))
                return view('dashboard.list.tables.table-budget', compact('budgets'));
            if($request->has('ordens'))
                return view('dashboard.list.tables.table-order', compact('orders'));
            if($request->has('mprodutos'))
                return view('dashboard.list.tables.table-mproduct', compact('mProducts'));
            if($request->has('vidros'))
                return view('dashboard.list.tables.table-glass', compact('glasses'));
            if($request->has('aluminios'))
                return view('dashboard.list.tables.table-aluminum', compact('aluminums'));
            if($request->has('componentes'))
                return view('dashboard.list.tables.table-component', compact('components'));
            if($request->has('categorias'))
                return view('dashboard.list.tables.table-category', compact('categories'));
            if($request->has('financeiro'))
                return view('dashboard.list.tables.table-financial', compact('financials'));
            if($request->has('usuarios'))
                return view('dashboard.list.tables.table-user', compact('users'));

        }

        return view('dashboard.list.restore', compact('clients','budgets','orders','mProducts','glasses','aluminums','components','categories','financials','users'))->with('title', 'Restauração');

    }

    public function restore($tipo,$id){

        if(!Auth::user()->can('restaurar')){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        switch($tipo){
            case 'clientes':

                if($this->client->restoreClientById($id))
                    return redirect()->back()->with('success','Cliente restaurado com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar cliente');
                break;
            case 'orcamentos':

                if($this->budget->restoreBudgetById($id))
                    return redirect()->back()->with('success','Orçamento restaurado com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar orçamento');
                break;
            case 'ordens':

                if($this->order->restoreOrderById($id))
                    return redirect()->back()->with('success','Ordem de serviço restaurada com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar ordem de serviço');
                break;
            case 'mprodutos':

                if($this->mproduct->restoreMProductById($id))
                    return redirect()->back()->with('success','Modelo de produto restaurado com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar modelo de produto');
                break;
            case 'vidros':

                if($this->glass->restoreGlassById($id))
                    return redirect()->back()->with('success','Vidro restaurado com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar vidro');
                break;
            case 'aluminios':

                if($this->aluminum->restoreAluminumById($id))
                    return redirect()->back()->with('success','Alumínio restaurado com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar alumínio');
                break;
            case 'componentes':

                if($this->component->restoreComponentById($id))
                    return redirect()->back()->with('success','Componente restaurado com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar componente');
                break;
            case 'categorias':

                if($this->category->restoreCategoryById($id))
                    return redirect()->back()->with('success','Categoria restaurada com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar categoria');
                break;
            case 'financeiro':

                if($this->financial->restoreFinancialById($id))
                    return redirect()->back()->with('success','Movimentação restaurada com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar movimentação');
                break;
            case 'usuarios':

                if($this->user->restoreUserById($id))
                    return redirect()->back()->with('success','Usuário restaurado com sucesso');

                return redirect()->back()->with('error','Erro ao restaurar usuário');
                break;
        }

    }

}
