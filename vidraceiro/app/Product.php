<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'largura',
        'altura',
        'qtd',
        'localizacao',
        'valor_mao_obra',
        'm_produto_id',
        'budget_id'
    ];

    public function mproduct(){
        return $this->belongsTo(MProduct::class, 'm_produto_id')->withTrashed();
    }

    public function glasses(){
        return $this->hasMany(
            Glass::class,
            'product_id'
        );
    }
    public function aluminums(){
        return $this->hasMany(
            Aluminum::class,
            'product_id'
        );
    }
    public function components(){
        return $this->hasMany(
            Component::class,
            'product_id'
        );
    }

    public function budget(){
        return $this->belongsTo(
            Budget::class,
            'budget_id'
        );
    }

    public function createProduct(array $input){

        return self::create($input);

    }

    public function updateProduct(array $input){

        return self::update($input);

    }

    public function deleteProduct(){

        return self::delete();

    }

    public function findProductById($id){

        return self::find($id);

    }

    public static function findProductsWithRelations(array $ids){

        return self::with('budget','glasses', 'aluminums', 'components')->wherein('id', $ids)->get();

    }


    public function updateAluminunsWithProductMeasure(){
        foreach ($this->aluminums()->get() as $aluminio) {
            //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO

            $aluminioModelo = $aluminio->findAluminumById($aluminio->maluminum_id);
            $aluminioMedida = $aluminioPeso = 0;
            $aluminio->calcularMedidaPesoAluminio($aluminioMedida,$aluminioPeso,$aluminioModelo,$this);

            $aluminio->updateAluminum([
                'medida' => $aluminioMedida,
                'peso' => $aluminioPeso
            ]);
        }
    }


    public function createMaterialsOfMProductToProduct(){

        $mproduct = MProduct::findMProductWithRelationsById($this->m_produto_id);

        foreach ($mproduct->glasses as $vidro) {

            $vidro->createGlass([
                'nome' => $vidro->nome,
                'cor' => $vidro->cor,
                'tipo' => $vidro->tipo,
                'espessura' => $vidro->espessura,
                'preco' => $vidro->preco,
                'product_id' => $this->id,
                'categoria_vidro_id' => $vidro->categoria_vidro_id,
                'is_modelo' => 0,
                'mglass_id' => $vidro->id
            ]);

        }

        foreach ($mproduct->aluminums as $aluminio) {
            //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO
            $aluminioMedida = $aluminioPeso = 0;

            $aluminio->calcularMedidaPesoAluminio($aluminioMedida,$aluminioPeso,$aluminio,$this);

            $aluminio->createAluminum([
                'perfil' => $aluminio->perfil,
                'descricao' => $aluminio->descricao,
                'medida' => $aluminioMedida,
                'qtd' => $aluminio->qtd,
                'peso' => $aluminioPeso,
                'preco' => $aluminio->preco,
                'tipo_medida' => $aluminio->tipo_medida,
                'is_modelo' => 0,
                'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,
                'product_id' => $this->id,
                'maluminum_id' => $aluminio->id

            ]);

        }

        foreach ($mproduct->components as $componente) {
            $componente->createComponent([
                'nome' => $componente->nome,
                'qtd' => $componente->qtd,
                'preco' => $componente->preco,
                'is_modelo' => 0,
                'categoria_componente_id' => $componente->categoria_componente_id,
                'product_id' => $this->id,
                'mcomponent_id' => $componente->id

            ]);

        }

    }


    public function createMaterialsToProduct($request){

        $glass = 'id_vidro_' . $this->id;
        $aluminum = 'id_aluminio_' . $this->id;
        $component = 'id_componente_' . $this->id;
        $vidrosProduto = $this->glasses();
        $aluminiosProduto = $this->aluminums();
        $componentesProduto = $this->components();

        if ($request->has($glass)) {
            $glassesAll = Glass::getGlassesWhereIn($request->$glass);
            Glass::deleteGlassOnListWhereNotIn($vidrosProduto,$request->$glass);

            foreach ($request->$glass as $id) {

                $vidro = $glassesAll->where('id', $id)->shift();

                if ($vidro->is_modelo == 1) {

                    $vidro->createGlass([
                        'nome' => $vidro->nome,
                        'cor' => $vidro->cor,
                        'tipo' => $vidro->tipo,
                        'espessura' => $vidro->espessura,
                        'preco' => $vidro->preco,
                        'product_id' => $this->id,
                        'categoria_vidro_id' => $vidro->categoria_vidro_id,
                        'is_modelo' => 0,
                        'mglass_id' => $vidro->id
                    ]);

                }
            }

        } else {

            Glass::deleteGlassOnListWhereNotIn($vidrosProduto,[]);

        }

        if ($request->has($aluminum)) {

            $aluminumsAll = Aluminum::getAluminumsWhereIn($request->$aluminum);
            Aluminum::deleteAluminumOnListWhereNotIn($aluminiosProduto,$request->$aluminum);

            foreach ($request->$aluminum as $id) {

                $aluminio = $aluminumsAll->where('id', $id)->shift();

                if ($aluminio->is_modelo == 1) {
                    //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO

                    $aluminioMedida = $aluminioPeso = 0;
                    $aluminio->calcularMedidaPesoAluminio($aluminioMedida,$aluminioPeso,$aluminio,$this);

                    $aluminio->createAluminum([
                        'perfil' => $aluminio->perfil,
                        'descricao' => $aluminio->descricao,
                        'medida' => $aluminioMedida,
                        'qtd' => $aluminio->qtd,
                        'peso' => $aluminioPeso,
                        'preco' => $aluminio->preco,
                        'tipo_medida' => $aluminio->tipo_medida,
                        'is_modelo' => 0,
                        'product_id' => $this->id,
                        'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,
                        'maluminum_id' => $aluminio->id
                    ]);

                }
            }

        } else {

            Aluminum::deleteAluminumOnListWhereNotIn($aluminiosProduto,[]);

        }


        if ($request->has($component)) {
            $componentsAll = Component::getComponentsWhereIn($request->$component);
            Component::deleteComponentOnListWhereNotIn($componentesProduto,$request->$component);

            foreach ($request->$component as $id) {

                $componente = $componentsAll->where('id', $id)->shift();

                if ($componente->is_modelo == 1) {

                    $componente->createComponent([
                        'nome' => $componente->nome,
                        'qtd' => $componente->qtd,
                        'preco' => $componente->preco,
                        'is_modelo' => 0,
                        'product_id' => $this->id,
                        'categoria_componente_id' => $componente->categoria_componente_id,
                        'mcomponent_id' => $componente->id
                    ]);

                }
            }

        } else {

            Component::deleteComponentOnListWhereNotIn($componentesProduto,[]);

        }

    }


}
