<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'nome',
        'endereco_id',
        'contato_id'
    ];

    public function location(){
        return $this->hasOne(Location::class,'id','endereco_id');
    }

    public function contact(){
        return $this->hasOne(Contact::class,'id','endereco_id');
    }

    public function getCompany(){
        return self::take(1)->first();
    }

    public function findCompanyById($id){
        return self::find($id);
    }

    public function createCompany(array $input){

        return self::create($input);

    }

    public function updateCompany(array $input){

        return self::update($input);

    }

    public function deleteCompany(){
        
        return self::delete();

    }
}
