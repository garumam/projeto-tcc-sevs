<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Glass extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'cor',
        'tipo',
        'espessura',
        'preco',
        'is_modelo',
        'mglass_id',
        'categoria_vidro_id',
        'product_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_vidro_id')->withTrashed();
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
            'm_product_glass',
            'vidro_id',
            'm_produto_id'
        );
    }

    public function providers(){
        return $this->belongsToMany(
            Provider::class,
            'provider_glass',
            'vidro_id',
            'provider_id'
        );
    }

    public function storage()
    {
        return $this->hasOne(
            Storage::class,
            'glass_id'
        );
    }

    public function getWithSearchAndPagination($search, $paginate, $restore = false){

        $paginate = $paginate ?? 10;

        $queryBuilder = self::where('is_modelo', 1)->where('nome', 'like', '%' . $search . '%');

        if($restore)
            $queryBuilder = $queryBuilder->onlyTrashed();

        return $queryBuilder->paginate($paginate);
    }

    public function findGlassById($id){

        return self::find($id);

    }

    public function findDeletedGlassById($id){

        return self::onlyTrashed()->find($id);

    }

    public function createGlass(array $input){
        $glass = self::create($input);

        if($glass->is_modelo === 1){
            Storage::createStorage([
                'metros_quadrados' => 0,
                'glass_id' => $glass->id
            ]);
        }

        return $glass;
    }

    public function updateGlass(array $input){

        return self::update($input);

    }

    public function deleteGlass(){

        return self::delete();

    }

    public function syncProviders($ids){
        $this->providers()->sync($ids);
    }

    public static function getAllGlassesOrAllModels($is_modelo = 0){

        return self::where('is_modelo', $is_modelo)->get();

    }

    public static function getGlassesWhereIn(array $ids){

        return self::wherein('id', $ids)->get();

    }

    public static function deleteGlassOnListWhereNotIn($glasses,array $ids){

        return $glasses->whereNotIn('id', $ids)->forceDelete();

    }


}
