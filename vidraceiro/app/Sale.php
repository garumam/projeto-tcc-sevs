<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    public function budget(){
        return $this->belongsTo(Budget::class, 'orcamento_id');
    }

    public function installments(){
        return $this->hasMany(Installment::class, 'venda_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'venda_id');
    }
}
