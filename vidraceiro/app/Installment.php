<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $guarded = [];

    public function sale(){
        return $this->belongsTo(Sale::class, 'venda_id');
    }
}
