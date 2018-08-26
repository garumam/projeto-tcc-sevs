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

    public function index()
    {
        $clients = Client::all();

        return view('dashboard.list.client', compact('clients'))->with('title', 'Clientes');
    }

    public function create()
    {
        $states = $this->states;
        return view('dashboard.create.client', compact('states'))->with('title', 'Novo cliente');
    }

    public function store(Request $request)
    {
        $validado = $this->rules_client($request->all(),'');
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $client = new Client();
        $client = $client->create($request->all());
        if ($client)
            return redirect()->back()->with('success', 'Cliente cadastrado com sucesso');
    }

    public function show()
    {

    }

    public function edit($id)
    {
        $states = $this->states;
        $client = Client::find($id);
        return view('dashboard.create.client', compact('client','states'))->with('title', 'Atualizar cliente');
    }


    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        $validado = $this->rules_client($request->all(),$id);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $client->update($request->except('att_budgets'));
        if ($client){
            $mensagem = 'Cliente atualizado com sucesso';
            if($request->att_budgets != null){

                foreach($client->budgets as $budget){
                    $budget->update($request->except('nome','cpf','email','celular','att_budgets'));
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

    public function rules_client(array $data, $id)
    {
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:clients,cpf,'.$id.'|min:11|max:20',
            'telefone' => 'nullable|string|min:10|max:20',
            'cep' => 'required|string|min:8|max:8',
            'endereco' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'celular' => 'nullable|string|min:10|max:20'
        ]);

        return $validator;
    }
}
