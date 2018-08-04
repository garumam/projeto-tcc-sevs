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

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_aluminum',
            'aluminio_id',
            'produto_id'
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
}
