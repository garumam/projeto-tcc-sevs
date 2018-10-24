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
}
