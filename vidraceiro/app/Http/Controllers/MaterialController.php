<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Category;
use App\Component;
use App\Glass;
use App\Provider;
use App\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    protected $espessuraAlum;
    protected $glass,$aluminum,$component;
    public function __construct(Glass $glass,Aluminum $aluminum, Component $component)
    {
        $this->middleware('auth');

        $this->glass = $glass;
        $this->aluminum = $aluminum;
        $this->component = $component;

        $this->espessuraAlum = [
            ' ' => 'Selecione uma espessura(opcional)',
            '8' => 'Linha Temperado 8mm',
            '10' => 'Linha Temperado 10mm',
            '25' => 'Linha Suprema 25mm',
            '33' => 'Linha Gold 33mm'
        ];
    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('modelo_listar', [Glass::class,Aluminum::class,Component::class])){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $titulotabs = ['Vidros', 'Aluminios', 'Componentes'];

        if($request->has('vidros') || !$request->ajax())
            $glasses = $this->glass->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if($request->has('aluminios') || !$request->ajax())
            $aluminums = $this->aluminum->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if($request->has('componentes') || !$request->ajax())
            $components = $this->component->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if ($request->ajax()) {
            if ($request->has('vidros')) {
                return view('dashboard.list.tables.table-glass', compact('glasses'));
            }
            if ($request->has('aluminios')) {
                return view('dashboard.list.tables.table-aluminum', compact('aluminums'));
            }
            if ($request->has('componentes')) {
                return view('dashboard.list.tables.table-component', compact('components'));
            }
        } else {
            return view('dashboard.list.material', compact('titulotabs', 'aluminums', 'glasses', 'components'))->with('title', 'Materiais');
        }
    }

    public function create($type)
    {
        if(!Auth::user()->can('modelo_adicionar', [Glass::class,Aluminum::class,Component::class])){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $providers = Provider::getAll();
        $espessuras = $this->espessuraAlum;
        switch ($type) {
            case 'glass':
                $categories = Category::getAllCategoriesByType('vidro');
                $nome = 'vidro';
                break;
            case 'aluminum':
                $portaeportoes = $this->retornaNomes('/img/portaeportoes/');
                $suprema = $this->retornaNomes('/img/suprema/');
                $temperado8mm = $this->retornaNomes('/img/temperado8mm/');
                $categories = Category::getAllCategoriesByType('aluminio');
                $nome = 'alumínio';
                break;
            case 'component':
                $componentes = $this->retornaNomes('/img/componentes/');
                $categories = Category::getAllCategoriesByType('componente');
                $nome = 'componente';
                break;
            default:
                return redirect()->back();
        }
        return view('dashboard.create.material', compact('type', 'categories', 'providers', 'espessuras','portaeportoes','suprema','temperado8mm','componentes'))->with('title', 'Criar ' . $nome);
    }

    public function store(Request $request, $type)
    {
        if(!Auth::user()->can('modelo_adicionar', [Glass::class,Aluminum::class,Component::class])){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_materiais($request->all(), $type);
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        switch ($type) {
            case 'glass':

                $material = $this->glass;
                $material = $material->createGlass(array_merge($request->all(), ['is_modelo' => 1]));
                $nome = 'Vidro';

                break;
            case 'aluminum':

                $material = $this->aluminum;
                $material = $material->createAluminum(array_merge($request->all(), ['is_modelo' => 1]));
                $nome = 'Alumínio';

                break;
            case 'component':

                $material = $this->component;
                $material = $material->createComponent(array_merge($request->all(), ['is_modelo' => 1]));
                $nome = 'Componente';

                break;
            default:
                return redirect()->back();
        }


        if (!empty($request->providers)) {
            if (count($request->providers) > 0) {
                $material->syncProviders($request->providers);
            }
        }


        if ($material) {
            return redirect()->back()->with('success', "$nome criado com sucesso");
        }

        return redirect()->back()->with('error', "Erro ao criar material");

    }

    public function show($type, $id)
    {
        if(!Auth::user()->can('modelo_listar', [Glass::class,Aluminum::class,Component::class])){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $material = null;
        $mensagem = $tabela = '';
        switch ($type) {
            case 'glass':
                $material = $this->glass->findGlassById($id);
                $mensagem = 'vidro';
                $tabela = 'glasses';
                break;
            case 'aluminum':
                $material = $this->aluminum->findAluminumById($id);
                $mensagem = 'alumínio';
                $tabela = 'aluminums';
                break;
            case 'component':
                $material = $this->component->findComponentById($id);
                $mensagem = 'componente';
                $tabela = 'components';
                break;
            default:
                return redirect()->back();
        }

        $validado = $this->rules_material_exists(['id'=>$id],$tabela);

        if ($validado->fails()) {
            return redirect(route('materials.index'))->withErrors($validado);
        }else{
            if($material->is_modelo === 0) {
                return redirect(route('materials.index'))->with('error', 'Este material não existe!');
            }
        }

        return view('dashboard.show.material',
            compact('material', 'type'))->with('title', 'Informações do ' . $mensagem);
    }

    public function edit($type, $id)
    {
        if(!Auth::user()->can('modelo_atualizar', [Glass::class,Aluminum::class,Component::class])){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $providers = Provider::getAll();
        $espessuras = $this->espessuraAlum;
        $tabela = '';
        switch ($type) {
            case 'glass':
                $material = $this->glass->findGlassById($id);
                $categories = Category::getAllCategoriesByType('vidro');
                $nome = 'vidro';
                $tabela = 'glasses';
                break;
            case 'aluminum':
                $portaeportoes = $this->retornaNomes('/img/portaeportoes/');
                $suprema = $this->retornaNomes('/img/suprema/');
                $temperado8mm = $this->retornaNomes('/img/temperado8mm/');
                $material = $this->aluminum->findAluminumById($id);
                $categories = Category::getAllCategoriesByType('aluminio');
                $nome = 'alumínio';
                $tabela = 'aluminums';
                break;
            case 'component':
                $componentes = $this->retornaNomes('/img/componentes/');
                $material = $this->component->findComponentById($id);
                $categories = Category::getAllCategoriesByType('componente');
                $nome = 'componente';
                $tabela = 'components';
                break;
            default:
                return redirect()->back();
        }

        $validado = $this->rules_material_exists(['id'=>$id],$tabela);

        if ($validado->fails()) {
            return redirect(route('materials.index'))->withErrors($validado);
        }else{
            if($material->is_modelo === 0) {
                return redirect(route('materials.index'))->with('error', 'Este material não existe!');
            }
        }

        return view('dashboard.create.material', compact('type', 'material', 'categories', 'providers', 'espessuras','portaeportoes','suprema','temperado8mm','componentes'))->with('title', 'Atualizar ' . $nome);
    }


    public function update(Request $request, $type, $id)
    {
        if(!Auth::user()->can('modelo_atualizar', [Glass::class,Aluminum::class,Component::class])){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_materiais($request->all(), $type);
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $tabela = '';
        switch ($type) {
            case 'glass':

                $material = $this->glass->findGlassById($id);
                $nome = 'Vidro';
                $tabela = 'glasses';

                break;
            case 'aluminum':

                $material = $this->aluminum->findAluminumById($id);
                $nome = 'Alumínio';
                $tabela = 'aluminums';

                break;
            case 'component':

                $material = $this->component->findComponentById($id);
                $nome = 'Componente';
                $tabela = 'components';

                break;
            default:
                return redirect()->back();
        }


        $validado = $this->rules_material_exists(['id'=>$id],$tabela);

        if ($validado->fails()) {
            return redirect(route('materials.index'))->withErrors($validado);
        }else{
            if($material->is_modelo === 0) {
                return redirect(route('materials.index'))->with('error', 'Este material não existe!');
            }
        }

        switch ($type) {
            case 'glass':

                $material->updateGlass($request->all());

                break;
            case 'aluminum':

                $material->updateAluminum($request->all());

                break;
            case 'component':

                $material->updateComponent($request->all());

                break;
            default:
                return redirect()->back();
        }


        $material->syncProviders($request->providers);

        if ($material)
            return redirect()->back()->with('success', "$nome atualizado com sucesso");


    }

    public function destroy($type, $id)
    {
        if(!Auth::user()->can('modelo_deletar', [Glass::class,Aluminum::class,Component::class])){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        switch ($type) {
            case 'glass':
                $material = $this->glass->findGlassById($id);
                if ($material)
                    $material->deleteGlass();
                $tipoNome = 'Vidro';
                break;
            case 'aluminum':
                $material = $this->aluminum->findAluminumById($id);
                if ($material)
                    $material->deleteAluminum();
                $tipoNome = 'Alumínio';
                break;
            case 'component':
                $material = $this->component->findComponentById($id);
                if ($material)
                    $material->deleteComponent();
                $tipoNome = 'Componente';
                break;
        }

        if ($material)
            return redirect()->back()->with('success', "$tipoNome deletado com sucesso");


        return redirect()->back()->with('error', "Erro ao deletar $tipoNome");

    }

    public function retornaNomes($folder)
    {
        $filename = [];
        $files = File::files(public_path() . $folder);
        foreach ($files as $file) {
            $filename[] = pathinfo($file, PATHINFO_BASENAME);
        }
        return $filename;
    }


    public function rules_materiais(array $data, $type)
    {
        switch ($type) {
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

    public function rules_material_exists(array $data, $tabela)
    {

        $validator = Validator::make($data,

            [
                'id' => 'exists:'.$tabela.',id'
            ], [
                'exists' => 'Este material não existe!',
            ]

        );

        return $validator;
    }


}
