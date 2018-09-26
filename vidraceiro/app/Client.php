<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nome',
        'cpf',
        'cnpj',
        'telefone',
        'celular',
        'email',
        'cep',
        'endereco',
        'bairro',
        'uf',
        'cidade',
        'complemento',
        'status'
    ];

    public function budgets(){
        return $this->hasMany(Budget::class,'cliente_id');
    }

    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::where('nome', 'like', '%' . $search . '%')
            ->orWhere('cpf', 'like', '%' . $search . '%')
            ->orWhere('cnpj', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->paginate($paginate);
    }

    public function createClient(array $input){

        return self::create($input);

    }

    public function updateClient(array $input){

        return self::update($input);

    }

    public function deleteClient($id){

        $client = self::findClientById($id);
        if($client){
            return $client->delete();
        }

        return false;

    }

    public function findClientById($id){

        return self::find($id);

    }

    public static function getAllClients(){

        return self::all();

    }

    public function updateClientBudgets(array $input){
        $budgetUpdated = false;
        foreach (self::budgets()->get() as $budget) {
            $budgetUpdated = $budget->update($input);
        }
        return $budgetUpdated;
    }
}
