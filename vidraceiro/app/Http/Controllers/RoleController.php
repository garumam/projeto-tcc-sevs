<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        $title = "Lista de Funções";
        return view('dashboard.list.role',compact('roles','title'));
    }
}
