<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'bairro',
        'cep',
        'uf',
        'email',
        'telefone'
    ];

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
