<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $guarded = [];
    
    public function glass()
    {
        return $this->belongsTo(
            Glass::class,
            'glass_id'
        );
    }

    public function aluminum()
    {
        return $this->belongsTo(
            Aluminum::class,
            'aluminum_id'
        );
    }

    public function component()
    {
        return $this->belongsTo(
            Component::class,
            'component_id'
        );
    }

    public function sales(){
        return $this->belongsToMany(
            Sale::class,
            'storage_sale',
            'estoque_id',
            'venda_id'
        )->withPivot('qtd_reservada');
    }
}
