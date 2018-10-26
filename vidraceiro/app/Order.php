<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes;

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

    public static function filterOrders($request){

        $situacao = $request->status;
        $orders = new Order();
        $totalde = $request->total_de;
        $totalate = $request->total_ate;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $totalentrou = $dataentrou = false;

        if($totalde !== null || $totalate !== null){
            $totalentrou = true;
        }

        if($data_inicial !== null || $data_final !== null){
            $dataentrou = true;
        }

        if($totalentrou || $dataentrou){

            $orders =  self::where(function ($query) use ($data_inicial,$data_final, $totalde,$totalate,$totalentrou,$dataentrou){
                if($dataentrou){
                    $query->where(function ($q) use ($data_inicial,$data_final){
                        if($data_final !== null)
                            $q->whereDate('data_inicial','<=',$data_final);

                        if($data_inicial !== null)
                            $q->whereDate('data_inicial','>=',$data_inicial);
                    });
                }

                if($totalentrou){
                    $query->where(function ($q) use ($totalde,$totalate){
                        if($totalate !== null)
                            $q->where('total','<=',$totalate);

                        if($totalde !== null)
                            $q->where('total','>=',$totalde);
                    });
                }
            });
        }

        if($situacao === 'TODOS'){
            $orders = $orders->get();
        }else{
            $orders = $orders->where('situacao',$situacao)->get();
        }
        return $orders;
    }
}
