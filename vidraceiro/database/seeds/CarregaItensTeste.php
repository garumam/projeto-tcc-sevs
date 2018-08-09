<?php

use App\Aluminum;
use App\Budget;
use App\Component;
use App\Glass;
use App\MProduct;
use App\Order;
use App\Product;
use App\Provider;
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
        Aluminum::create([
            'categoria_aluminio_id'=> 7,
            'descricao'=> 'capa',
            'is_modelo'=> 0,
            'medida'=> 0.866,
            'perfil'=> 'xt-201',
            'peso'=> 0.231,
            'preco'=> 22.0,
            'qtd'=> 1,
            'tipo_medida'=> 'largura'
        ]);

        Glass::create([
            'categoria_vidro_id'=> 9,
            'descricao'=> '',
            'espessura'=> 8,
            'is_modelo'=> 0,
            'nome'=> 'vidro incolor temperado',
            'preco'=> 100.0,
            'tipo'=> 'padrão'
        ]);

        Glass::create([
            'categoria_vidro_id'=> 9,
            'descricao'=> '',
            'espessura'=> 8,
            'is_modelo'=> 0,
            'nome'=> 'vidro fumê temperado',
            'preco'=> 140.0,
            'tipo'=> 'padrão'
        ]);

        Component::create([
            'imagem'=> '',
            'is_modelo'=> 0,
            'nome'=> 'roldana',
            'preco'=> 1.0,
            'qtd'=> 1,
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
            'uf'=> 'ba'
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
            'uf'=> 'mg'
        ]);

        MProduct::create([
            'categoria_produto_id'=> '1',
            'descricao'=> 'mproduto1',
            'imagem' => asset('img/boxdiversos/bxc1.png'),
            'nome'=> 'modelo produto1',
        ]);

        Product::create([
            'altura'=> 4.321,
            'largura'=> 1.234,
            'localizacao'=> '',
            'm_produto_id'=> 1,
            'qtd'=> 1,
            'valor_mao_obra'=> 0.0
        ]);

        Product::create([
            'altura'=> 0.544,
            'largura'=> 0.866,
            'localizacao'=> '',
            'm_produto_id'=> 3,
            'qtd'=> 2,
            'valor_mao_obra'=> 0.0
        ]);

        Product::create([
            'altura'=> 0.123,
            'largura'=> 0.321,
            'localizacao'=> '',
            'm_produto_id'=> 2,
            'qtd'=> 3,
            'valor_mao_obra'=> 0.0
        ]);

        $mproduct = MProduct::find(3);
        $mproduct->aluminums()->attach([1]);
        $mproduct->components()->attach([1]);
        $mproduct->glasses()->attach([1]);

        $product = Product::find(2);
        $product->aluminums()->attach([17]);
        $product->components()->attach([2]);
        $product->glasses()->attach([7]);

        $product = Product::find(3);
        $product->glasses()->attach([8]);


        Budget::create([
            'bairro'=> '',
            'cep'=> 0,
            'cidade'=> '',
            'complemento'=> '',
            'data'=> '08/08/2018',
            'margem_lucro'=> 100.0,
            'nome'=> 'orcamento1',
            'numero_endereco'=> 0,
            'rua'=> '',
            'telefone'=> '0',
            'total'=> 200.6056,
            'uf' => 'RJ'
        ]);

        Budget::create([
            'bairro'=> '',
            'cep'=> 0,
            'cidade'=> '',
            'complemento'=> '',
            'data'=> '08/08/2018',
            'margem_lucro'=> 100.0,
            'nome'=> 'orçamento2',
            'numero_endereco'=> 0,
            'rua'=> '',
            'telefone'=> '0',
            'total'=> 33.16572,
            'uf' => 'RJ'
        ]);

        $product = Product::find(1);
        $product->budgets()->attach([1]);

        $product = Product::find(2);
        $product->budgets()->attach([1]);

        $product = Product::find(3);
        $product->budgets()->attach([2]);

        Order::create([
            'data_final'=> '15/08/2018',
            'data_inicial'=> '08/08/2018',
            'nome'=> 'order1',
            'situacao' => 'aberta',
            'total'=> 233.7713
        ]);

        Order::create([
            'data_final'=> '09/08/2018',
            'data_inicial'=> '08/08/2018',
            'nome'=> 'order2',
            'situacao' => 'concluida',
            'total'=> 200.6056
        ]);

        $order = Order::find(1);
        $order->budgets()->attach([1,2]);

        $order = Order::find(2);
        $order->budgets()->attach([1]);

    }
}
