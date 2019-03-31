<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'cep',
        'endereco',
        'bairro',
        'uf',
        'cidade',
        'complemento'
    ];

    public function client(){
        return $this->belongsTo(Client::class,'endereco_id','id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'endereco_id','id');
    }

    public function provider(){
        return $this->belongsTo(Provider::class,'endereco_id','id');
    }

    public function budget(){
        return $this->belongsTo(Budget::class,'endereco_id','id');
    }

    public function createLocation(array $input){

        return self::create($input);

    }

    public function updateLocation(array $input){

        return self::update($input);

    }

    public function deleteLocation(){

        return self::delete();

    }

}
