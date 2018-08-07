<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\MProduct;
use App\Glass;
use App\Aluminum;
use App\Component;
use App\User;

class CarregaItens extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $userAdmin = new User;
        $userAdmin->name = 'admin';
        $userAdmin->email = 'admin@admin.com';
        $userAdmin->setPasswordAttribute('admin');
        $userAdmin->save();

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

        Glass::create([
            'nome' => 'Vidro Incolor Temperado',
            'descricao' => '',
            'tipo' => 'Padrão',
            'espessura' => 8,
            'preco' => 100.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 9

        ]);

        Glass::create([
            'nome' => 'Vidro Verde Temperado',
            'descricao' => '',
            'tipo' => 'Padrão',
            'espessura' => 8,
            'preco' => 110.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 9

        ]);

        Glass::create([
            'nome' => 'Vidro Fumê Temperado',
            'descricao' => '',
            'tipo' => 'Padrão',
            'espessura' => 8,
            'preco' => 140.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 9

        ]);

        Glass::create([
            'nome' => 'Vidro Incolor Temperado',
            'descricao' => '',
            'tipo' => 'Engenharia',
            'espessura' => 8,
            'preco' => 110.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 9

        ]);

        Glass::create([
            'nome' => 'Vidro Verde Temperado',
            'descricao' => '',
            'tipo' => 'Engenharia',
            'espessura' => 8,
            'preco' => 130.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 9

        ]);

        Glass::create([
            'nome' => 'Vidro Fumê Temperado',
            'descricao' => '',
            'tipo' => 'Engenharia',
            'espessura' => 8,
            'preco' => 180.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 9

        ]);

        Aluminum::create([
            'perfil' => 'XT-201',
            'descricao' => 'Capa',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 1.600,
            'preco' => 22.0,
            'tipo_medida' => 0,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'XT-202',
            'descricao' => 'Superior',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 4.200,
            'preco' => 22.0,
            'tipo_medida' => 0,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
        'perfil' => 'TBX-701',
        'descricao' => 'Inferior',
        'medida' => 6.000,
        'qtd' => 1,
        'peso' => 2.000,
        'preco' => 22.0,
        'tipo_medida' => 0,
        'is_modelo' => 1,
        'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-680',
            'descricao' => 'Tampa canal',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 0.300,
            'preco' => 22.0,
            'tipo_medida' => 0,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-611',
            'descricao' => 'Cadeirinha',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 0.900,
            'preco' => 22.0,
            'tipo_medida' => 1,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-653',
            'descricao' => 'Cavalinho',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 1.000,
            'preco' => 22.0,
            'tipo_medida' => 1,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-657',
            'descricao' => 'Cavalão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 0.800,
            'preco' => 22.0,
            'tipo_medida' => 1,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-682',
            'descricao' => 'Veda poeira',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 0.700,
            'preco' => 22.0,
            'tipo_medida' => 1,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'SU-007',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 2.200,
            'preco' => 22.0,
            'tipo_medida' => 1,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'VZ-88',
            'descricao' => 'Veneziana',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 1.800,
            'preco' => 22.0,
            'tipo_medida' => 0,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'R-1 Reto',
            'descricao' => 'Reto',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 4.700,
            'preco' => 22.0,
            'tipo_medida' => 0,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'VZ-201',
            'descricao' => 'Veneziana',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 1.800,
            'preco' => 22.0,
            'tipo_medida' => 0,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'LB-050',
            'descricao' => 'LB-050',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 3.700,
            'preco' => 22.0,
            'tipo_medida' => 0,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'LB-502',
            'descricao' => 'LB-502',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 5.000,
            'preco' => 22.0,
            'tipo_medida' => 0,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'TPC-010',
            'descricao' => 'TPC',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 6.300,
            'preco' => 22.0,
            'tipo_medida' => 2,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'LB-038',
            'descricao' => 'LB-038',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 6.000,
            'preco' => 22.0,
            'tipo_medida' => 1,
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Component::create([
            'nome' => 'Roldana',
            'qtd' => 1,
            'preco' => 1.0,
            'imagem' => 1,
            'is_modelo' => 1,
            'categoria_componente_id' => 8
        ]);


    }
}
