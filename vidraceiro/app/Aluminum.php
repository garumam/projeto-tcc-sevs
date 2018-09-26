<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluminum extends Model
{

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_aluminio_id');
    }


    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }

    public function mProducts(){
        return $this->belongsToMany(
            MProduct::class,
            'm_product_aluminum',
            'aluminio_id',
            'm_produto_id'
        );
    }

    public function providers(){
        return $this->belongsToMany(
            Provider::class,
            'provider_aluminum',
            'aluminio_id',
            'provider_id'
        );
    }

    public function storage()
    {
        return $this->hasOne(
            Storage::class,
            'aluminum_id'
        );
    }


    public function updateAluminum(array $input){

        return self::update($input);

    }

    public function deleteAluminum($id){

        $aluminum = self::findAluminumById($id);
        if($aluminum){
            return $aluminum->delete();
        }

        return false;

    }

    public function findAluminumById($id){

        return self::find($id);

    }


    public static function createAluminum(array $input){
        return self::create($input);
    }

    public static function getAllAluminumsOrAllModels($is_modelo = 0){

        return self::where('is_modelo', $is_modelo)->get();

    }


    public static function getAluminumsWhereIn(array $ids){

        return self::wherein('id', $ids)->get();

    }

    public static function deleteAluminumOnListWhereNotIn($aluminum,array $ids){

        return $aluminum->whereNotIn('id', $ids)->delete();

    }

    //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO
    public function calcularMedidaPesoAluminio(&$aluminioMedida,&$aluminioPeso,$aluminum,$product){
        $aluminioMedida = $aluminum->tipo_medida === 'largura' ? $product->largura :
            ($aluminum->tipo_medida === 'altura' ? $product->altura : $aluminum->medida);
        $aluminioPeso = ($aluminum->peso / $aluminum->medida) * $aluminioMedida;
        $aluminioPeso = number_format($aluminioPeso, 3, '.', '');
    }
}
