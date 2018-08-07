<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $types, $group_images;

    public function __construct()
    {
        $this->middleware('auth');
        $this->types = array(
            '' => 'Selecione..',
            'produto' => 'Produto',
            'vidro' => 'Vidro',
            'aluminio' => 'Aluminio',
            'componente' => 'Componente'

        );

        $this->group_images = array(
            '' => 'Selecione..',
            'boxdiversos' => 'Box diversos',
            'boxpadrao' => 'Box padrão',
            'ferragem1000' => 'Ferragem 1000',
            'ferragem3000' => 'Ferragem 3000',
            'kitsacada' => 'Kit sacada',
            'todasimagens' => 'Todas as imagens'
        );
    }

    public function index()
    {
        $categories = Category::all();
        return view('dashboard.list.category', compact('categories'))->with('title', 'Categorias');
    }

    public function create()
    {
        $types = $this->types;
        $group_images = $this->group_images;
        return view('dashboard.create.category', compact('types', 'group_images'))->with('title', 'Adicionar Categoria');
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category = $category->create($request->all());
        if ($category)
            return redirect()->back()->with('success', 'Categoria criada com sucesso');
    }

    public function show()
    {

    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $types = $this->types;
        $group_images = $this->group_images;
        return view('dashboard.create.category', compact('category', 'types', 'group_images'))->with('title', 'Atualizar categoria');
    }


    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->update($request->all());
            return redirect()->back()->with('success', 'Categoria atualizada com sucesso');
        }

    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return redirect()->back()->with('success', 'Categoria deletada com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar categoria');
        }
    }
}
