<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Glass extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_vidro_id');
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_glass',
            'vidro_id',
            'produto_id'
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
}
