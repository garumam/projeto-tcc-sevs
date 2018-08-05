<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Component;
use App\Glass;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aluminums = Aluminum::all();
        $glasses = Glass::all();
        $components = Component::all();
        $titulotabs = ['Vidros','Aluminios','Componentes'];
        return view('dashboard.list.material', compact('titulotabs', 'aluminums', 'glasses', 'components'))->with('title', 'Materiais');
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
