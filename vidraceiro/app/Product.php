<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Glass;

class Product extends Model
{
    public function glasses(){
        return $this->belongsToMany(
            Glass::class,
            'product_glass',
            'produto_id',
            'vidro_id'
        );
    }
    public function aluminums(){
        return $this->belongsToMany(
            Aluminum::class,
            'product_aluminum',
            'produto_id',
            'aluminio_id'
        );
    }
    public function components(){
        return $this->belongsToMany(
            Glass::class,
            'product_component',
            'produto_id',
            'componente_id'
        );
    }
}
