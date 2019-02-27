<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Uf;
use Illuminate\Support\Facades\Auth;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!Auth::user()->can('empresa_atualizar', Company::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $company = Company::all()->first();

        $states = Uf::getUfs();
        return view('dashboard.create.company', compact('company', 'states'))->with('title', 'Dados da Empresa');
    }
}
