<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        if(!Auth::user()->can('funcao_listar', Role::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

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
        if(!Auth::user()->can('funcao_adicionar', Role::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $title = "Adicionar Função";
        return view('dashboard.create.role', compact('title'));
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('funcao_adicionar', Role::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_role_unique(['nome' => $request->nome]);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $this->role->createRole($request->all());
        return redirect()->back()->with('success', 'Função criada com sucesso');
    }

    public function edit($id)
    {
        if(!Auth::user()->can('funcao_atualizar', Role::class) || $id == 1){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

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
        if(!Auth::user()->can('funcao_atualizar', Role::class) || $id == 1){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_role_unique(['nome' => $request->nome],$id);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

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
        if(!Auth::user()->can('funcao_deletar', Role::class) || $id == 1){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

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
        if(!Auth::user()->can('funcao_listar', Role::class) || $id == 1){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }
        if(!Auth::user()->can('funcao_atualizar', Role::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }


        $title = "Lista de Permissões";
        $role = $this->role->findRoleById($id);
        if(!$role)
            return redirect()->route('roles.index')->with('error', 'Não existe essa função');

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
        if(!Auth::user()->can('funcao_atualizar', Role::class) || $id == 1){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

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
        if(!Auth::user()->can('funcao_atualizar', Role::class) || $id == 1){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $role = $this->role->findRoleById($id);
        $permission = new Permission();
        $permission = $permission->findPermissionById($permission_id);
        $role->removePermission($permission);
        return redirect()->back()->with('success', 'Permissão removida com sucesso');
    }

    public function rules_role_unique(array $data,$ignoreId = '')
    {
        $validator = Validator::make($data,
            [
                'nome' => 'unique:roles,nome,'.$ignoreId
            ]
        );
        return $validator;
    }

}
