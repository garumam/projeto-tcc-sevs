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
}
