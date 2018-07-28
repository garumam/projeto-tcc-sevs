<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.list.budget')->with('title', 'Orçamentos');
    }

    public function create()
    {
        $titulotabs = ['Orçamento','Editar','Adicionar','Material','Total'];
        return view('dashboard.create.budget',compact('titulotabs'))->with('title', 'Novo Orçamento');
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
