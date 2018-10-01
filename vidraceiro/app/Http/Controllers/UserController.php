<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    public function index(Request $request)
    {
        if (!Auth::user()->can('usuario_listar', User::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $users = $this->user->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));

        if ($request->ajax()) {
            return view('dashboard.list.tables.table-user', compact('users'));
        } else {
            return view('dashboard.list.user', compact('users'))->with('title', 'Usuarios');
        }
    }

    public function create()
    {
        if (!Auth::user()->can('usuario_adicionar', User::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        return view('dashboard.create.user')->with('title', 'Criar usuario');

    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('usuario_adicionar', User::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_users($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $user = $this->user;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $destino = 'img/users/';
            $image->move($destino, $image->getClientOriginalName());
//            $user->name = $request->get('name');
//            $user->email = $request->get('email');
//            $user->password = $request->get('password');
//            $user->image = $destino . $image->getClientOriginalName();
//            $user->save();
            $resq = $request->except('image');
            $resq['image'] = $destino . $image->getClientOriginalName();
            $user = $user->createUser($resq);
        } else {
            $user = $user->createUser($request->except('image'));
        }
        if ($user)
            return redirect()->back()->with('success', 'Usuario criado com sucesso');

    }

    public function show($user)
    {
        if (!Auth::user()->can('usuario_listar', User::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $users = $this->user->findUserById($user);
        return view('dashboard.list.user', compact('users'))->with('title', 'Listar usuarios');
    }

    public function edit($id)
    {
        if (!Auth::user()->can('usuario_atualizar', User::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_user_exists(['id' => $id]);

        if ($validado->fails()) {
            return redirect(route('users.index'))->withErrors($validado);
        }

        $user = $this->user->findUserById($id);
        return view('dashboard.create.user', compact('user'))->with('title', 'Atualizar usuario');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('usuario_atualizar', User::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $user = $this->user->findUserById($id);
        $validado = $this->rules_update_users(array_merge($request->all(), ['id' => $id]));
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $resq = $request->except(['_token', 'image']);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $destino = 'img/users/';
            $image->move($destino, $image->getClientOriginalName());
            $resq['image'] = $destino . $image->getClientOriginalName();
        }
        $user->updateUser($resq);
        if ($user)
            return redirect()->back()->with('success', 'Usuario atualizado com sucesso');

        return view('dashboard.create.user', compact('user'))->with('title', 'Atualizar usuario');
    }

    public function showdelete($id)
    {
        return view('dashboard.modal.delete');

    }

    public function roleshow(Request $request, $id)
    {
        if (!Auth::user()->can('usuario_listar', User::class) || $id == 1) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }
        if (!Auth::user()->can('usuario_atualizar', User::class)) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_user_exists(['id' => $id]);

        if ($validado->fails()) {
            return redirect(route('users.index'))->withErrors($validado);
        }

        $title = "Lista de Funções";
        $user = $this->user->findUserById($id);
        $roles = Role::getAll();

        $rolesusuario = Role::getRoleByUserIdWithSearchAndPagination($id,$request->get('search'),$request->get('paginate'));

        if ($request->ajax()) {
            return view('dashboard.list.tables.table-user-role', compact('user', 'rolesusuario'));
        } else {
            return view('dashboard.list.user-role', compact('user', 'roles', 'title', 'rolesusuario'));
        }


    }

    public function rolestore(Request $request, $id)
    {
        if (!Auth::user()->can('usuario_atualizar', User::class) || $id == 1) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $user = $this->user->findUserById($id);
        $role = new Role();
        $role = $role->findRoleById($request->role_id);
        if ($user->addRole($role)) {
            return redirect()->back()->with('success', 'Função adicionada no usuario');
        }
        return redirect()->back()->with('error', 'Função ja foi adicionada ou não existe essa função');
    }

    public function roledestroy($id, $role_id)
    {
        if (!Auth::user()->can('usuario_atualizar', User::class) || $id == 1) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $user = $this->user->findUserById($id);
        $role = new Role();
        $role = $role->findRoleById($role_id);
        $user->removeRole($role);
        return redirect()->back()->with('success', 'Função removida do usuario');
    }

    public function destroy($id)
    {
        if (!Auth::user()->can('usuario_deletar', User::class) || $id == 1) {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $user = $this->user->findUserById($id);
        if ($user) {
            $user->deleteUser();
            return redirect()->back()->with('success', 'Usuario deletado com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar usuario');
        }

    }

    public function rules_users(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        return $validator;
    }

    public function rules_update_users(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|min:6',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'exists' => 'Não existe este usuário!',
        ]);

        return $validator;
    }

    public function rules_user_exists(array $data)
    {
        $validator = Validator::make($data,
            [
                'id' => 'exists:users,id'
            ], [
                'exists' => 'Não existe este usuário!',
            ]
        );
        return $validator;
    }
}
