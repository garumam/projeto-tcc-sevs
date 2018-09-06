<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(CarregaItens::class);
        $this->call(CarregaItensTeste::class);
        factory(App\Client::class, 10)->create();
        factory(App\MProduct::class, 20)->create();
        factory(App\Budget::class, 15)->create();
        //product e glass precisam ser geradas com a mesma quantidade ,para testar
        //e deve ser alterado em modelsfactory la em glass o max do between
        // $faker->unique()->numberBetween(4,33) de 33 para a quantidade
        // gerada + 3
        factory(App\Product::class, 30)->create();
        factory(App\Glass::class, 30)->create();
    }
}
