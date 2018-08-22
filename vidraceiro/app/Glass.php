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

    /*public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_glass',
            'vidro_id',
            'produto_id'
        );
    }*/

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
}
