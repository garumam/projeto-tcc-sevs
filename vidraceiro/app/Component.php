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

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_component',
            'componente_id',
            'produto_id'
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
}
