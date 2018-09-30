<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $role;
    public function __construct(Role $role)
    {
        $this->middleware('auth');
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $title = "Lista de Funções";

        $roles = $this->role->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

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
        $this->role->createRole($request->all());
        return redirect()->back()->with('success', 'Função criada com sucesso');
    }

    public function edit($id)
    {
        $role = $this->role->findRoleById($id) ?? null;
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
        $role = $this->role->findRoleById($id) ?? null;
        if ($role) {
            if ($role->nome === 'admin') {
                return redirect()->route('roles.index')->with('error', 'Não pode alterar função de administrador');
            }
        } else {
            return redirect()->route('roles.index')->with('error', 'Não existe essa função');
        }
        $role->updateRole($request->all());
        return redirect()->back()->with('success', 'Função atualizada com sucesso');
    }

    public function destroy($id)
    {
        $role = $this->role->findRoleById($id) ?? null;
        if ($role) {
            if ($role->nome === 'admin') {
                return redirect()->route('roles.index')->with('error', 'Não pode deletar função de administrador');
            }
        } else {
            return redirect()->route('roles.index')->with('error', 'Não existe essa função');
        }
        $role->deleteRole();
        return redirect()->back()->with('success', 'Função deletada com sucesso');
    }

    public function permissionshow(Request $request, $id)
    {
        $title = "Lista de Permissões";
        $role = $this->role->findRoleById($id);
        $permissions = Permission::getAll();

        $permissionsroles = Permission::getPermissionsByRoleIdWithSearchAndPagination($id,$request->get('search'),$request->get('paginate'));

        if ($request->ajax()) {
            return view('dashboard.list.tables.table-role-permission', compact('role', 'permissionsroles'));
        } else {
            return view('dashboard.list.role-permission', compact('role', 'permissions', 'title', 'permissionsroles'));
        }
    }

    public function permissionstore(Request $request, $id)
    {
        $role = $this->role->findRoleById($id);
        $permission = new Permission();
        $permission = $permission->findPermissionById($request->permission_id);

        if ($role->addPermission($permission)) {
            return redirect()->back()->with('success', 'Permissão adicionada com sucesso');
        }
        return redirect()->back()->with('error', 'Permissão ja foi adicionada ou não existe');
    }

    public function permissiondestroy($id, $permission_id)
    {
        $role = $this->role->findRoleById($id);
        $permission = new Permission();
        $permission = $permission->findPermissionById($permission_id);
        $role->removePermission($permission);
        return redirect()->back()->with('success', 'Permissão removida com sucesso');
    }
}
