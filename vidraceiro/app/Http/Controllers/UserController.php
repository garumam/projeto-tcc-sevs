<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Auth::user()->can('usuario_listar',User::class)) {
            $paginate = 10;
            if ($request->get('paginate')) {
                $paginate = $request->get('paginate');
            }
            $users = User::where('name', 'like', '%' . $request->get('search') . '%')
//            ->orderBy($request->get('field'), $request->get('sort'))
                ->paginate($paginate);
            if ($request->ajax()) {
                return view('dashboard.list.tables.table-user', compact('users'));
            } else {
                return view('dashboard.list.user', compact('users'))->with('title', 'Usuarios');
            }
        } else {
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa pagina');
        }
    }

    public function create()
    {
        return view('dashboard.create.user')->with('title', 'Criar usuario');

    }

    public function store(Request $request)
    {
        $validado = $this->rules_users($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }
        $user = new User;
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
            $user = $user->create($resq);
        } else {
            $user = $user->create($request->except('image'));
        }
        if ($user)
            return redirect()->back()->with('success', 'Usuario criado com sucesso');

    }

    public function show($user)
    {
        $users = User::findOrFail($user);
        return view('dashboard.list.user', compact('users'))->with('title', 'Listar usuarios');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('dashboard.create.user', compact('user'))->with('title', 'Atualizar usuario');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validado = $this->rules_update_users($request->all());
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
        $user->update($resq);
        if ($user)
            return redirect()->back()->with('success', 'Usuario atualizado com sucesso');

        return view('dashboard.create.user', compact('user'))->with('title', 'Atualizar usuario');
    }

    public function showdelete($id)
    {
        return view('dashboard.modal.delete');

    }

    public function roleshow($id)
    {
        $title = "Lista de Funções";
        $user = User::find($id);
        $roles = Role::all();
        return view('dashboard.list.user-role', compact('user', 'roles', 'title'));
    }

    public function rolestore(Request $request, $id)
    {
        $user = User::find($id);
        $role = Role::find($request->role_id);
        if ($user->addRole($role)) {
            return redirect()->back()->with('success', 'Função adicionada no usuario');
        }
        return redirect()->back()->with('error', 'Função ja foi adicionada ou não existe essa função');
    }

    public function roledestroy($id, $role_id)
    {
        $user = User::find($id);
        $role = Role::find($role_id);
        $user->removeRole($role);
        return redirect()->back()->with('success', 'Função removida do usuario');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|min:6',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        return $validator;
    }
}
