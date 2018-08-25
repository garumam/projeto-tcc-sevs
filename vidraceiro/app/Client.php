<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    public function budgets(){
        return $this->hasMany(Budget::class,'cliente_id');
    }
}
