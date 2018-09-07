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
        factory(App\Aluminum::class, 50)->create();
        factory(App\Component::class, 50)->create();
        $this->atualizaTotal();

    }

    public function atualizaTotal()
    {

        $budgets = App\Budget::with('products')->get();

        foreach ($budgets as $budgetcriado){


            $productsids = array();
            foreach ($budgetcriado->products as $product) {
                $productsids[] = $product->id;
            }
            $products = App\Product::with('glasses', 'aluminums', 'components')->wherein('id', $productsids)->get();

            $valorTotalDeProdutos = 0.0;
            foreach ($products as $product) {
                $resultVidro = 0.0;
                $m2 = $product['altura'] * $product['largura'] * $product['qtd'];
                $resultVidro += $m2 * $product->glasses()->sum('preco');

                $resultAluminio = 0.0;
                foreach ($product->aluminums()->get() as $aluminum) {
                    //LINHA ONDE O CALCULO ESTÁ SENDO FEITO DIFERENTE DO APP
                    $resultAluminio += $aluminum['peso'] * $aluminum['preco'] * $aluminum['qtd'];
                }

                $resultComponente = 0.0;
                foreach ($product->components()->get() as $component) {
                    $resultComponente += $component['preco'] * $component['qtd'];
                }

                $valorTotalDeProdutos += ($resultAluminio + $resultVidro + $resultComponente + $product['valor_mao_obra']);

            }

            $valorTotalDeProdutos *= (1 + $budgetcriado['margem_lucro'] / 100);

            $valorTotalDeProdutos = number_format($valorTotalDeProdutos, 2, '.', '');

            $budgetcriado->update(['total' => $valorTotalDeProdutos]);


        }

    }
}
