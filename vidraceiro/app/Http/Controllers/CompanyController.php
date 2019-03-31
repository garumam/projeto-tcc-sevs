<?php

namespace App\Http\Controllers;

use App\Company;
use App\Uf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Location;
use App\Contact;

class CompanyController extends Controller
{
    protected $company;

    public function __construct(Company $company)
    {
        $this->middleware('auth');
        $this->company = $company;
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
        $company = $this->company->getCompany();
        if(!empty($company)){
            return redirect()->route('configuration.index')->with('error', 'Dados da empresa já existem');
        }
        $location = new Location();
        $location = $location->createLocation($request->all());
        $contact = new Contact();
        $contact = $contact->createContact($request->all());

        $company = $this->company->createCompany(array_merge($request->all(),['endereco_id'=>$location->id,'contato_id'=>$contact->id]));
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
            $location = $company->location()->first();
            $location->updateLocation($request->all());
            $contact = $company->contact()->first();
            $contact->updateContact($request->all());
            $company->updateCompany($request->all());

            return redirect()->back()->with('success', 'Dados da empresa atualizados com sucesso');
        }
        return redirect()->route('configuration.index')->with('error', 'Erro ao atualizar os dados da empresa');
    }

    public function destroy($id)
    {
        if(!Auth::user()->can('empresa_deletar', Company::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $company = $this->company->findCompanyById($id);
        if ($company) {
            $location = $company->location()->first();
            $contact = $company->contact()->first();
            $company->deleteCompany();
            $location->deleteLocation();
            $contact->deleteContact();
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
