<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluminum extends Model
{
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
}
