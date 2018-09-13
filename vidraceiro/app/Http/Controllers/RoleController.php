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
    public function create(){
        $title = "Adicionar Função";
        return view('dashboard.create.role',compact('title'));
    }
    public function store(Request $request){
        Role::create($request->all());
        return redirect()->back()->with('success','Função criada com sucesso');
    }
    public function edit($id){
        $role = Role::find($id) ?? null;
        if ($role){
            if ($role->nome === 'admin'){
                return redirect()->route('roles.index')->with('error','Não pode alterar função de administrador');
            }
        }else{
            return redirect()->route('roles.index')->with('error','Não existe essa função');
        }
        $title = "Atualizar Função";
        return view('dashboard.create.role',compact('role','title'));
    }
    public function update(Request $request,$id){
        $role = Role::find($id) ?? null;
        if ($role){
            if ($role->nome === 'admin'){
                return redirect()->route('roles.index')->with('error','Não pode alterar função de administrador');
            }
        }else{
            return redirect()->route('roles.index')->with('error','Não existe essa função');
        }
        $role->update($request->all());
        return redirect()->back()->with('success','Função atualizada com sucesso');
    }
    public function destroy($id){
        $role = Role::find($id) ?? null;
        if ($role){
            if ($role->nome === 'admin'){
                return redirect()->route('roles.index')->with('error','Não pode deletar função de administrador');
            }
        }else{
            return redirect()->route('roles.index')->with('error','Não existe essa função');
        }
        $role->delete();
        return redirect()->back()->with('success','Função deletada com sucesso');
    }
}
