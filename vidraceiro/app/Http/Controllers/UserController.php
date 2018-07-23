<?php

namespace App\Http\Controllers;

use App\User;
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
        $users = User::all();
        return view('dashboard.list.listuser',compact('users'))->with('title', 'Listar usuarios');
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
