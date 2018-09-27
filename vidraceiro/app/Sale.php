<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'tipo_pagamento',
        'qtd_parcelas',
        'data_venda',
        'orcamento_id'
    ];

    public function budget(){
        return $this->belongsTo(Budget::class, 'orcamento_id');
    }

    public function installments(){
        return $this->hasMany(Installment::class, 'venda_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'venda_id');
    }

    public function storages(){
        return $this->belongsToMany(
            Storage::class,
            'storage_sale',
            'venda_id',
            'estoque_id'
        )->withPivot('qtd_reservada');
    }


    public function createSale(array $input){

        return self::create($input);

    }

    public function updateSale(array $input){

        return self::update($input);

    }

    public function deleteSale(){

        return self::delete();

    }

    public function findSaleById($id){

        return self::find($id);

    }

    public function havePendingInstallment(){

        return !empty($this->installments()->where('status_parcela', 'ABERTO')->first());

    }

    public function attachStorageAndReservedQuantity($storageId,$reserved){
        return $this->storages()->sync([$storageId => ['qtd_reservada' => $reserved]], false);
    }

    public function getStorageSalePivot($column,$value){
        return $this->storages()->where($column, $value)->first();
    }

    public function deleteSaleInstallments(){
        return $this->installments()->delete();
    }

    public function getSalePayment(){
        return $this->payments()->first();
    }

    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::with('installments', 'payments', 'budget')
            ->whereHas('budget', function ($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%');
            })->orWhere('tipo_pagamento', 'like', '%' . $search . '%')
            ->paginate($paginate);
    }

    public function getSaleInstallmentsWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::with('installments', 'payments', 'budget')
            ->where('tipo_pagamento','A PRAZO')->whereHas('budget', function ($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%');
            })->whereHas('installments', function ($q){
                $q->where('status_parcela', 'ABERTO');
            })->paginate($paginate);
    }

}
