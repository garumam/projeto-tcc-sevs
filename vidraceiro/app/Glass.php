<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Glass extends Model
{

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_vidro_id');
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

    public static function createGlass(array $input){
        return self::create($input);
    }

    public static function getAllGlassesOrAllModels($is_modelo = 0){

        return self::where('is_modelo', $is_modelo)->get();

    }

    public static function getGlassesWhereIn(array $ids){

        return self::wherein('id', $ids)->get();

    }

    public static function deleteGlassOnListWhereNotIn($glasses,array $ids){

        return $glasses->whereNotIn('id', $ids)->delete();

    }
}
