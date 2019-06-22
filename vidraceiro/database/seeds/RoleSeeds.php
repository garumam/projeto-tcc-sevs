<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class RoleSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Role::where('nome', '=', 'admin')->count()) {
            $admin = Role::create([
                'nome' => 'admin',
                'descricao' => 'Administrador'
            ]);
            $userAdmin = new User;
            $userAdmin->name = 'admin';
            $userAdmin->email = 'admin@admin.com';
            $userAdmin->setPasswordAttribute('admin');
            $userAdmin->save();

            $userAdmin->roles()->attach($admin->id);
        }
        // if (!Role::where('nome', '=', 'funcionario')->count()) {
        //     $funcionario = Role::create([
        //         'nome' => 'funcionario',
        //         'descricao' => 'Funcionario'
        //     ]);

        //     $userAdmin = new User;
        //     $userAdmin->name = 'funcionário';
        //     $userAdmin->email = 'funcionario@funcionario.com';
        //     $userAdmin->setPasswordAttribute('funcionario');
        //     $userAdmin->save();

        //     $userAdmin->roles()->attach($funcionario->id);

        //     $funcionario->permissions()->attach([5,6,7,9,10,11,12,13,14,15,16,17,18,19,39,40,43,44]);
        // }

        if (!Role::where('nome', '=', 'vendedor')->count()) {
            $role = Role::create([
                'nome' => 'vendedor',
                'descricao' => 'Realizar vendas e receber pagamentos'
            ]);
            $user = new User;
            $user->name = 'João';
            $user->email = 'joão@vendedor.com';
            $user->setPasswordAttribute('vendedor');
            $user->save();

            $user->roles()->attach($role->id);

            $role->permissions()->attach([13,14,15]);
        }

        if (!Role::where('nome', '=', 'atendente')->count()) {
            $role = Role::create([
                'nome' => 'atendente',
                'descricao' => 'Lidar com pessoas'
            ]);
            $user = new User;
            $user->name = 'Maria';
            $user->email = 'maria@atendente.com';
            $user->setPasswordAttribute('atendente');
            $user->save();

            $user->roles()->attach($role->id);

            $role->permissions()->attach([9,10,11,12,5,6,7,33,34,39,43,44]);
        }

        if (!Role::where('nome', '=', 'serralheiro')->count()) {
            $role = Role::create([
                'nome' => 'serralheiro',
                'descricao' => 'Realizar os serviços'
            ]);
            $user = new User;
            $user->name = 'Pedro';
            $user->email = 'pedro@serralheiro.com';
            $user->setPasswordAttribute('serralheiro');
            $user->save();

            $user->roles()->attach($role->id);

            $role->permissions()->attach([16,17,18,19]);
        }

        if (!Role::where('nome', '=', 'estoquista')->count()) {
            $role = Role::create([
                'nome' => 'estoquista',
                'descricao' => 'Lidar com o estoque'
            ]);
            $user = new User;
            $user->name = 'Leandro';
            $user->email = 'leandro@estoquista.com';
            $user->setPasswordAttribute('estoquista');
            $user->save();

            $user->roles()->attach($role->id);

            $role->permissions()->attach([24,25,41]);
        }

        if (!Role::where('nome', '=', 'gestor financeiro')->count()) {
            $role = Role::create([
                'nome' => 'gestor financeiro',
                'descricao' => 'Realiza o controle financeiro'
            ]);
            $user = new User;
            $user->name = 'Letícia';
            $user->email = 'leticia@gestora.com';
            $user->setPasswordAttribute('gestor');
            $user->save();

            $user->roles()->attach($role->id);

            $role->permissions()->attach([26,27,28,42]);
        }

    }
}
