<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Category;
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
        switch($tipo){
            case 'vidro':
                $categories = Category::where('tipo','vidro')->get();
                break;
            case 'aluminio':
                $categories = Category::where('tipo','aluminio')->get();
                break;
            case 'componente':
                $categories = Category::where('tipo','componente')->get();
                break;
        }
        return view('dashboard.create.material',compact('tipo','categories'))->with('title','Criar '.$tipo);
    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function edit(Request $request)
    {
        echo $request->type;
    }


    public function update()
    {

    }

    public function destroy($type, $id)
    {
        switch($type){
            case 'glass':
                $material = Glass::find($id);
                $tipoNome = 'Vidro';
                break;
            case 'aluminum':
                $material = Aluminum::find($id);
                $tipoNome = 'Alumínio';
                break;
            case 'component':
                $material = Component::find($id);
                $tipoNome = 'Componente';
                break;
        }

        if ($material) {
            $material->delete();
            return redirect()->back()->with('success', "$tipoNome deletado com sucesso");
        } else {
            return redirect()->back()->with('error', "Erro ao deletar $tipoNome");
        }
    }
}
