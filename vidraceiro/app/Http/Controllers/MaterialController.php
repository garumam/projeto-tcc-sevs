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
        return view('dashboard.list.material',compact('titulotabs'))->with('title','Adicionar material');
    }

    public function create(Request $request)
    {
        echo $_GET['material'];
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
