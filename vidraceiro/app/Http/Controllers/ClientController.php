<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    protected $states;

    public function __construct()
    {
        $this->middleware('auth');

        $this->states = array(
            ' ' => 'Selecione...',
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins'
        );
    }

    public function index(Request $request)
    {
        $paginate = 10;
        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        }
        $clients = Client::where('nome', 'like', '%' . $request->get('search') . '%')
//            ->orderBy($request->get('field'), $request->get('sort'))
            ->paginate($paginate);
        if ($request->ajax()) {
            return view('dashboard.list.tables.table-client', compact('clients'));
        } else {
            return view('dashboard.list.client', compact('clients'))->with('title', 'Clientes');
        }
    }

    public function create()
    {
        $states = $this->states;
        return view('dashboard.create.client', compact('states'))->with('title', 'Novo cliente');
    }

    public function store(Request $request)
    {
        $docvalidation = null;
        $arraydocnull = null;
        if ($request->has('cpf')) {
            $docvalidation = ['cpf' => 'required|string|unique:clients,cpf,' . '' . '|min:11|max:20'];
            $arraydocnull = ['cnpj' => null];
        } elseif ($request->has('cnpj')) {
            $docvalidation = ['cnpj' => 'required|string|unique:clients,cnpj,' . '' . '|min:14|max:20'];
            $arraydocnull = ['cpf' => null];
        } else {
            $docvalidation = ['cnpj' => 'required', 'cpf' => 'required'];
        }
        $validado = $this->rules_client($request->all(), $docvalidation);
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $client = new Client();
        $client = $client->create(array_merge($request->all(), $arraydocnull, ['status' => 'EM DIA']));
        if ($client)
            return redirect()->back()->with('success', 'Cliente cadastrado com sucesso');
    }

    public function show($id)
    {
        $client = Client::find($id);
        return view('dashboard.show.client', compact('client'))->with('title', 'Informações do cliente');
    }

    public function edit($id)
    {
        $states = $this->states;
        $client = Client::find($id);
        return view('dashboard.create.client', compact('client', 'states'))->with('title', 'Atualizar cliente');
    }


    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        $docvalidation = null;
        $arraydocnull = null;
        if ($request->has('cpf')) {
            $docvalidation = ['cpf' => 'required|string|unique:clients,cpf,' . $id . '|min:11|max:20'];
            $arraydocnull = ['cnpj' => null];
        } elseif ($request->has('cnpj')) {
            $docvalidation = ['cnpj' => 'required|string|unique:clients,cnpj,' . $id . '|min:14|max:20'];
            $arraydocnull = ['cpf' => null];
        } else {
            $docvalidation = ['cnpj' => 'required', 'cpf' => 'required'];
        }

        $validado = $this->rules_client($request->all(), $docvalidation);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $client->update(array_merge($request->except('att_budgets'), $arraydocnull));
        if ($client) {
            $mensagem = 'Cliente atualizado com sucesso';
            if ($request->att_budgets != null) {

                foreach ($client->budgets as $budget) {
                    $budget->update($request->except('nome', 'cpf', 'email', 'celular', 'att_budgets'));
                }
                $mensagem = 'Cliente e orçamentos atualizados com sucesso';
            }
            return redirect()->back()->with('success', $mensagem);
        }

    }

    public function destroy($id)
    {
        $client = Client::find($id);
        if ($client) {
            $client->delete();
            return redirect()->back()->with('success', 'Cliente deletado com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar cliente');
        }
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
}
