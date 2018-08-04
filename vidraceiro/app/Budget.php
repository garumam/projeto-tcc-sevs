<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    protected $guarded = [];

    public function products(){
        return $this->belongsToMany(
            Product::class,
            'budget_product',
            'orcamento_id',
            'produto_id'
        );
    }

    public function orders(){
        return $this->belongsToMany(
            Order::class,
            'order_budget',
            'orcamento_id',
            'ordem_id'
        );
    }
}
