<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MProduct extends Model
{

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'categoria_produto_id');
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
}
