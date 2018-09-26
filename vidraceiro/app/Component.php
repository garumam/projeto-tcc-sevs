<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_componente_id');
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
            'm_product_component',
            'componente_id',
            'm_produto_id'
        );
    }

    public function providers(){
        return $this->belongsToMany(
            Provider::class,
            'provider_component',
            'componente_id',
            'provider_id'
        );
    }

    public function storage()
    {
        return $this->hasOne(
            Storage::class,
            'component_id'
        );
    }

    public static function createComponent(array $input){
        return self::create($input);
    }

    public static function getAllComponentsOrAllModels($is_modelo = 0){

        return self::where('is_modelo', $is_modelo)->get();

    }

    public static function getComponentsWhereIn(array $ids){

        return self::wherein('id', $ids)->get();

    }

    public static function deleteComponentOnListWhereNotIn($component,array $ids){

        return $component->whereNotIn('id', $ids)->delete();

    }

}
