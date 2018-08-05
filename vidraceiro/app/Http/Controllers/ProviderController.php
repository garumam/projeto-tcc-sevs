<?php

namespace App\Http\Controllers;

use App\Provider;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $providers = Provider::all();
        return view('dashboard.list.provider', compact('providers'))->with('title', 'Fornecedores');
    }

    public function create()
    {
        return view('dashboard.create.provider')->with('title','Criar fornecedor');
    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function edit()
    {

    }


    public function update()
    {

    }

    public function destroy()
    {

    }
}
