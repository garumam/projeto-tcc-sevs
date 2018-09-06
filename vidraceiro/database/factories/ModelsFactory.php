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
        'margem_lucro'=> $faker->randomFloat(2,0,1000),
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
    $budget = App\Budget::all()->toArray();
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
        'product_id' => $faker->unique()->numberBetween(4,33),
        'preco'=> $mglass[$position]['preco'],
        'mglass_id'=> $mglass[$position]['id'],
        'tipo'=> $mglass[$position]['tipo']
    ];
});

