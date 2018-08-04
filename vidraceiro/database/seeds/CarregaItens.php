<?php

use Illuminate\Database\Seeder;
use App;

class CarregaItens extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::create([
            'nome' => 'Box Diversos',
            'tipo' => 0,
            'grupo_imagem' => 1
        ]);

        Category::create([
            'nome' => 'Box Padrão',
            'tipo' => 0,
            'grupo_imagem' => 2
        ]);

        Category::create([
            'nome' => 'Ferragem 1000',
            'tipo' => 0,
            'grupo_imagem' => 3
        ]);

        Category::create([
            'nome' => 'Ferragem 3000',
            'tipo' => 0,
            'grupo_imagem' => 4
        ]);

        Category::create([
            'nome' => 'Kit Sacada',
            'tipo' => 0,
            'grupo_imagem' => 5
        ]);

        Category::create([
            'nome' => 'Todas as imagens',
            'tipo' => 0,
            'grupo_imagem' => 6
        ]);

        Category::create([
            'nome' => 'Janelas',
            'tipo' => 1,
            'grupo_imagem' => 7
        ]);

        Category::create([
            'nome' => 'Portões',
            'tipo' => 1,
            'grupo_imagem' => 8
        ]);

        Category::create([
            'nome' => 'Linha Temperado',
            'tipo' => 2,
            'grupo_imagem' => 9
        ]);

        Category::create([
            'nome' => 'Linha Suprema',
            'tipo' => 2,
            'grupo_imagem' => 10
        ]);

        MProduct::create([
            'nome' => 'BX-A1',
            'descricao' => 'Box de abrir com dobradiça automática, em vidro temperado 08mm',
            'imagem' => asset('img/boxdiversos/bxa1.png'),
            'categoria_produto_id' => 1
        ]);

        MProduct::create([
            'nome' => 'BX-C1',
            'descricao' => 'Box de canto com duas portas de correr e dois fixos, em vidro temperado 08mm',
            'imagem' => asset('img/boxdiversos/bxc1.png'),
            'categoria_produto_id' => 1
        ]);

    }
}
