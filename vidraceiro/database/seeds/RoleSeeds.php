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
            $admin = Role::create([
                'nome' => 'funcionario',
                'descricao' => 'Funcionario'
            ]);
        }
    }
}
