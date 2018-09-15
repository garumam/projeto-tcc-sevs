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

    public function index(Request $request)
    {
//        $providers = Provider::paginate(1);
        $paginate = 10;
        if ($request->get('paginate')){
            $paginate = $request->get('paginate');
        }
        $providers = Provider::where('nome', 'like', '%' . $request->get('search') . '%')
//            ->orderBy($request->get('field'), $request->get('sort'))
            ->paginate($paginate);
        if ($request->ajax()){
//            return response()->view('dashboard.list.tables.tableprovider',compact('providers'),200);
            return view('dashboard.list.tables.tableprovider', compact('providers'));
        }else{
            return view('dashboard.list.provider', compact('providers'))->with('title', 'Fornecedores');
        }

    }

    public function create()
    {
        $states = $this->states;
        return view('dashboard.create.provider', compact('states'))->with('title','Criar fornecedor');
    }

    public function store(Request $request)
    {
        $validado = $this->rules_provider($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $provider = new Provider();
        $provider = $provider->create($request->all());
        if($provider)
            return redirect()->back()->with('success', 'Fornecedor criado com sucesso');
    }

    public function show($id)
    {
        $provider = Provider::find($id);
        return view('dashboard.show.provider', compact('provider'))->with('title', 'Informações do fornecedor');
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
            'telefone' => 'nullable|string|min:10|max:255',
            'celular' => 'nullable|string|min:10|max:255',
            'cnpj' => 'nullable|string|min:14|max:255',
            'cep' => 'required|string|min:8|max:8',
            'bairro' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:255'
        ]);

        return $validator;
    }
}
