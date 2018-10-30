<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'descricao',
        'imagem',
        'categoria_produto_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class,'categoria_produto_id')->withTrashed();
    }

    public function products(){
        return $this->hasMany(Product::class, 'm_produto_id');
    }

    public function glasses(){
        return $this->belongsToMany(
            Glass::class,
            'm_product_glass',
            'm_produto_id',
            'vidro_id'
        );
    }
    public function aluminums(){
        return $this->belongsToMany(
            Aluminum::class,
            'm_product_aluminum',
            'm_produto_id',
            'aluminio_id'
        );
    }
    public function components(){
        return $this->belongsToMany(
            Component::class,
            'm_product_component',
            'm_produto_id',
            'componente_id'
        );
    }

    public function createMProduct(array $input){

        return self::create($input);

    }

    public function updateMProduct(array $input){

        return self::update($input);

    }

    public function deleteMProduct(){

        return self::delete();

    }

    public function findMProductById($id){

        return self::find($id);

    }

    public function restoreMProductById($id){

        $mproduct = self::onlyTrashed()->find($id);

        return $mproduct? $mproduct->restore(): false;
    }

    public function syncMaterialsOfMProduct($glasses, $aluminums, $components){

        $this->glasses()->sync($glasses);
        $this->aluminums()->sync($aluminums);
        $this->components()->sync($components);

    }

    public function getWithSearchAndPagination($search, $paginate, $restore = false){

        $paginate = $paginate ?? 10;

        $queryBuilder = self::with('category')
            ->where('nome', 'like', '%' . $search . '%');

        if($restore)
            $queryBuilder = $queryBuilder->onlyTrashed();

        return $queryBuilder->paginate($paginate);
    }

    public static function getAllMProducts(){

        return self::all();

    }

    public static function findMProductWithRelationsById($id){

        return self::with('glasses', 'aluminums', 'components','category')->find($id);

    }
}
