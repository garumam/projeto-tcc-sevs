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
}
