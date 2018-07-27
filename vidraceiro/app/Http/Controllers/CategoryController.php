<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.list.category')->with('title', 'Categoria');
    }

    public function create(){
        return view('dashboard.create.category')->with('title', 'Adicionar Categoria');
    }
    public function read(){

    }
    public function update(){

    }
    public function delete(){

    }
}
