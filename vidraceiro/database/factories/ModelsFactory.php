<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    $email = $faker->unique()->word . '@email.com';
    return [
        'telefone' => $faker->numerify('##########'),
        'celular' => $faker->numerify('##9########'),
        'email' => $email
    ];
});

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'bairro' => $faker->streetName,
        'cep' => str_replace('-', '', $faker->postcode),
        'cidade' => $faker->city,
        'complemento' => $faker->secondaryAddress,
        'endereco' => $faker->address,
        'uf' => $faker->stateAbbr
    ];
});

$factory->define(App\Client::class, function (Faker $faker) {
    $doc = $faker->numberBetween(1, 2);
    if($doc == 1){
        $doc = $faker->unique()->cpf(false);
    }else{
        $doc = $faker->unique()->cnpj(false);
    }
    return [
        'nome' => $faker->name,
        'documento' => $doc,
        'status' => 'EM DIA',
        'endereco_id' => function(){
            return factory(App\Location::class)->create()->id;
        },
        'contato_id' => function(){
            return factory(App\Contact::class)->create()->id;
        }
    ];
});

$factory->define(App\Provider::class, function (Faker $faker) {
    return [
        'cnpj' => $faker->unique()->cnpj(false),
        'nome' => $faker->text(25),
        'situacao' => 'ativo',
        'endereco_id' => function(){
            return factory(App\Location::class)->create()->id;
        },
        'contato_id' => function(){
            return factory(App\Contact::class)->create()->id;
        }
    ];
});

