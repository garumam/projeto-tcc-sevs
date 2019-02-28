<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'porcent_reajuste',
        'dias_parcelas',
        'porcent_m_lucro'
    ];

    public function findConfigurationById($id){

        return self::find($id);

    }

    public function updateConfiguration(array $input){

        return self::update($input);

    }

}
