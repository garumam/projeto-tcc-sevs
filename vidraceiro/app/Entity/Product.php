<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Glass;
class Product extends Model
{
    public function glasses(){
        return $this->belongsToMany(Glass::class);
    }
}
