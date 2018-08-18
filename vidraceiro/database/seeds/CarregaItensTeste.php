<?php

use App\Aluminum;
use App\Budget;
use App\Component;
use App\Glass;
use App\MProduct;
use App\Order;
use App\Product;
use App\Provider;
use App\Company;
use Illuminate\Database\Seeder;

class CarregaItensTeste extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        MProduct::create([
            'categoria_produto_id'=> '1',
            'descricao'=> 'mproduto1',
            'imagem' => '/img/boxdiversos/bxc1.png',
            'nome'=> 'modelo produto1',
        ]);

        Budget::create([
            'bairro'=> 'Centro',
            'cep'=> 28907170,
            'cidade'=> 'Cabo frio',
            'complemento'=> 'Logo ali',
            'data'=> '2018-08-07',
            'margem_lucro'=> 100.0,
            'nome'=> 'orcamento1',
            'numero_endereco'=> 250,
            'rua'=> 'Fim do mundo',
            'telefone'=> '2212344321',
            'total'=> 800.04,
            'uf' => 'RJ'
        ]);

        Budget::create([
            'bairro'=> 'Vila velha',
            'cep'=> 10459289,
            'cidade'=> 'Terezina',
            'complemento'=> 'Depois de la',
            'data'=> '2018-08-08',
            'margem_lucro'=> 200.0,
            'nome'=> 'orçamento2',
            'numero_endereco'=> 125,
            'rua'=> 'Goiaba',
            'telefone'=> '4565432456',
            'total'=> 198.38,
            'uf' => 'RJ'
        ]);

        Product::create([
            'altura'=> 4.321,
            'largura'=> 1.234,
            'localizacao'=> 'Quarto',
            'm_produto_id'=> 1,
            'budget_id'=> 1,
            'qtd'=> 1,
            'valor_mao_obra'=> 100
        ]);

        Product::create([
            'altura'=> 0.544,
            'largura'=> 0.866,
            'localizacao'=> 'Banheiro',
            'm_produto_id'=> 3,
            'budget_id'=> 1,
            'qtd'=> 2,
            'valor_mao_obra'=> 200
        ]);

        Product::create([
            'altura'=> 0.123,
            'largura'=> 0.321,
            'localizacao'=> 'Sala',
            'm_produto_id'=> 2,
            'budget_id'=> 2,
            'qtd'=> 3,
            'valor_mao_obra'=> 50
        ]);

        $mproduct = MProduct::find(3);
        $mproduct->aluminums()->attach([1]);
        $mproduct->components()->attach([1]);
        $mproduct->glasses()->attach([1]);


        Aluminum::create([
            'categoria_aluminio_id'=> 7,
            'descricao'=> 'capa',
            'is_modelo'=> 0,
            'medida'=> 0.866,
            'perfil'=> 'xt-201',
            'peso'=> 0.231,
            'preco'=> 22.0,
            'qtd'=> 1,
            'product_id' => 2,
            'tipo_medida'=> 'largura'
        ]);

        Glass::create([
            'categoria_vidro_id'=> 9,
            'cor'=> 'Incolor',
            'espessura'=> 8,
            'is_modelo'=> 0,
            'nome'=> 'Vidro Incolor Temperado',
            'product_id' => 2,
            'preco'=> 100.0,
            'tipo'=> 'Padrão'
        ]);

        Glass::create([
            'categoria_vidro_id'=> 9,
            'cor'=> 'Fumê',
            'espessura'=> 8,
            'is_modelo'=> 0,
            'nome'=> 'Vidro Fumê Temperado',
            'product_id' => 3,
            'preco'=> 140.0,
            'tipo'=> 'Padrão'
        ]);

        Component::create([
            'imagem'=> '',
            'is_modelo'=> 0,
            'nome'=> 'roldana',
            'preco'=> 1.0,
            'qtd'=> 1,
            'product_id' => 2,
            'categoria_componente_id' => 8
        ]);

        Provider::create([
            'bairro'=> 'bairro1',
            'celular'=> '1134567890',
            'cep'=> 12345678,
            'cidade'=> 'cidade1',
            'cnpj'=> '21312412412',
            'email'=> 'fornecedor1@fornecedor.com',
            'nome'=> 'fornecedor 1',
            'numero_endereco'=> 23,
            'rua'=> 'rua1',
            'situacao'=> 'ativo',
            'telefone'=> '1122334455',
            'uf'=> 'BA'
        ]);

        Provider::create([
            'bairro'=> 'bairro2',
            'celular'=> '1232435465',
            'cep'=> 64364364,
            'cidade'=> 'cidade2',
            'cnpj'=> '12325674747',
            'email'=> 'fornecedor2@fornecedor.com',
            'nome'=> 'fornecedor2',
            'numero_endereco'=> 74,
            'rua'=> 'rua2',
            'situacao'=> 'desativado',
            'telefone'=> '0998877665',
            'uf'=> 'MG'
        ]);


        /*$product = Product::find(2);
        $product->aluminums()->attach([17]);
        $product->components()->attach([2]);
        $product->glasses()->attach([7]);

        $product = Product::find(3);
        $product->glasses()->attach([8]);*/

        /*
        $product = Product::find(1);
        $product->budgets()->attach([1]);

        $product = Product::find(2);
        $product->budgets()->attach([1]);

        $product = Product::find(3);
        $product->budgets()->attach([2]);
        */
        Order::create([
            'data_final' => '2018-08-05',
            'data_inicial' => '2018-08-03',
            'nome'=> 'order1',
            'situacao' => 'aberta',
            'total'=> 233.78
        ]);

        Order::create([
            'data_final' => '2018-08-05',
            'data_inicial' => '2018-04-05',
            'nome'=> 'order2',
            'situacao' => 'concluida',
            'total'=> 200.60
        ]);

        $order = Order::find(1);
        $order->budgets()->attach([1,2]);

        $order = Order::find(2);
        $order->budgets()->attach([1]);

        Company::create([
            'bairro'=> 'centro',
            'cidade'=> 'Cabo frio',
            'email'=> 'vidracaria@sv.com',
            'nome'=> 'Vidraçaria S&V',
            'endereco'=> 'av. souza n°255',
            'telefone'=> '26776451',
            'uf'=> 'RJ'
        ]);

    }
}
