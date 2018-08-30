<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    protected $guarded = [];

    public function products(){
        return $this->hasMany(
            Product::class,
            'budget_id'
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

    public function client(){
        return $this->belongsTo(Client::class,'cliente_id');
    }

    public function sale(){
        return $this->belongsTo(Sale::class, 'orcamento_id');
    }
}
