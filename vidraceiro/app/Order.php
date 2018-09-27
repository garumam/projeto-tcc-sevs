<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'nome',
        'data_inicial',
        'total',
        'data_final',
        'situacao'
    ];

    public function budgets(){
        return $this->hasMany(Budget::class,'ordem_id');
    }

    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::where('nome', 'like', '%' . $search . '%')
            ->orWhere('situacao', 'like', '%' . $search . '%')
            ->paginate($paginate);
    }

    public function createOrder(array $input){

        return self::create($input);

    }

    public function updateOrder(array $input){

        return self::update($input);

    }

    public function deleteOrder(){

        return self::delete();

    }

    public function findOrderById($id){

        return self::find($id);

    }

    public function updateBudgetsStatusByOrderSituation($budgets){
        $budgetStatus = [];
        $ordemid = $this->id;
        if ($this->situacao === 'CONCLUIDA') {
            $budgetStatus = ['status' => 'FINALIZADO'];
        } elseif ($this->situacao === 'CANCELADA') {
            $budgetStatus = ['status' => 'APROVADO'];
            $ordemid = null;
        }

        foreach ($budgets as $budget) {
            $budget->updateBudget(array_merge(['ordem_id' => $ordemid], $budgetStatus));
        }
    }
}
