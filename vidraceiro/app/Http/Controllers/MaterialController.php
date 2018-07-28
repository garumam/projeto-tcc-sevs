<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $titulotabs = ['Vidros','Aluminios','Componentes'];
        return view('dashboard.list.material',compact('titulotabs'))->with('title','Materiais');
    }

    public function create(Request $request)
    {
        $tipo = $request->tipo;
        return view('dashboard.create.material',compact('tipo'))->with('title','Criar '.$tipo);
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
