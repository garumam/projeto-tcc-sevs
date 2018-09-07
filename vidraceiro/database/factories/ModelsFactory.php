<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'nome'=> $faker->name,
        'bairro'=> $faker->streetName,
        'cep'=>str_replace('-','',$faker->postcode),
        'cpf' => $faker->unique()->cpf(false),
        'cidade'=> $faker->city,
        'complemento'=> $faker->secondaryAddress,
        'endereco'=> $faker->address,
        'telefone'=> $faker->numerify('##########'),
        'celular'=> $faker->numerify('9##########'),
        'uf' => $faker->stateAbbr
    ];
});

$factory->define(App\MProduct::class, function (Faker $faker) {
    $categoria = $faker->numberBetween(1,5);
    $folder = null;
    switch($categoria){
        case 1:
            $folder = '/img/boxdiversos/';
            break;
        case 2:
            $folder = '/img/boxpadrao/';
            break;
        case 3:
            $folder = '/img/ferragem1000/';
            break;
        case 4:
            $folder = '/img/ferragem3000/';
            break;
        case 5:
            $folder = '/img/kitsacada/';
            break;
        default:
            $folder = '/img/boxdiversos/';
    }


    $filename = [];
    $files = File::files(public_path() . $folder);
    foreach ($files as $file) {
        $filename[] = pathinfo($file, PATHINFO_BASENAME);
    }

    $max = count($filename);
    $position = $faker->numberBetween(0,$max-1);

    return [
        'nome' => $faker->word,
        'descricao' => $faker->text(50),
        'imagem' => $folder.$filename[$position],
        'categoria_produto_id' => $categoria
    ];
});


$factory->define(App\Budget::class, function (Faker $faker) {
    $clients = App\Client::all()->toArray();

    $max = count($clients);
    $position = $faker->numberBetween(0,$max-1);
    return [
        'status'=> $faker->randomElement(['APROVADO','AGUARDANDO','FINALIZADO']),
        'bairro'=> $clients[$position]['bairro'],
        'cep'=>$clients[$position]['cep'],
        'cidade'=> $clients[$position]['cidade'],
        'complemento'=> $clients[$position]['complemento'],
        'data'=> $faker->date('Y-m-d', 'now'),
        'margem_lucro'=> $faker->randomFloat(2,0,100),
        'nome'=> 'orçamento '.$faker->word,
        'endereco'=> $clients[$position]['endereco'],
        'telefone'=> $clients[$position]['telefone'],
        'total'=> 0,
        'ordem_id'=> null,
        'uf' => $clients[$position]['uf'],
        'cliente_id' => $clients[$position]['id']
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    $mproduct = App\MProduct::all()->toArray();
    $budget = App\Budget::whereNotIn('id',[1,2,3])->get()->toArray();
    $max_budget = count($budget);
    $position_budget = $faker->numberBetween(0,$max_budget-1);
    $max_mproduct = count($mproduct);
    $position_mprod = $faker->numberBetween(0,$max_mproduct-1);
    return [
        'altura'=> $faker->randomFloat(3,0,10),
        'largura'=> $faker->randomFloat(3,0,10),
        'localizacao'=> $faker->randomElement(['Quarto','Banheiro','Sala','Varanda','Entrada da casa']),
        'm_produto_id'=> $mproduct[$position_mprod]['id'],
        'budget_id'=> $budget[$position_budget]['id'],
        'qtd'=> 1,
        'valor_mao_obra'=> $faker->randomFloat(2,0,1000)
    ];
});

$factory->define(App\Glass::class, function (Faker $faker) {
    $mglass = App\Glass::where('is_modelo',1)->get()->toArray();

    $max = count($mglass);
    $position = $faker->numberBetween(0,$max-1);

    return [
        'categoria_vidro_id'=> $mglass[$position]['categoria_vidro_id'],
        'cor'=> $mglass[$position]['cor'],
        'espessura'=> $mglass[$position]['espessura'],
        'is_modelo'=> 0,
        'nome'=> $mglass[$position]['nome'],
        'preco'=> $mglass[$position]['preco'],
        'mglass_id'=> $mglass[$position]['id'],
        'tipo'=> $mglass[$position]['tipo']
    ];
});

$factory->define(App\Aluminum::class, function (Faker $faker) {
    $maluminum = App\Aluminum::where('is_modelo',1)->get()->toArray();
    $produto = App\Product::whereNotIn('id',[1,2,3])->get()->toArray();

    $max_product = count($produto);
    $position_produto = $faker->numberBetween(0,$max_product-1);

    $max = count($maluminum);
    $position = $faker->numberBetween(0,$max-1);


    $aluminioMedida = $maluminum[$position]['tipo_medida'] === 'largura'? $produto[$position_produto]['largura'] :
        ($maluminum[$position]['tipo_medida'] === 'altura'?$produto[$position_produto]['altura'] : $maluminum[$position]['medida']);
    $aluminioPeso = ($maluminum[$position]['peso']/$maluminum[$position]['medida'])*$aluminioMedida;
    $aluminioPeso = number_format($aluminioPeso, 3, '.','');


    return [
        'categoria_aluminio_id'=> $maluminum[$position]['categoria_aluminio_id'],
        'descricao'=> $maluminum[$position]['descricao'],
        'is_modelo'=> 0,
        'medida'=> $aluminioMedida,
        'perfil'=> $maluminum[$position]['perfil'],
        'peso'=> $aluminioPeso,
        'preco'=> $maluminum[$position]['preco'],
        'qtd'=> $maluminum[$position]['qtd'],
        'product_id' => $produto[$position_produto]['id'],
        'maluminum_id'=> $maluminum[$position]['id'],
        'tipo_medida'=> $maluminum[$position]['tipo_medida'],
    ];
});

$factory->define(App\Component::class, function (Faker $faker) {
    $mcomponent = App\Component::where('is_modelo',1)->get()->toArray();
    $produto = App\Product::whereNotIn('id',[1,2,3])->get()->toArray();

    $max_product = count($produto);
    $position_produto = $faker->numberBetween(0,$max_product-1);

    $max = count($mcomponent);
    $position = $faker->numberBetween(0,$max-1);

    return [
        'is_modelo'=> 0,
        'nome'=> $mcomponent[$position]['nome'],
        'preco'=> $mcomponent[$position]['preco'],
        'qtd'=> $mcomponent[$position]['qtd'],
        'product_id' => $produto[$position_produto]['id'],
        'mcomponent_id'=> $mcomponent[$position]['id'],
        'categoria_componente_id' => $mcomponent[$position]['categoria_componente_id']
    ];
});


$factory->define(App\Sale::class, function (Faker $faker) {

    $tipo_pagamento = $faker->randomElement(['A PRAZO','A VISTA']);
    $qtd_parcelas = null;

    if($tipo_pagamento === 'A PRAZO'){
        $qtd_parcelas = $faker->numberBetween(2,12);
    }


    return [
        'tipo_pagamento'=> $tipo_pagamento,
        'data_venda'=> $faker->date('Y-m-d', 'now'),
        'qtd_parcelas'=> $qtd_parcelas
    ];
});

