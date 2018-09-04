<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded = [];

    /*public function budgets(){
        return $this->belongsToMany(
            Budget::class,
            'order_budget',
            'ordem_id',
            'orcamento_id'
        );
    }*/

    public function budgets(){
        return $this->hasMany(Budget::class,'ordem_id');
    }
}
