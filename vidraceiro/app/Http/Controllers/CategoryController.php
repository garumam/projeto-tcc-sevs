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
        return view('dashboard.create.category')->with('title', 'Adicionar Categoria');
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
