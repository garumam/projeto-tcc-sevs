<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $company = Company::take(1)->first();

        $states = array(
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
        return view('dashboard.create.company', compact('company', 'states'))->with('title', 'Dados da Empresa');
    }

    public function create()
    {
        return view('dashboard.create.company')->with('title', 'Dados da Empresa');
    }

    public function store(Request $request)
    {
        $validado = $this->rules_company($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $company = new Company;
        $company = $company->create($request->all());
        if ($company)
            return redirect()->back()->with('success', 'Dados da empresa criados com sucesso');
    }

    public function show()
    {

    }

    public function edit()
    {

    }


    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $validado = $this->rules_company($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $company->update($request->all());
        if ($company)
            return redirect()->back()->with('success', 'Dados da empresa atualizados com sucesso');
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        if ($company) {
            $company->delete();
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
