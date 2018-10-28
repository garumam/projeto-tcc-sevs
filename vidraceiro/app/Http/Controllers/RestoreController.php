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
        /*if(!Auth::user()->can('orcamento_listar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }*/
        if($request->has('clientes') || !$request->ajax())
            $clients = $this->client->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);
        if($request->has('orcamentos') || !$request->ajax())
            $budgets = $this->budget->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),true);

        if ($request->ajax()) {
            if($request->has('clientes') || !$request->ajax())
                return view('dashboard.list.tables.table-client', compact('clients'));
            if($request->has('orcamentos') || !$request->ajax())
                return view('dashboard.list.tables.table-budget', compact('budgets'));
        }

        return view('dashboard.list.restore', compact('clients','budgets'))->with('title', 'Restauração');

    }

    public function restore($tipo,$id){

        switch($tipo){
            case 'clientes':
                $client = $this->client->findDeletedClientById($id);

                if($client){
                    $client->restore();
                    return redirect()->back()->with('success','Cliente restaurado com sucesso');
                }
                return redirect()->back()->with('error','Erro ao restaurar cliente');
                break;
            case 'orcamentos':
                $budget = $this->budget->findDeletedBudgetById($id);

                if($budget){
                    $budget->restore();
                    return redirect()->back()->with('success','Orçamento restaurado com sucesso');
                }
                return redirect()->back()->with('error','Erro ao restaurar orçamento');
                break;
        }

    }

}
