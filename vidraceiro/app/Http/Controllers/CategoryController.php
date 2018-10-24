<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected $types, $group_images_produto,$group_images_aluminio,$group_images_componente;
    protected $category;
    public function __construct(Category $category)
    {
        $this->middleware('auth');
        $this->types = array(
            '' => 'Selecione..',
            'produto' => 'Produto',
            'vidro' => 'Vidro',
            'aluminio' => 'Aluminio',
            'componente' => 'Componente'

        );

        $this->group_images_produto = array(
            'boxdiversos' => 'Box diversos',
            'boxpadrao' => 'Box padrão',
            'ferragem1000' => 'Ferragem 1000',
            'ferragem3000' => 'Ferragem 3000',
            'kitsacada' => 'Kit sacada',
            'todasimagens' => 'Todas as imagens'
        );

        $this->group_images_aluminio = array(
            'portaeportoes' => 'Porta e Portões',
            'suprema' => 'Suprema',
            'temperado8mm' => 'Temperado 8mm',
            'todasimagens' => 'Todas as imagens'
        );

        $this->group_images_componente = array(
            'componentes' => 'Componentes',
            'todasimagens' => 'Todas as imagens'
        );

        $this->category = $category;
    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('modelo_listar', Category::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $categories = $this->category->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if ($request->ajax()) {
            return view('dashboard.list.tables.table-category', compact('categories'));
        }

        return view('dashboard.list.category', compact('categories'))->with('title', 'Categorias');

    }

    public function create()
    {
        if(!Auth::user()->can('modelo_adicionar', Category::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $types = $this->types;

        $group_images_produto = $this->group_images_produto;
        $group_images_aluminio = $this->group_images_aluminio;
        $group_images_componente = $this->group_images_componente;
        return view('dashboard.create.category', compact('types', 'group_images_produto', 'group_images_aluminio', 'group_images_componente'))->with('title', 'Adicionar Categoria');
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('modelo_adicionar', Category::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_category($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $category = $this->category->createCategory($request->all());

        if ($category)
            return redirect()->back()->with('success', 'Categoria criada com sucesso');
    }

    public function show()
    {

    }

    public function edit($id)
    {
        if(!Auth::user()->can('modelo_atualizar', Category::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_category_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('categories.index'))->withErrors($validado);
        }

        $category = $this->category->findCategoryById($id);
        $types = $this->types;
        $group_images_produto = $this->group_images_produto;
        $group_images_aluminio = $this->group_images_aluminio;
        $group_images_componente = $this->group_images_componente;
        return view('dashboard.create.category', compact('category', 'types', 'group_images_produto', 'group_images_aluminio', 'group_images_componente'))->with('title', 'Atualizar categoria');
    }


    public function update(Request $request, $id)
    {
        if(!Auth::user()->can('modelo_atualizar', Category::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_category_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('categories.index'))->withErrors($validado);
        }

        $validado = $this->rules_category($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $category = $this->category->findCategoryById($id);
        if ($category) {
            $category->updateCategory($request->all());
            return redirect()->back()->with('success', 'Categoria atualizada com sucesso');
        }

    }

    public function destroy($id)
    {
        if(!Auth::user()->can('modelo_deletar', Category::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $category = $this->category->findCategoryById($id);
        if ($category) {
            $category->deleteCategory();
            return redirect()->back()->with('success', 'Categoria deletada com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar categoria');
        }
    }

    public function rules_category(array $data)
    {
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'grupo_imagem' => 'required|string|max:255'
        ]);

        return $validator;
    }

    public function rules_category_exists(array $data)
    {
        $validator = Validator::make($data,
            [
                'id' => 'exists:categories,id'
            ], [
                'exists' => 'Esta categoria não existe!',
            ]
        );
        return $validator;
    }

}
