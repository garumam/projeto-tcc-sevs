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
            'tipo' => 'produto',
            'grupo_imagem' => 'boxdiversos'
        ]);

        Category::create([
            'nome' => 'Box Padrão',
            'tipo' => 'produto',
            'grupo_imagem' => 'boxpadrao'
        ]);

        Category::create([
            'nome' => 'Ferragem 1000',
            'tipo' => 'produto',
            'grupo_imagem' => 'ferragem1000'
        ]);

        Category::create([
            'nome' => 'Ferragem 3000',
            'tipo' => 'produto',
            'grupo_imagem' => 'ferragem3000'
        ]);

        Category::create([
            'nome' => 'Kit Sacada',
            'tipo' => 'produto',
            'grupo_imagem' => 'kitsacada'
        ]);

        Category::create([
            'nome' => 'Todas as imagens',
            'tipo' => 'produto',
            'grupo_imagem' => 'todasimagens'
        ]);

        Category::create([
            'nome' => 'Linha Temperado',
            'tipo' => 'aluminio',
            'grupo_imagem' => 'todasimagens'
        ]);

        Category::create([
            'nome' => 'Linha Suprema',
            'tipo' => 'aluminio',
            'grupo_imagem' => 'todasimagens'
        ]);

        Category::create([
            'nome' => 'Porta & Portão',
            'tipo' => 'aluminio',
            'grupo_imagem' => 'todasimagens'
        ]);

        Category::create([
            'nome' => 'Linha Gold',
            'tipo' => 'aluminio',
            'grupo_imagem' => 'todasimagens'
        ]);

        Category::create([
            'nome' => 'Linha Temperado',
            'tipo' => 'vidro',
            'grupo_imagem' => 'todasimagens'
        ]);

        Category::create([
            'nome' => 'Linha Suprema',
            'tipo' => 'vidro',
            'grupo_imagem' => 'todasimagens'
        ]);

        MProduct::create([
            'nome' => 'BX-A1',
            'descricao' => 'Box de abrir com dobradiça automática, em vidro temperado 08mm',
            'imagem' => '/img/boxdiversos/bxa1.png',
            'categoria_produto_id' => 1
        ]);

        MProduct::create([
            'nome' => 'BX-C1',
            'descricao' => 'Box de canto com duas portas de correr e dois fixos, em vidro temperado 08mm',
            'imagem' => '/img/boxdiversos/bxc1.png',
            'categoria_produto_id' => 1
        ]);

        Glass::create([
            'nome' => 'Vidro Incolor Temperado',
            'cor' => 'Incolor',
            'tipo' => 'Padrão',
            'espessura' => 8,
            'preco' => 100.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 11

        ]);

        Glass::create([
            'nome' => 'Vidro Verde Temperado',
            'cor' => 'Verde',
            'tipo' => 'Padrão',
            'espessura' => 8,
            'preco' => 110.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 11

        ]);

        Glass::create([
            'nome' => 'Vidro Fumê Temperado',
            'cor' => 'Fumê',
            'tipo' => 'Padrão',
            'espessura' => 8,
            'preco' => 140.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 11

        ]);

        Glass::create([
            'nome' => 'Vidro Incolor Temperado',
            'cor' => 'Incolor',
            'tipo' => 'Engenharia',
            'espessura' => 8,
            'preco' => 110.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 11

        ]);

        Glass::create([
            'nome' => 'Vidro Verde Temperado',
            'cor' => 'Verde',
            'tipo' => 'Engenharia',
            'espessura' => 8,
            'preco' => 130.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 11

        ]);

        Glass::create([
            'nome' => 'Vidro Fumê Temperado',
            'cor' => 'Fumê',
            'tipo' => 'Engenharia',
            'espessura' => 8,
            'preco' => 180.00,
            'is_modelo' => 1,
            'categoria_vidro_id' => 11

        ]);

        Aluminum::create([
            'perfil' => 'XT-201',
            'descricao' => 'Capa',
            'medida' => 6.000,
            'espessura' => 8,
            'qtd' => 1,
            'peso' => 1.600,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'XT-202',
            'descricao' => 'Superior',
            'medida' => 6.000,
            'espessura' => 8,
            'qtd' => 1,
            'peso' => 4.200,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-701',
            'descricao' => 'Inferior',
            'medida' => 6.000,
            'espessura' => 8,
            'qtd' => 1,
            'peso' => 2.000,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-680',
            'descricao' => 'Tampa canal',
            'medida' => 6.000,
            'espessura' => 8,
            'qtd' => 1,
            'peso' => 0.300,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-611',
            'descricao' => 'Cadeirinha',
            'medida' => 6.000,
            'espessura' => 8,
            'qtd' => 1,
            'peso' => 0.900,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-653',
            'descricao' => 'Cavalinho',
            'medida' => 6.000,
            'espessura' => 8,
            'qtd' => 1,
            'peso' => 1.000,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-657',
            'descricao' => 'Cavalão',
            'medida' => 6.000,
            'espessura' => 8,
            'qtd' => 1,
            'peso' => 0.800,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-682',
            'descricao' => 'Veda poeira',
            'medida' => 6.000,
            'espessura' => 8,
            'qtd' => 1,
            'peso' => 0.700,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-229',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 4.800,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-184',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 1.500,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-206',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 2.900,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-688',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 0.500,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-209',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 1.800,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-685',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 1.000,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'U Cavalão',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 1.500,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-553',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 1.000,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'CR-270',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 8.500,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-647',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 3.300,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'TBX-646',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 1.900,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'CG-511',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 2.800,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => '29-022',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 1.000,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => '39-077',
            'descricao' => 'Linha Temperado',
            'medida' => 6.000,
            'espessura' => 10,
            'qtd' => 1,
            'peso' => 2.400,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 7

        ]);

        Aluminum::create([
            'perfil' => 'SU-001',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 4.300,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-002',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 4.000,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-003',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.800,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-004',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.800,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-007',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.200,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-008',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 1.700,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-017',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 1.400,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-039',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.900,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-040',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.600,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-041',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.900,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-047',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 6.200,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-049',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 6.300,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-053',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.600,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-079',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.000,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-080',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.200,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-081',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.200,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-082',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.300,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-083',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 0.900,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-086',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 3.600,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-200',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.600,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-225',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 5.800,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-227',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 3.400,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-272',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 2.600,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-102',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 0.800,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-103',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 1.000,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 8

        ]);

        Aluminum::create([
            'perfil' => 'SU-192',
            'descricao' => 'Linha Suprema',
            'medida' => 6.000,
            'espessura' => 25,
            'qtd' => 1,
            'peso' => 3.300,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);

        Aluminum::create([
            'perfil' => 'VZ-88',
            'descricao' => 'Porta & Portão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 1.800,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);

        Aluminum::create([
            'perfil' => 'R-1 Côncavo',
            'descricao' => 'Porta & Portão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 3.100,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);

        Aluminum::create([
            'perfil' => 'R-1 Reto',
            'descricao' => 'Porta & Portão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 4.700,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);


        Aluminum::create([
            'perfil' => 'VZ-201',
            'descricao' => 'Porta & Portão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 1.800,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);

        Aluminum::create([
            'perfil' => 'LB-050',
            'descricao' => 'Porta & Portão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 3.700,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);

        Aluminum::create([
            'perfil' => 'LB-502',
            'descricao' => 'Porta & Portão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 5.000,
            'preco' => 22.0,
            'tipo_medida' => 'largura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);

        Aluminum::create([
            'perfil' => 'TPC-010',
            'descricao' => 'Porta & Portão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 6.300,
            'preco' => 22.0,
            'tipo_medida' => 'mlinear',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);

        Aluminum::create([
            'perfil' => 'LB-038',
            'descricao' => 'Porta & Portão',
            'medida' => 6.000,
            'qtd' => 1,
            'peso' => 6.000,
            'preco' => 22.0,
            'tipo_medida' => 'altura',
            'is_modelo' => 1,
            'categoria_aluminio_id' => 9

        ]);

        Component::create([
            'nome' => 'Roldana',
            'qtd' => 1,
            'preco' => 1.0,
            'imagem' => '',
            'is_modelo' => 1,
            'categoria_componente_id' => 8
        ]);


    }
}
