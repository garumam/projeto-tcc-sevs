<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'porcent_reajuste',
        'dias_parcelas',
        'porcent_m_lucro',
        'juros_mensal_parcel'
    ];

    public function getConfiguration(){

        return self::take(1)->first();

    }

    public function updateConfiguration(array $input){

        return self::update($input);

    }

}
