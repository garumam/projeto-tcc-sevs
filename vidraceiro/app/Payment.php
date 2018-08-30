<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function sale(){
        return $this->belongsTo(Sale::class, 'venda_id');
    }
}
