<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Uf;
use Illuminate\Support\Facades\Auth;
use App\Configuration;
use Illuminate\Support\Facades\Validator;
class ConfigurationController extends Controller
{
    protected $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->middleware('auth');

        $this->configuration = $configuration;
    }

    public function index()
    {
        if(!Auth::user()->can('empresa_atualizar', Company::class) && !Auth::user()->can('configuracao', Configuration::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $company = Company::all()->first();

        $states = Uf::getUfs();

        $configuration = Configuration::all()->first();

        return view('dashboard.create.configuration', compact('company', 'states','configuration'))->with('title', 'Dados da Empresa')->with('title2', 'Configurações');
    }

    public function update(Request $request)
    {
        if(!Auth::user()->can('configuracao', Configuration::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_configuration($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $configuration = $this->configuration->getConfiguration();

        if($configuration){
            $configuration->updateConfiguration($request->all());
            return redirect()->back()->with('success', 'Configurações atualizadas com sucesso');
        }
        return redirect()->back()->with('error', 'Erro ao atualizar configurações'); 

    }

    public function rules_configuration(array $data)
    {
        $validator = Validator::make($data, [
            'porcent_reajuste' => 'required|numeric',
            'dias_parcelas' => 'required|numeric',
            'porcent_m_lucro' => 'required|numeric',
            'juros_mensal_parcel' => 'required|numeric'
        ]);

        return $validator;
    }

}
