<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
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
        $providers = Provider::all();
        return view('dashboard.list.provider', compact('providers'))->with('title', 'Fornecedores');
    }

    public function create()
    {
        $states = $this->states;
        return view('dashboard.create.provider', compact('states'))->with('title','Criar fornecedor');
    }

    public function store(Request $request)
    {
        $provider = new Provider();
        $provider = $provider->create($request->all());
        if($provider)
            return redirect()->back()->with('success', 'Fornecedor criado com sucesso');
    }

    public function show()
    {

    }

    public function edit($id)
    {
        $provider = Provider::findOrFail($id);
        $states = $this->states;
        return view('dashboard.create.provider',compact('provider','states'))->with('title', 'Atualizar fornecedor');
    }


    public function update(Request $request, $id)
    {
        $provider = Provider::find($id);

        $validado = $this->rules_provider($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $provider->update($request->except(['_token']));
        if ($provider)
            return redirect()->back()->with('success', 'Fornecedor atualizado com sucesso');
    }

    public function destroy($id)
    {
        $provider = Provider::find($id);
        if ($provider) {
            $provider->delete();
            return redirect()->back()->with('success', 'Fornecedor deletado com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar fornecedor');
        }
    }

    public function rules_provider(array $data)
    {
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'situacao' => 'required|string|max:255',
            'telefone' => 'string|min:10|max:255',
            'celular' => 'string|min:10|max:255',
            'cnpj' => 'string|min:14|max:255',
            'cep' => 'integer|min:8',
            'bairro' => 'string|max:255',
            'email' => 'string|email|max:255',
            'cidade' => 'string|max:255',
            'uf' => 'string|max:255',
        ]);

        return $validator;
    }
}
