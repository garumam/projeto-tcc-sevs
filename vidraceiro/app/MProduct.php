<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MProduct extends Model
{
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
            Glass::class,
            'm_product_component',
            'm_produto_id',
            'componente_id'
        );
    }
}
