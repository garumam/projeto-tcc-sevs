<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.create.createuser')->with('title', 'Criar usuario');
    }

    public function create()
    {

    }

    public function read()
    {
        return view('dashboard.list.listuser')->with('title', 'Listar usuarios');
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
