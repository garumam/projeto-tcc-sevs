<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.list.product')->with('title', 'Produto');
    }


    public function create(){

        return view('dashboard.create.product')->with('title', 'Criar Produto');

    }
    public function read(){

    }
    public function update(){

    }
    public function delete(){

    }
}
