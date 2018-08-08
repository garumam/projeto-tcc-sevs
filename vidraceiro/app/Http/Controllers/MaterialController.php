<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Category;
use App\Component;
use App\Glass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function create($type)
    {

        switch($type){
            case 'glass':
                $categories = Category::where('tipo','vidro')->get();
                $nome = 'vidro';
                break;
            case 'aluminum':
                $categories = Category::where('tipo','aluminio')->get();
                $nome = 'alumínio';
                break;
            case 'component':
                //$categories = Category::where('tipo','componente')->get();
                $categories = Category::all();
                $nome = 'componente';
                break;
            default:
                return redirect()->back();
        }
        return view('dashboard.create.material',compact('type','categories'))->with('title','Criar '.$nome);
    }

    public function store(Request $request, $type)
    {
        switch($type){
            case 'glass':
                $validado = $this->rules_materiais($request->all(), $type);
                $material = new Glass;
                $nome = 'Vidro';
                break;
            case 'aluminum':
                $validado = $this->rules_materiais($request->all(), $type);
                $material = new Aluminum;
                $nome = 'Alumínio';
                break;
            case 'component':
                $validado = $this->rules_materiais($request->all(), $type);
                $material = new Component;
                $nome = 'Componente';
                break;
            default:
                return redirect()->back();
        }
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $is_modelo = (Request()->route()->getPrefix() == '/materials')? 1 : 0;

        $material = $material->create(array_merge($request->all(), ['is_modelo' => $is_modelo]));

        if ($material)
            return redirect()->back()->with('success', "$nome criado com sucesso");
    }

    public function show()
    {

    }

    public function edit($type, $id)
    {

        switch($type){
            case 'glass':
                $material = Glass::find($id);
                $categories = Category::where('tipo','vidro')->get();
                $nome = 'vidro';
                break;
            case 'aluminum':
                $material = Aluminum::find($id);
                $categories = Category::where('tipo','aluminio')->get();
                $nome = 'alumínio';
                break;
            case 'component':
                $material = Component::find($id);
                //$categories = Category::where('tipo','componente')->get();
                $categories = Category::all();
                $nome = 'componente';
                break;
            default:
                return redirect()->back();
        }

        return view('dashboard.create.material',compact('type','material','categories'))->with('title','Atualizar '.$nome);
    }


    public function update(Request $request, $type, $id)
    {

        switch($type){
            case 'glass':
                $validado = $this->rules_materiais($request->all(), $type);
                $material = Glass::find($id);
                $nome = 'Vidro';
                break;
            case 'aluminum':
                $validado = $this->rules_materiais($request->all(), $type);
                $material = Aluminum::find($id);
                $nome = 'Alumínio';
                break;
            case 'component':
                $validado = $this->rules_materiais($request->all(), $type);
                $material = Component::find($id);
                $nome = 'Componente';
                break;
            default:
                return redirect()->back();
        }
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $material->update($request->except('_token'));
        if ($material)
            return redirect()->back()->with('success', "$nome atualizado com sucesso");


    }

    public function rules_materiais(array $data, $type)
    {
        switch($type){
            case 'glass':
                $validator = Validator::make($data, [
                    'nome' => 'required|string|max:255'
                ]);
                break;
            case 'aluminum':
                $validator = Validator::make($data, [
                    'perfil' => 'required|string|max:255'
                ]);
                break;
            case 'component':
                $validator = Validator::make($data, [
                    'nome' => 'required|string|max:255'
                ]);
                break;
        }

        return $validator;
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
