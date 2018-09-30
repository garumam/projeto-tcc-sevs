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

    public function getFirstCompany(){
        return self::take(1)->first();
    }

    public function findCompanyById($id){
        return self::find($id);
    }

    public function createFinancial(array $input){

        return self::create($input);

    }

    public function updateFinancial(array $input){

        return self::update($input);

    }

    public function deleteFinancial(){

        return self::delete();

    }
}