$factory->define(App\MProduct::class, function (Faker $faker) {
    $categoria = $faker->numberBetween(1, 5);
    $folder = null;
    switch ($categoria) {
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
    $position = $faker->numberBetween(0, $max - 1);

    return [
        'nome' => $faker->word,
        'descricao' => $faker->text(50),
        'imagem' => $folder . $filename[$position],
        'categoria_produto_id' => $categoria
    ];
});


$factory->define(App\Budget::class, function (Faker $faker) {
    $clients = App\Client::whereNotIn('id', [1, 2])->get();

    $max = count($clients->toArray());
    $position = $faker->numberBetween(0, $max - 1);
    $endereco = $clients[$position]->location()->first();
    $contato = $clients[$position]->contact()->first();

    $status = $faker->randomElement(['APROVADO', 'AGUARDANDO', 'FINALIZADO']);

    $dt = $faker->dateTimeBetween('-1 years', 'now');
    $data = $dt->format("Y-m-d");

    return [
        'status' => $status,
        'data' => $data,
        'margem_lucro' => $faker->randomFloat(2, 0, 100),
        'nome' => 'orçamento ' . $faker->word,
        'total' => 0,
        'ordem_id' => null,
        'endereco_id' => function() use ($endereco){
            return App\Location::create([
                'bairro' => $endereco['bairro'],
                'cep' => $endereco['cep'],
                'cidade' => $endereco['cidade'],
                'complemento' => $endereco['complemento'],
                'endereco' => $endereco['endereco'],
                'uf' => $endereco['uf']
            ])->id;
        },
        'contato_id' => function() use ($contato){
            return App\Contact::create([
                'telefone' => $contato['telefone']
            ])->id;
        },
        'cliente_id' => $clients[$position]['id'],
        'usuario_id' => $faker->numberBetween(1, 2)
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    $mproduct = App\MProduct::all()->toArray();
    $budget = App\Budget::whereNotIn('id', [1, 2, 3, 4])->get()->toArray();
    $max_budget = count($budget);
    $position_budget = $faker->numberBetween(0, $max_budget - 1);
    $max_mproduct = count($mproduct);
    $position_mprod = $faker->numberBetween(0, $max_mproduct - 1);
    return [
        'altura' => $faker->randomFloat(3, 0, 4),
        'largura' => $faker->randomFloat(3, 0, 4),
        'localizacao' => $faker->randomElement(['Quarto', 'Banheiro', 'Sala', 'Varanda', 'Entrada da casa']),
        'm_produto_id' => $mproduct[$position_mprod]['id'],
        'budget_id' => $budget[$position_budget]['id'],
        'qtd' => $faker->numberBetween(1, 3),
        'valor_mao_obra' => $faker->randomFloat(2, 0, 1000)
    ];
});

$factory->define(App\Glass::class, function (Faker $faker) {
    $mglass = App\Glass::where('is_modelo', 1)->get()->toArray();

    $max = count($mglass);
    $position = $faker->numberBetween(0, $max - 1);

    return [
        'categoria_vidro_id' => $mglass[$position]['categoria_vidro_id'],
        'cor' => $mglass[$position]['cor'],
        'espessura' => $mglass[$position]['espessura'],
        'is_modelo' => 0,
        'nome' => $mglass[$position]['nome'],
        'preco' => $mglass[$position]['preco'],
        'mglass_id' => $mglass[$position]['id'],
        'tipo' => $mglass[$position]['tipo']
    ];
});

$factory->define(App\Aluminum::class, function (Faker $faker) {
    $maluminum = App\Aluminum::where('is_modelo', 1)->get()->toArray();
    $produto = App\Product::whereNotIn('id', [1, 2, 3])->get()->toArray();

    $max_product = count($produto);
    $position_produto = $faker->numberBetween(0, $max_product - 1);

    $max = count($maluminum);
    $position = $faker->numberBetween(0, $max - 1);


    $aluminioMedida = $maluminum[$position]['tipo_medida'] === 'largura' ? $produto[$position_produto]['largura'] :
        ($maluminum[$position]['tipo_medida'] === 'altura' ? $produto[$position_produto]['altura'] : $maluminum[$position]['medida']);
    $aluminioPeso = ($maluminum[$position]['peso'] / $maluminum[$position]['medida']) * $aluminioMedida;
    $aluminioPeso = number_format($aluminioPeso, 3, '.', '');


    return [
        'categoria_aluminio_id' => $maluminum[$position]['categoria_aluminio_id'],
        'descricao' => $maluminum[$position]['descricao'],
        'is_modelo' => 0,
        'medida' => $aluminioMedida,
        'perfil' => $maluminum[$position]['perfil'],
        'peso' => $aluminioPeso,
        'preco' => $maluminum[$position]['preco'],
        'qtd' => $maluminum[$position]['qtd'],
        'product_id' => $produto[$position_produto]['id'],
        'maluminum_id' => $maluminum[$position]['id'],
        'tipo_medida' => $maluminum[$position]['tipo_medida'],
    ];
});

$factory->define(App\Component::class, function (Faker $faker) {
    $mcomponent = App\Component::where('is_modelo', 1)->get()->toArray();
    $produto = App\Product::whereNotIn('id', [1, 2, 3])->get()->toArray();

    $max_product = count($produto);
    $position_produto = $faker->numberBetween(0, $max_product - 1);

    $max = count($mcomponent);
    $position = $faker->numberBetween(0, $max - 1);

    return [
        'is_modelo' => 0,
        'nome' => $mcomponent[$position]['nome'],
        'preco' => $mcomponent[$position]['preco'],
        'qtd' => $mcomponent[$position]['qtd'],
        'product_id' => $produto[$position_produto]['id'],
        'mcomponent_id' => $mcomponent[$position]['id'],
        'categoria_componente_id' => $mcomponent[$position]['categoria_componente_id']
    ];
});


$factory->define(App\Sale::class, function (Faker $faker) {

    $tipo_pagamento = $faker->randomElement(['A PRAZO', 'A VISTA']);
    $qtd_parcelas = null;

    if ($tipo_pagamento === 'A PRAZO') {
        $qtd_parcelas = $faker->numberBetween(1, 12);
    }

    return [
        'tipo_pagamento' => $tipo_pagamento,
        'qtd_parcelas' => $qtd_parcelas,
        'usuario_id'=>$faker->numberBetween(1, 2)
    ];
});


$factory->define(App\Order::class, function (Faker $faker) {
    $situacao = $faker->randomElement(['ABERTA', 'ANDAMENTO']);

    $dt = $faker->dateTimeBetween('-1 years', 'now');
    $data = $dt->format("Y-m-d");

    return [
        'nome' => 'order ' . $faker->word,
        'situacao' => $situacao,
        'data_final' => $data,
        'data_inicial' => $data,
        'total' => $faker->randomFloat(2, 500, 10000),
        'updated_at' => date('Y-m-d', strtotime($data))
    ];
});

$factory->define(App\Financial::class, function (Faker $faker) {
    $tipo = $faker->randomElement(['RECEITA', 'DESPESA']);
    $status = $faker->randomElement(['CONFIRMADO', 'PENDENTE']);

    $dt = $faker->dateTimeBetween('-1 years', '+1 years');
    $dataVencimento = $dt->format("Y-m-d");

    return [
        'tipo' => $tipo,
        'status' => $status,
        'descricao' => $faker->text(100),
        'valor' => $faker->randomFloat(2, 500, 13000),
        'usuario_id' => $faker->numberBetween(1, 2),
        'data_vencimento' => $dataVencimento
    ];

});


