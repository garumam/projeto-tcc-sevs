<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function create(Request $request)
    {
        $validado = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validado->fails()){
            return redirect()->back()->withErrors($validado);
        }
        $user = new User;
        $user = $user->create($request->all());
        if ($user)
            return redirect()->back()->with('success', 'Usuario criado com sucesso');

    }

    public function read()
    {
        $users = User::all();
        return view('dashboard.list.listuser', compact('users'))->with('title', 'Listar usuarios');
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
