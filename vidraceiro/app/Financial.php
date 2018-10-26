<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Financial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tipo',
        'descricao',
        'valor',
        'pagamento_id',
        'usuario_id'
    ];

    public function payment(){
        return $this->belongsTo(Payment::class, 'pagamento_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function getWithSearchAndPagination($search, $paginate, $period, &$financialsByPeriod){

        $paginate = $paginate ?? 10;
        $period = $period ?? 'hoje';

        $data_inicial = $data_final = date_format(date_create(today()), 'Y-m-d');

        switch ($period){
            case 'hoje':
                break;
            case 'semana':

                $data_inicial = date('Y-m-d', strtotime("-6 days", strtotime($data_inicial)));

                break;
            case 'mes':

                $data_inicial = date('Y-m-d', strtotime("-29 days", strtotime($data_inicial)));

                break;
            case 'semestre':

                $data_inicial = date('Y-m-d', strtotime("-179 days", strtotime($data_inicial)));

                break;
            case 'anual':

                $data_inicial = date('Y-m-d', strtotime("-359 days", strtotime($data_inicial)));

                break;
            case 'tudo':

                $data_inicial = $data_final = null;

                break;
        }


        $queryBuilder = self::when($data_inicial, function ($query) use ($data_inicial, $data_final) {

                    return $query-> where(function ($c) use ($data_inicial,$data_final){

                        $c->whereHas('payment', function ($q) use ($data_inicial,$data_final) {
                            $q->whereDate('data_pagamento','<=',$data_final);
                            $q->whereDate('data_pagamento','>=',$data_inicial);
                        })
                        ->orWhere(function ($q) use ($data_inicial,$data_final){
                            $q->whereNull('pagamento_id');
                            $q->whereDate('created_at','<=',$data_final);
                            $q->whereDate('created_at','>=',$data_inicial);
                        });

                    });
            })
            ->where(function ($c) use ($search) {
                $c->where('descricao', 'like', '%' . $search . '%')
                    ->orWhere('tipo', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });

        $financialsByPeriod = $queryBuilder->get();

        return $queryBuilder->paginate($paginate);
    }

    public function findFinancialById($id){

        return self::find($id);

    }

    public function deleteFinancial(){

        return self::delete();

    }

    public static function getAll(){

        return self::all();

    }

    public static function createFinancial(array $input){

        return self::create($input);

    }

    public static function filterFinancial($request){

        $tipo_financa = $request->tipo_financa;
        $financials = new Financial();
        $valor_inicial = $request->valor_inicial;
        $valor_final = $request->valor_final;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $valorentrou = $dataentrou = false;

        if($valor_inicial !== null || $valor_final !== null){
            $valorentrou = true;
        }

        if($data_inicial !== null || $data_final !== null){
            $dataentrou = true;
        }

        if($valorentrou || $dataentrou){

            $financials =  self::where(function ($query) use ($data_inicial,$data_final, $valor_inicial,$valor_final,$valorentrou,$dataentrou){
                if($dataentrou){


                    $query-> where(function ($c) use ($data_inicial,$data_final){

                        $c->whereHas('payment', function ($q) use ($data_inicial,$data_final) {
                            if($data_final !== null)
                                $q->whereDate('data_pagamento','<=',$data_final);

                            if($data_inicial !== null)
                                $q->whereDate('data_pagamento','>=',$data_inicial);
                        })
                            ->orWhere(function ($q) use ($data_inicial,$data_final){
                                $q->whereNull('pagamento_id');

                                if($data_final !== null)
                                    $q->whereDate('created_at','<=',$data_final);

                                if($data_inicial !== null)
                                    $q->whereDate('created_at','>=',$data_inicial);
                            });

                    });


                }

                if($valorentrou){

                    $query->where(function ($q) use ($valor_inicial,$valor_final){
                        if($valor_final !== null)
                            $q->where('valor','<=',$valor_final);

                        if($valor_inicial !== null)
                            $q->where('valor','>=',$valor_inicial);
                    });
                }
            });
        }

        if($tipo_financa === 'TODOS'){
            $financials = $financials->get();
        }else{
            $financials = $financials->where('tipo',$tipo_financa)->get();
        }
        return $financials;

    }
}
