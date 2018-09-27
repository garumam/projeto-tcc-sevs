<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    protected $fillable = [
        'tipo',
        'descricao',
        'valor'
    ];

    public static function createFinancial(array $input){

        return self::create($input);

    }
}
