<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'telefone',
        'celular',
        'email'
    ];

    public function client(){
        return $this->belongsTo(Client::class,'contato_id','id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'contato_id','id');
    }

    public function provider(){
        return $this->belongsTo(Provider::class,'contato_id','id');
    }

    public function budget(){
        return $this->belongsTo(Budget::class,'contato_id','id');
    }

    public function createContact(array $input){

        return self::create($input);

    }

    public function updateContact(array $input){

        return self::update($input);

    }

    public function deleteContact(){

        return self::delete();

    }

}
