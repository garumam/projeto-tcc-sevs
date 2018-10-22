<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function sale(){
        return $this->belongsTo(Sale::class, 'venda_id');
    }

    public function financial(){
        return $this->hasOne(Financial::class, 'pagamento_id');
    }

    public static function createPayment(array $input){

        return self::create($input);

    }

    public function deletePayment(){
        return self::delete();
    }
}
