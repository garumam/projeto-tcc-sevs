<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::all();
        return view('dashboard.list.category', compact('categories'))->with('title', 'Categorias');
    }

    public function create()
    {
        $types = array(
            '' => 'Selecione..',
            0 => 'Produto',
            1 => 'Vidro',
            2 => 'Aluminio',
            3 => 'Componente'

        );

        $group_images = array(
            '' => 'Selecione..',
            1 => 'Box diversos',
            2 => 'Box padrão',
            3 => 'Ferragem 1000',
            4 => 'Ferragem 3000',
            5 => 'Kit sacada',
            6 => 'Todas as imagens'
        );
        return view('dashboard.create.category', compact('types', 'group_images'))->with('title', 'Adicionar Categoria');
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
