<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $title = "Lista de Funções";
        $paginate = 10;
        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        }
        $roles = Role::where('nome', 'like', '%' . $request->get('search') . '%')
//            ->orderBy($request->get('field'), $request->get('sort'))
            ->paginate($paginate);
        if ($request->ajax()) {
            return view('dashboard.list.tables.table-role', compact('roles'));
        } else {
            return view('dashboard.list.role', compact('roles', 'title'));
        }
    }

    public function create()
    {
        $title = "Adicionar Função";
        return view('dashboard.create.role', compact('title'));
    }

    public function store(Request $request)
    {
        Role::create($request->all());
        return redirect()->back()->with('success', 'Função criada com sucesso');
    }

    public function edit($id)
    {
        $role = Role::find($id) ?? null;
        if ($role) {
            if ($role->nome === 'admin') {
                return redirect()->route('roles.index')->with('error', 'Não pode alterar função de administrador');
            }
        } else {
            return redirect()->route('roles.index')->with('error', 'Não existe essa função');
        }
        $title = "Atualizar Função";
        return view('dashboard.create.role', compact('role', 'title'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id) ?? null;
        if ($role) {
            if ($role->nome === 'admin') {
                return redirect()->route('roles.index')->with('error', 'Não pode alterar função de administrador');
            }
        } else {
            return redirect()->route('roles.index')->with('error', 'Não existe essa função');
        }
        $role->update($request->all());
        return redirect()->back()->with('success', 'Função atualizada com sucesso');
    }

    public function destroy($id)
    {
        $role = Role::find($id) ?? null;
        if ($role) {
            if ($role->nome === 'admin') {
                return redirect()->route('roles.index')->with('error', 'Não pode deletar função de administrador');
            }
        } else {
            return redirect()->route('roles.index')->with('error', 'Não existe essa função');
        }
        $role->delete();
        return redirect()->back()->with('success', 'Função deletada com sucesso');
    }

    public function permissionshow($id)
    {
        $title = "Lista de Permissões";
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('dashboard.list.role-permission', compact('role', 'permissions', 'title'));
    }

    public function permissionstore(Request $request, $id)
    {
        $role = Role::find($id);
        $permission = Permission::find($request->permission_id);
        if ($role->addPermission($permission)) {
            return redirect()->back()->with('success', 'Permissão adicionada com sucesso');
        }
        return redirect()->back()->with('error', 'Permissão ja foi adicionada ou não existe');
    }

    public function permissiondestroy($id, $permission_id)
    {
        $role = Role::find($id);
        $permission = Permission::find($permission_id);
        $role->removePermission($permission);
        return redirect()->back()->with('success', 'Permissão removida com sucesso');
    }
}
