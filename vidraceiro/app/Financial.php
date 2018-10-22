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

    public function getWithSearchAndPagination($search, $paginate, $period){

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
        }

        $queryBuilder = self::where(function ($c) use ($data_inicial,$data_final){
                $c->whereHas('payment', function ($q) use ($data_inicial,$data_final) {
                    $q->where('data_pagamento','<=',$data_final);
                    $q->where('data_pagamento','>=',$data_inicial);
                })->orWhereDoesntHave('payment', function($q) use($data_inicial,$data_final){
                    $q->whereDate('created_at','<=',$data_final)->where('created_at','>=',$data_inicial);
                });
            })->where(function ($c) use ($search) {
                $c->where('descricao', 'like', '%' . $search . '%')
                    ->orWhere('tipo', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });


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
        if($valor_inicial < $valor_final){
            $valorentrou = true;
        }

        if(strtotime($data_inicial) < strtotime($data_final)){

            $dataentrou = true;
        }

        if($valorentrou || $dataentrou){

            $financials =  self::where(function ($query) use ($data_inicial,$data_final, $valor_inicial,$valor_final,$valorentrou,$dataentrou){
                if($dataentrou){
                    $query->whereBetween('created_at', [$data_inicial,$data_final]);
                }

                if($valorentrou){
                    $query->whereBetween('valor', [$valor_inicial,$valor_final]);
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
