<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Glass;
class Category extends Model
{
    public function glasses(){
        return $this->hasMany(
            Glass::class,
            'categoria_vidro_id'
        );
    }
}
