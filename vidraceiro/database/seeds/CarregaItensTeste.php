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
use App\Client;
use App\Sale;
use App\Installment;
use App\Payment;
use App\Financial;
use Illuminate\Database\Seeder;
use App\Location;
use App\Contact;

class CarregaItensTeste extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $endereco = Location::create([
            'bairro'=> 'Centro',
            'cep'=> 28907170,
            'cidade'=> 'Cabo frio',
            'complemento'=> 'Logo ali',
            'endereco'=> 'Fim do mundo, n° 250',
            'uf' => 'RJ'
        ]);

        $contato = Contact::create([
            'telefone'=> '2212344321',
            'celular'=> '22912344321',
            'email' => 'joao@gmail.com'
        ]);

        Client::create([
            'nome'=> 'João da Silva',
            'documento' => '24392022820',
            'status'=> 'EM DIA',
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);

        $endereco = Location::create([
            'bairro'=> 'Vila velha',
            'cep'=> 10459289,
            'cidade'=> 'Terezina',
            'complemento'=> 'Depois de la',
            'endereco'=> 'Goiaba, n° 130',
            'uf' => 'MG'
        ]);

        $contato = Contact::create([
            'telefone'=> '4565432456',
            'celular'=> '45925432456',
            'email' => 'maria@gmail.com'
        ]);

        Client::create([
            'nome'=> 'Maria Pereira',
            'documento' => '61846326397',
            'status'=> 'DEVENDO',
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);


        $endereco = Location::create([
            'bairro'=> 'Rio Comprido',
            'cep'=> 20261301,
            'cidade'=> 'Rio de janeiro',
            'complemento'=> '',
            'endereco'=> 'Rua Barbosa, n° 1200',
            'uf' => 'RJ'
        ]);

        $contato = Contact::create([
            'telefone'=> '2126457895',
            'celular'=> '21925432456',
            'email' => 'maria@gmail.com'
        ]);

        Client::create([
            'nome'=> 'Serra LTDA',
            'documento' => '83258342000133',
            'status'=> 'EM DIA',
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);


        Order::create([
            'data_final' => '2018-08-05',
            'data_inicial' => '2018-08-03',
            'nome'=> 'order1',
            'situacao' => 'ABERTA',
            'total'=> 812.77
        ]);

        Order::create([
            'data_final' => '2018-08-05',
            'data_inicial' => '2018-04-05',
            'nome'=> 'order2',
            'situacao' => 'ANDAMENTO',
            'total'=> 199.75
        ]);

        $endereco = Location::create([
            'bairro'=> 'Centro',
            'cep'=> 28907170,
            'cidade'=> 'Cabo frio',
            'complemento'=> 'Logo ali',
            'endereco'=> 'Fim do mundo, n° 250',
            'uf' => 'RJ'
        ]);

        $contato = Contact::create([
            'telefone'=> '2212344321'
        ]);

        Budget::create([
            'status'=> 'APROVADO',
            'data'=> '2019-05-29',
            'updated_at' => '2019-05-29',
            'margem_lucro'=> 100.0,
            'nome'=> 'orçamento de produto BX-A1 e manutenção de janela',
            'total'=> 812.77,
            'ordem_id'=> 1,
            'cliente_id' => 1,
            'usuario_id' => 1,
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);

        $endereco = Location::create([
            'bairro'=> 'Vila velha',
            'cep'=> 10459289,
            'cidade'=> 'Terezina',
            'complemento'=> 'Depois de la',
            'endereco'=> 'Goiaba, n° 130',
            'uf' => 'MG'
        ]);

        $contato = Contact::create([
            'telefone'=> '4565432456'
        ]);

        Budget::create([
            'status'=> 'APROVADO',
            'data'=> '2019-05-31',
            'updated_at' => '2019-05-31',
            'margem_lucro'=> 200.0,
            'nome'=> 'orçamento de produto BX-C1',
            'total'=> 199.75,
            'ordem_id'=> 2,
            'cliente_id' => 2,
            'usuario_id' => 3,
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);

        $endereco = Location::create([
            'bairro'=> 'Lugar nenhum',
            'cep'=> 12345678,
            'cidade'=> 'São Bento',
            'complemento'=> '',
            'endereco'=> 'Freeza, n° 80',
            'uf' => 'CE'
        ]);

        $contato = Contact::create([
            'telefone'=> '8533756283'
        ]);

        Budget::create([
            'status'=> 'AGUARDANDO',
            'data'=> '2018-08-08',
            'margem_lucro'=> 150.0,
            'nome'=> 'orçamento de manutenção em janela',
            'total'=> 500,
            'usuario_id' => 1,
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);

        $endereco = Location::create([
            'bairro'=> 'Rio Comprido',
            'cep'=> 20261301,
            'cidade'=> 'Rio de janeiro',
            'complemento'=> '',
            'endereco'=> 'Rua Barbosa, n° 1200',
            'uf' => 'RJ'
        ]);

        $contato = Contact::create([
            'telefone'=> '2126457895'
        ]);

        Budget::create([
            'status'=> 'AGUARDANDO',
            'data'=> '2019-02-08',
            'margem_lucro'=> 50.0,
            'nome'=> 'orçamento de porta padrão',
            'total'=> 0,
            'usuario_id' => 3,
            'cliente_id' => 3,
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);

        $mproduct = MProduct::create([
            'categoria_produto_id'=> '6',
            'descricao'=> 'janela de correr',
            'imagem' => '/img/ferragem1000/ferragem1029.png',
            'nome'=> 'Manutenção de janela',
        ]);

        Product::create([
            'altura'=> 0.0,
            'largura'=> 0.0,
            'm_produto_id'=> $mproduct->id,
            'budget_id'=> 3,
            'qtd'=> 1,
            'valor_mao_obra'=> 200
        ]);

        $mproduct = MProduct::create([
            'categoria_produto_id'=> '6',
            'descricao'=> 'Portão genérico',
            'imagem' => '/img/boxdiversos/bxf1.png',
            'nome'=> 'Portão padrão',
        ]);

        $mproduct->aluminums()->attach([49]);
        $mproduct->aluminums()->attach([50]);
        $mproduct->aluminums()->attach([55]);
        
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
            'maluminum_id'=> 1,
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
            'mglass_id'=> 1,
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
            'mglass_id'=> 3,
            'tipo'=> 'Padrão'
        ]);

        Component::create([
            'imagem'=> null,
            'is_modelo'=> 0,
            'nome'=> 'roldana',
            'preco'=> 1.0,
            'qtd'=> 1,
            'product_id' => 2,
            'mcomponent_id'=> 1,
            'categoria_componente_id' => 8
        ]);

        $endereco = Location::create([
            'bairro'=> 'bairro1',
            'cep'=> 12345678,
            'cidade'=> 'cidade1',
            'endereco'=> 'rua1, n° 23',
            'uf'=> 'BA'
        ]);

        $contato = Contact::create([
            'telefone'=> '1122334455',
            'celular'=> '91134567890',
            'email' => 'fornecedor1@fornecedor.com'
        ]);

        Provider::create([
            'cnpj'=> '78865212000129',
            'nome'=> 'fornecedor 1',
            'situacao'=> 'ativo',
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);

        $endereco = Location::create([
            'bairro'=> 'bairro2',
            'cep'=> 64364364,
            'cidade'=> 'cidade2',
            'endereco'=> 'rua2, n° 120',
            'uf'=> 'MG'
        ]);

        $contato = Contact::create([
            'telefone'=> '0998877665',
            'celular'=> '91232435465',
            'email' => 'fornecedor2@fornecedor.com'
        ]);

        Provider::create([
            'cnpj'=> '56476454000198',
            'nome'=> 'fornecedor2',
            'situacao'=> 'desativado',
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
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


        /*$order = Order::find(1);
        $order->budgets()->attach([1,2]);

        $order = Order::find(2);
        $order->budgets()->attach([2]);*/

        $endereco = Location::create([
            'bairro'=> 'centro',
            'cep'=> 52930120,
            'cidade'=> 'Cabo frio',
            'endereco'=> 'av. souza n°255',
            'uf'=> 'RJ'
        ]);

        $contato = Contact::create([
            'telefone'=> '2326776451',
            'email' => 'vidracaria@sv.com'
        ]);

        Company::create([
            'nome'=> 'Vidraçaria S&V',
            'endereco_id' => $endereco->id,
            'contato_id' => $contato->id
        ]);

        Sale::create([
            'tipo_pagamento'=> 'A VISTA',
            'data_venda'=> '2019-05-29',
            'valor_venda'=> 812.77,
            'orcamento_id'=> 1,
            'usuario_id' => 1
        ]);

        Sale::create([
            'tipo_pagamento'=> 'A PRAZO',
            'data_venda'=> '2019-05-31',
            'qtd_parcelas'=> 2,
            'valor_venda'=> 199.75,
            'orcamento_id'=> 2,
            'usuario_id' => 2
        ]);

        Installment::create([
            'data_vencimento'=> '2019-06-30',
            'status_parcela'=> 'PAGO',
            'valor_parcela'=> 99.87,
            'venda_id'=> 2
        ]);

        Installment::create([
            'data_vencimento'=> '2019-07-30',
            'status_parcela'=> 'ABERTO',
            'valor_parcela'=> 99.87,
            'venda_id'=> 2
        ]);

        $payment = Payment::create([
            'data_pagamento'=> '2019-05-29',
            'valor_pago'=> 812.77,
            'venda_id'=> 1
        ]);

        Financial::create([
            'tipo'=>'RECEITA',
            'descricao'=>'Pagamento de venda à vista.',
            'valor'=>$payment->valor_pago,
            'data_vencimento'=> $payment->data_pagamento,
            'status'=>'CONFIRMADO',
            'pagamento_id'=> $payment->id,
            'usuario_id'=> 1
        ]);

        $payment = Payment::create([
            'data_pagamento'=> '2019-06-30',
            'valor_pago'=> 99.87,
            'venda_id'=> 2
        ]);

        Financial::create([
            'tipo'=>'RECEITA',
            'descricao'=>'Parcelas pagas.',
            'valor'=>$payment->valor_pago,
            'data_vencimento'=> $payment->data_pagamento,
            'status'=>'CONFIRMADO',
            'pagamento_id'=> $payment->id,
            'usuario_id'=> 1
        ]);
    }
}
