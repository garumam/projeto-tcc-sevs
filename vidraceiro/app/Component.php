<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_componente_id');
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_component',
            'componente_id',
            'produto_id'
        );
    }
}
