<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $guarded = [];

    public function glasses(){
        return $this->belongsToMany(
            Glass::class,
            'provider_glass',
            'provider_id',
            'vidro_id'
        );
    }
    public function aluminums(){
        return $this->belongsToMany(
            Aluminum::class,
            'provider_aluminum',
            'provider_id',
            'aluminio_id'
        );
    }
    public function components(){
        return $this->belongsToMany(
            Component::class,
            'provider_component',
            'provider_id',
            'componente_id'
        );
    }
}
