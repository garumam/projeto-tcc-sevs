<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $guarded = [];

    public function sale(){
        return $this->belongsTo(Sale::class, 'venda_id');
    }

    public static function createInstallment(array $input){

        return self::create($input);

    }

    public function updateInstallment($column,$value){

        return self::update([$column => $value]);

    }

    public static function getInstallmentsWherein(array $ids){
        return self::whereIn('id', $ids)->get();
    }
}
