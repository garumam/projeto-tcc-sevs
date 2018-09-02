<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Category;
use App\Component;
use App\Glass;
use App\Provider;
use App\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    protected $espessuraAlum;

    public function __construct()
    {
        $this->middleware('auth');

        $this->espessuraAlum = [
            ' '=>'Selecione uma espessura(opcional)',
            '8'=>'Linha Temperado 8mm',
            '10'=>'Linha Temperado 10mm',
            '25'=>'Linha Suprema 25mm',
            '33'=>'Linha Gold 33mm'
        ];
    }

    public function index()
    {
        $aluminums = Aluminum::where('is_modelo',1)->get();
        $glasses = Glass::where('is_modelo',1)->get();
        $components = Component::where('is_modelo',1)->get();
        $titulotabs = ['Vidros','Aluminios','Componentes'];
        return view('dashboard.list.material', compact('titulotabs', 'aluminums', 'glasses', 'components'))->with('title', 'Materiais');
    }

    public function create($type)
    {
        $providers = Provider::all();
        $espessuras = $this->espessuraAlum;
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
        return view('dashboard.create.material',compact('type','categories', 'providers','espessuras'))->with('title','Criar '.$nome);
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

        $material = $material->create(array_merge($request->except('providers'), ['is_modelo' => 1]));
        if(!empty($request->providers)){
            if(count($request->providers) > 0){
                $material->providers()->sync($request->providers);
            }
        }


        if ($material){
            if($type === 'glass'){
                Storage::create([
                    'metros_quadrados' => 0,
                    'glass_id' => $material->id
                ]);
            }elseif($type === 'aluminum'){
                Storage::create([
                    'qtd' => 0,
                    'aluminum_id' => $material->id
                ]);
            }elseif($type === 'component'){
                Storage::create([
                    'qtd' => 0,
                    'component_id' => $material->id
                ]);
            }
            return redirect()->back()->with('success', "$nome criado com sucesso");
        }

    }

    public function show()
    {

    }

    public function edit($type, $id)
    {
        $providers = Provider::all();
        $espessuras = $this->espessuraAlum;
        switch($type){
            case 'glass':
                $material = Glass::with('providers')->find($id);
                $categories = Category::where('tipo','vidro')->get();
                $nome = 'vidro';
                break;
            case 'aluminum':
                $material = Aluminum::with('providers')->find($id);
                $categories = Category::where('tipo','aluminio')->get();
                $nome = 'alumínio';
                break;
            case 'component':
                $material = Component::with('providers')->find($id);
                //$categories = Category::where('tipo','componente')->get();
                $categories = Category::all();
                $nome = 'componente';
                break;
            default:
                return redirect()->back();
        }

        return view('dashboard.create.material',compact('type','material','categories', 'providers', 'espessuras'))->with('title','Atualizar '.$nome);
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
        $material->update($request->except('_token','providers'));

        $material->providers()->sync($request->providers);

        if ($material)
            return redirect()->back()->with('success', "$nome atualizado com sucesso");


    }

    public function rules_materiais(array $data, $type)
    {
        switch($type){
            case 'glass':
                $validator = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'cor' => 'required|string|max:255',
                    'tipo' => 'required|string|max:255',
                    'espessura' => 'required|integer',
                    'preco' => 'nullable|numeric',
                    'categoria_vidro_id' => 'required|integer'
                ]);
                break;
            case 'aluminum':
                $validator = Validator::make($data, [
                    'perfil' => 'required|string|max:255',
                    'descricao' => 'nullable|string|max:255',
                    'medida' => 'nullable|numeric',
                    'qtd' => 'required|integer',
                    'peso' => 'nullable|numeric',
                    'preco' => 'nullable|numeric',
                    'tipo_medida' => 'required|string|max:255',
                    'categoria_aluminio_id' => 'required|integer'
                ]);
                break;
            case 'component':
                $validator = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'qtd' => 'required|integer',
                    'preco' => 'nullable|numeric',
                    'categoria_componente_id' => 'required|integer'
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
