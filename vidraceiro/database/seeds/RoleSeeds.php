<?php

use App\Role;
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
        }
        if (!Role::where('nome', '=', 'funcionario')->count()) {
            $admin = Role::create([
                'nome' => 'funcionario',
                'descricao' => 'Funcionario'
            ]);
        }
    }
}
