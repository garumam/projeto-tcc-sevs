<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Uf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
{

    protected $states;
    protected $provider = null;

    public function __construct(Provider $provider)
    {
        $this->middleware('auth');

        $this->provider = $provider;

        $this->states = Uf::getUfs();
    }

    public function index(Request $request)
    {

        $providers = $this->provider->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if ($request->ajax()){
            return view('dashboard.list.tables.table-provider', compact('providers'));
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
        if ($validado->fails())
            return redirect()->back()->withErrors($validado);


        $provider = $this->provider->createProvider($request->all());
        if($provider)
            return redirect()->back()->with('success', 'Fornecedor criado com sucesso');
    }

    public function show($id)
    {
        $validado = $this->rules_provider_exists(['id'=>$id]);

        if ($validado->fails())
            return redirect(route('providers.index'))->withErrors($validado);


        $provider = $this->provider->findProviderById($id);

        if($provider)
            return view('dashboard.show.provider', compact('provider'))->with('title', 'Informações do fornecedor');
    }

    public function edit($id)
    {
        $validado = $this->rules_provider_exists(['id'=>$id]);

        if ($validado->fails())
            return redirect(route('providers.index'))->withErrors($validado);


        $provider = $this->provider->findProviderById($id);

        $states = $this->states;
        return view('dashboard.create.provider',compact('provider','states'))->with('title', 'Atualizar fornecedor');
    }


    public function update(Request $request, $id)
    {
        $validado = $this->rules_provider_exists(['id'=>$id]);

        if ($validado->fails())
            return redirect(route('providers.index'))->withErrors($validado);


        $validado = $this->rules_provider($request->all());

        if ($validado->fails())
            return redirect()->back()->withErrors($validado);


        $provider = $this->provider->updateProvider($request->all(),$id);

        if ($provider)
            return redirect()->back()->with('success', 'Fornecedor atualizado com sucesso');
    }

    public function destroy($id)
    {
        $provider = $this->provider->deleteProvider($id);
        if ($provider)
            return redirect()->back()->with('success', 'Fornecedor deletado com sucesso');

        return redirect()->back()->with('error', 'Erro ao deletar fornecedor');

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

    public function rules_provider_exists(array $data)
    {
        $validator = Validator::make($data,
            [
                'id' => 'exists:providers,id'
            ], [
                'exists' => 'Não existe este fornecedor!',
            ]
        );
        return $validator;
    }

}
