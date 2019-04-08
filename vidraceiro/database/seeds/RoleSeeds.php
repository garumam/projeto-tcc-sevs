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
        if (!Role::where('nome', '=', 'funcionario')->count()) {
            $funcionario = Role::create([
                'nome' => 'funcionario',
                'descricao' => 'Funcionario'
            ]);

            $userAdmin = new User;
            $userAdmin->name = 'funcionário';
            $userAdmin->email = 'funcionario@funcionario.com';
            $userAdmin->setPasswordAttribute('funcionario');
            $userAdmin->save();

            $userAdmin->roles()->attach($funcionario->id);

            $funcionario->permissions()->attach([5,6,7,9,10,11,12,13,14,15,16,17,18,19,39,40,43,44]);
        }
    }
}
