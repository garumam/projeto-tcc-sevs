<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Installment extends Model
{
    protected $guarded = [];

    public function sale(){
        return $this->belongsTo(Sale::class, 'venda_id');
    }

    public static function createInstallment(array $input){

        return self::create($input);

    }

    public function updateInstallment($column,$value){

        return self::update([$column => $value]);

    }

    public static function getInstallmentsWherein(array $ids){
        return self::whereIn('id', $ids)->get();
    }

    public static function getPendingInstallmentsWithSearchAndPagination($search){


        $queryBuilder = self::where('status_parcela', 'ABERTO')
            ->whereHas('sale',function ($s) use ($search){
                $s->whereHas('budget',function ($b) use ($search){
                    $b->whereHas('client',function ($c) use ($search){
                        $c->where('nome','like', '%' . $search . '%');
                    });
                })->orWhereHas('user',function ($d) use ($search){
                    $d->where('name','like', '%' . $search . '%');
                });
            });

        return $queryBuilder->get();
    }

    public static function filterInstallment($request){
        $tipo_financa = $request->tipo_financa;
        $installments = new Installment();
        $valor_inicial = $request->valor_inicial;
        $valor_final = $request->valor_final;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $status = $request->status;
        $valorentrou = $dataentrou = false;

        if($tipo_financa === 'RECEITA' 
        || $tipo_financa === 'TODOS' 
        && $status === 'PENDENTE'){

            if($valor_inicial !== null || $valor_final !== null){
                $valorentrou = true;
            }

            if($data_inicial !== null || $data_final !== null){
                $dataentrou = true;
            }

            if($valorentrou || $dataentrou){

                $installments =  self::where(function ($query) use ($data_inicial,$data_final, $valor_inicial,$valor_final,$valorentrou,$dataentrou,$status){
                    if($dataentrou){


                        $query-> where(function ($c) use ($data_inicial,$data_final){

                            if($data_final !== null)
                                $c->whereDate('data_vencimento','<=',$data_final);

                            if($data_inicial !== null)
                                $c->whereDate('data_vencimento','>=',$data_inicial);

                        });


                    }

                    // if($valorentrou){

                    //     $query->where(function ($q) use ($valor_inicial,$valor_final){
                    //         if($valor_final !== null)
                    //             $q->where('valor_parcela','<=',$valor_final);

                    //         if($valor_inicial !== null)
                    //             $q->where('valor_parcela','>=',$valor_inicial);
                    //     });
                    // }

                    
                });
            }
        
        
            $installments = $installments->where('status_parcela','ABERTO')->get();
        }else{
            $installments = new Collection();
        }

        if($valorentrou){

            $installments = $installments->filter(function ($q) use ($valor_inicial,$valor_final){
                $condicao = false;
                $soma = $q->valor_parcela + $q->multa;
                $soma = number_format($soma,2,'.','');
                if($valor_final !== null)
                    $condicao = $soma <= $valor_final? true : false;

                if($valor_inicial !== null)
                    $condicao = $soma >= $valor_inicial? true : false;
                
                return $condicao;
            });
        }

        return $installments;

    }

    public static function readjust(){

        $installments = self::where('status_parcela','ABERTO')->get();

        $configuration = Configuration::all()->first();

        foreach ($installments as $installment){
            if(strtotime($installment->data_vencimento) < strtotime(date('Y-m-d',time()))){

                $data_inicio = new \DateTime($installment->data_vencimento);
                $data_fim = new \DateTime(date('Y-m-d',time()));

                $dateInterval = $data_inicio->diff($data_fim);

                $porcentagem_reajuste = $configuration->porcent_reajuste / 100;
                // APLICANDO % DE REAJUSTE CONFIGURADA NO SISTEMA POR DIA SEMPRE EM CIMA DO VALOR DA PARCELA BASE
                $valorMulta = $dateInterval->days * $installment->valor_parcela * $porcentagem_reajuste;

                $valorMulta = number_format($valorMulta,2,'.','');

                $installment->updateInstallment('multa',$valorMulta);
            }
        }
    }
}
