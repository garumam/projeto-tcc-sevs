<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Permission::where('nome', '=', 'usuario_listar')->count()) {
            Permission::create([
                'nome' => 'usuario_listar',
                'descricao' => 'Listar Usuarios'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'usuario_listar')->first();
            $permission->update([
                'nome' => 'usuario_listar',
                'descricao' => 'Listar Usuarios'
            ]);
        }

        if (!Permission::where('nome', '=', 'usuario_adicionar')->count()) {
            Permission::create([
                'nome' => 'usuario_adicionar',
                'descricao' => 'Adicionar Usuarios'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'usuario_adicionar')->first();
            $permission->update([
                'nome' => 'usuario_adicionar',
                'descricao' => 'Adicionar Usuarios'
            ]);
        }

        if (!Permission::where('nome', '=', 'usuario_atualizar')->count()) {
            Permission::create([
                'nome' => 'usuario_atualizar',
                'descricao' => 'Atualizar Usuarios'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'usuario_atualizar')->first();
            $permission->update([
                'nome' => 'usuario_atualizar',
                'descricao' => 'Atualizar Usuarios'
            ]);
        }

        if (!Permission::where('nome', '=', 'usuario_deletar')->count()) {
            Permission::create([
                'nome' => 'usuario_deletar',
                'descricao' => 'Remover Usuarios'
            ]);
        } else {
            $permission = Permission::where('nome', '=', 'usuario_deletar')->first();
            $permission->update([
                'nome' => 'usuario_deletar',
                'descricao' => 'Remover Usuarios'
            ]);
        }
    }
}
