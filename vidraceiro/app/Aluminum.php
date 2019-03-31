<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Aluminum extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'perfil',
        'descricao',
        'medida',
        'qtd',
        'peso',
        'preco',
        'tipo_medida',
        'espessura',
        'imagem',
        'is_modelo',
        'maluminum_id',
        'categoria_aluminio_id',
        'product_id'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_aluminio_id')->withTrashed();
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


    public function getWithSearchAndPagination($search, $paginate, $restore = false){

        $paginate = $paginate ?? 10;

        $queryBuilder = self::where('is_modelo', 1)->where('perfil', 'like', '%' . $search . '%');

        if($restore)
            $queryBuilder = $queryBuilder->onlyTrashed();

        return $queryBuilder->paginate($paginate);
    }


    public function updateAluminum(array $input){

        return self::update($input);

    }

    public function deleteAluminum(){

        return self::delete();

    }

    public function findAluminumById($id){

        return self::find($id);

    }

    public function restoreAluminumById($id){

        $aluminum = self::onlyTrashed()->find($id);

        return $aluminum? $aluminum->restore(): false;
    }


    public function createAluminum(array $input){

        $aluminum = self::create($input);

        if($aluminum->is_modelo === 1){
            Storage::createStorage([
                'aluminum_id' => $aluminum->id
            ]);
        }

        return $aluminum;
    }

    public function syncProviders($ids){
        $this->providers()->sync($ids);
    }

    public static function getAllAluminumsOrAllModels($is_modelo = 0){

        return self::where('is_modelo', $is_modelo)->get();

    }


    public static function getAluminumsWhereIn(array $ids){

        return self::wherein('id', $ids)->get();

    }

    public static function deleteAluminumOnListWhereNotIn($aluminum,array $ids){

        return $aluminum->whereNotIn('id', $ids)->forceDelete();

    }

    //medida do M LINEAR FOI GERADA ASSIM: ($product->largura * 2)+($product->altura * 2)
    public function calcularMedidaPesoAluminio(&$aluminioMedida,&$aluminioPeso,$aluminum,$product){
        $aluminioMedida = 0;
        switch($aluminum->tipo_medida){
            case 'largura':
                $aluminioMedida = $product->largura;
                break;
            case 'altura':
                $aluminioMedida = $product->altura;
                break;
            case 'mlinear':
                $aluminioMedida = ($product->largura * 2)+($product->altura * 2);
                break;
        }

        $aluminioPeso = ($aluminum->peso / $aluminum->medida) * $aluminioMedida;
        $aluminioPeso = number_format($aluminioPeso, 3, '.', '');
    }
}
