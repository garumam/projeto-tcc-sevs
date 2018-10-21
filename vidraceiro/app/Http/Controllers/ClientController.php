<?php

namespace App\Http\Controllers;

use App\Client;
use App\Uf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    protected $states;
    protected $client;
    public function __construct(Client $client)
    {
        $this->middleware('auth');

        $this->client = $client;
        $this->states = Uf::getUfs();
    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('cliente_listar', Client::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $clients = $this->client->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if ($request->ajax()) {
            return view('dashboard.list.tables.table-client', compact('clients'));
        }

        return view('dashboard.list.client', compact('clients'))->with('title', 'Clientes');

    }

    public function create()
    {
        if(!Auth::user()->can('cliente_adicionar', Client::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $states = $this->states;
        return view('dashboard.create.client', compact('states'))->with('title', 'Novo cliente');
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('cliente_adicionar', Client::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $docvalidation = null;
        $docnull = null;

        $this->prepareDocValidation($docvalidation,$docnull,'',$request);

        $validado = $this->rules_client($request->all(), $docvalidation);
        if ($validado->fails())
            return redirect()->back()->withErrors($validado);


        $client = $this->client->createClient(array_merge($request->all(), $docnull, ['status' => 'EM DIA']));

        if ($client)
            return redirect()->back()->with('success', 'Cliente cadastrado com sucesso');
    }

    public function show($id)
    {
        if(!Auth::user()->can('cliente_listar', Client::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_client_exists(['id'=>$id]);

        if ($validado->fails())
            return redirect(route('clients.index'))->withErrors($validado);

        $client = $this->client->findClientById($id);

        if($client)
            return view('dashboard.show.client', compact('client'))->with('title', 'Informações do cliente');
    }

    public function edit($id)
    {
        if(!Auth::user()->can('cliente_atualizar', Client::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_client_exists(['id'=>$id]);

        if ($validado->fails())
            return redirect(route('clients.index'))->withErrors($validado);

        $states = $this->states;
        $client = $this->client->findClientById($id);

        if($client)
            return view('dashboard.create.client', compact('client', 'states'))->with('title', 'Atualizar cliente');
    }


    public function update(Request $request, $id)
    {
        if(!Auth::user()->can('cliente_atualizar', Client::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_client_exists(['id'=>$id]);

        if ($validado->fails())
            return redirect(route('clients.index'))->withErrors($validado);

        $docvalidation = null;
        $docnull = null;

        $this->prepareDocValidation($docvalidation,$docnull,$id,$request);

        $validado = $this->rules_client($request->all(), $docvalidation);

        if ($validado->fails())
            return redirect()->back()->withErrors($validado);

        $this->client = $this->client->findClientById($id);
        $client = $this->client->updateClient(array_merge($request->all(), $docnull));

        if ($client) {
            $mensagem = 'Cliente atualizado com sucesso';
            if ($request->att_budgets != null) {

                $budgetsUpdated = $this->client->updateClientBudgets($request->except('nome'));

                if($budgetsUpdated)
                    $mensagem = 'Cliente e orçamentos atualizados com sucesso';
            }
            return redirect()->back()->with('success', $mensagem);
        }

        return redirect()->back()->with('error', 'Erro ao atualizar cliente');
    }

    public function destroy($id)
    {
        if(!Auth::user()->can('cliente_deletar', Client::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }
        $client = $this->client->findClientById($id);

        if ($client && $client->status === 'EM DIA' && !$client->haveBudgetApproved()){
            $client->deleteClient();
            return redirect()->back()->with('success', 'Cliente deletado com sucesso');
        }

        return redirect()->back()->with('error', 'Este cliente não pode ser deletado pois possui pendências');
    }

    public function rules_client(array $data, $docarray)
    {
        $validator = Validator::make($data, array_merge(

            [
                'nome' => 'required|string|max:255',
                'telefone' => 'nullable|string|min:10|max:20',
                'cep' => 'required|string|min:8|max:8',
                'endereco' => 'nullable|string|max:255',
                'bairro' => 'nullable|string|max:255',
                'cidade' => 'nullable|string|max:255',
                'uf' => 'nullable|string|max:255',
                'complemento' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'celular' => 'nullable|string|min:10|max:20'
            ], $docarray

        ));

        return $validator;
    }
    public function rules_client_exists(array $data)
    {
        $validator = Validator::make($data,

            [
                'id' => 'exists:clients,id'
            ], [
                'exists' => 'Este cliente não existe!',
            ]

        );

        return $validator;
    }

    public function prepareDocValidation(&$docvalidation,&$docnull,$ignoreId, $request){

        if ($request->has('cpf')) {
            $docvalidation = ['cpf' => 'required|string|unique:clients,cpf,' . $ignoreId . '|min:11|max:20'];
            $docnull = ['cnpj' => null];
        } elseif ($request->has('cnpj')) {
            $docvalidation = ['cnpj' => 'required|string|unique:clients,cnpj,' . $ignoreId . '|min:14|max:20'];
            $docnull = ['cpf' => null];
        } else {
            $docvalidation = ['cnpj' => 'required', 'cpf' => 'required'];
        }

    }
}
