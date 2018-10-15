<?php

namespace App\Http\Controllers;

use App\Company;
use App\Uf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    protected $company;

    public function __construct(Company $company)
    {
        $this->middleware('auth');
        $this->company = $company;
    }

    public function index()
    {
        if(!Auth::user()->can('empresa_atualizar', Company::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $company = $this->company->getCompany();

        $states = Uf::getUfs();
        return view('dashboard.create.company', compact('company', 'states'))->with('title', 'Dados da Empresa');
    }


    public function store(Request $request)
    {
        if(!Auth::user()->can('empresa_atualizar', Company::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_company($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $company = $this->company->createCompany($request->all());
        if ($company)
            return redirect()->back()->with('success', 'Dados da empresa criados com sucesso');
    }


    public function update(Request $request, $id)
    {
        if(!Auth::user()->can('empresa_atualizar', Company::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_company($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $company = $this->company->findCompanyById($id);

        if ($company){
            $company->updateCompany($request->all());

            return redirect()->back()->with('success', 'Dados da empresa atualizados com sucesso');
        }

    }

    public function destroy($id)
    {
        if(!Auth::user()->can('empresa_deletar', Company::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $company = $this->company->findCompanyById($id);
        if ($company) {
            $company->deleteCompany();
            return redirect()->back()->with('success', 'Dados da empresa deletados com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar dados');
        }
    }

    public function rules_company(array $data)
    {
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'uf' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'telefone' => 'required|string|max:20',
        ]);

        return $validator;
    }
}
