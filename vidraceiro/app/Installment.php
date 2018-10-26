<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public static function getPendingInstallmentsWithSearchAndPagination($search,$paginate,&$notPaginateInstallments){

        $paginate = $paginate ?? 10;

        $queryBuilder = self::where('status_parcela', 'ABERTO')
            ->whereHas('sale',function ($s) use ($search){
                $s->whereHas('budget',function ($b) use ($search){
                    $b->whereHas('client',function ($c) use ($search){
                        $c->where('nome','like', '%' . $search . '%');
                    });
                });
            });

        $notPaginateInstallments = $queryBuilder->get();

        return $queryBuilder->paginate($paginate);
    }

    public static function readjust(){

        $installments = self::where('status_parcela','ABERTO')->get();

        foreach ($installments as $installment){
            if(strtotime($installment->data_vencimento) < strtotime(date('Y-m-d',time()))){

                $data_inicio = new \DateTime($installment->data_vencimento);
                $data_fim = new \DateTime(date('Y-m-d',time()));

                $dateInterval = $data_inicio->diff($data_fim);

                // APLICANDO 5% DE REAJUSTE POR DIA SEMPRE EM CIMA DO VALOR DA PARCELA BASE
                $valorMulta = $dateInterval->days * $installment->valor_parcela * 0.05;

                $valorMulta = number_format($valorMulta,2,'.','');

                $installment->updateInstallment('multa',$valorMulta);
            }
        }
    }
}
