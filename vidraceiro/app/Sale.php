<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    protected $fillable = [
        'tipo_pagamento',
        'qtd_parcelas',
        'data_venda',
        'valor_venda',
        'desconto',
        'entrada',
        'orcamento_id',
        'usuario_id'
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

    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
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

    /*public function updateSale(array $input){

        return self::update($input);

    }*/

    /*public function deleteSale(){

        return self::delete();

    }*/

    public function findSaleById($id){

        return self::find($id);

    }

    public function createSaleInstallments($request, $user_id){
        $configuration = Configuration::all()->first();

        for ($i = 1; $i <= $request->qtd_parcelas; $i++) {
            $dias = $i * $configuration->dias_parcelas;
            $datavencimento = date('Y-m-d', strtotime("+$dias days", strtotime($request->data_venda)));
            Installment::createInstallment([
                'valor_parcela' => $request->valor_parcela,
                'multa' => 0,
                'status_parcela' => 'ABERTO',
                'data_vencimento' => $datavencimento,
                'venda_id' => $this->id
            ]);
        }
        if($request->entrada !== 0)
            $this->createSalePayment($request->data_venda,$request->entrada,'Entrada recebida de venda a prazo.',$user_id);

        $budget = $this->budget;
        $client = new Client();
        $client = $client->findClientById($budget->cliente_id);
        $client->updateClient(['status' => 'DEVENDO']);

    }

    public function createSalePayment($date,$value,$message,$user_id){
        $payment = Payment::createPayment([
            'valor_pago' => $value,
            'data_pagamento' => $date,
            'venda_id' => $this->id
        ]);

        Financial::createFinancial([
            'tipo' => 'RECEITA',
            'descricao' => $message,
            'valor' => $payment->valor_pago,
            'data_vencimento' => $payment->data_pagamento,
            'status' => 'CONFIRMADO',
            'pagamento_id' => $payment->id,
            'usuario_id'=> $user_id
        ]);
        return $payment;
    }

    public function havePendingInstallment(){

        return !empty($this->installments()->where('status_parcela', 'ABERTO')->first());

    }

    /*public function havePayments(){

        return !empty($this->payments()->first());

    }*/

    public function attachStorageAndReservedQuantity($storageId,$reserved){
        return $this->storages()->sync([$storageId => ['qtd_reservada' => $reserved]], false);
    }

    public function getStorageSalePivot($column,$value){
        return $this->storages()->where($column, $value)->first();
    }

    /*public function deleteSaleInstallments(){
        return $this->installments()->delete();
    }*/

    /*public function getSalePayment(){
        return $this->payments()->first();
    }*/

    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::with('installments', 'payments', 'budget')
            ->whereHas('budget', function ($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%');
                $q->orWhereHas('client',function ($c) use ($search){
                    $c->where('nome', 'like', '%' . $search . '%');
                });
            })->orWhere('tipo_pagamento', 'like', '%' . $search . '%')
            ->orWhereHas('user',function ($q) use ($search){
                $q->where('name','like','%' . $search . '%');
            })
            ->paginate($paginate);
    }

   /* public function getSaleInstallmentsWithSearchAndPagination($search, $paginate){
        //ESTE METODO NÃO ESTÁ MAIS SENDO UTILIZADO POR ENQUANTO
        $paginate = $paginate ?? 10;

        return self::with('installments', 'payments', 'budget')
            ->where('tipo_pagamento','A PRAZO')->whereHas('budget', function ($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%');
            })->whereHas('installments', function ($q){
                $q->where('status_parcela', 'ABERTO');
            })->paginate($paginate);
    }*/

    public function useStorage(){

        $mensagem = ', não havia nenhum material em estoque!';

        foreach ($this->budget->getBudgetProductsWithRelations() as $product) {

            foreach ($product->glasses as $glass) {
                $m2 = ceil((($product->largura * $product->altura)*$product->qtd));
                $glassestoque = Storage::getFirstStorageWhere('glass_id', $glass->mglass_id);
                $qtdreservadavenda = $this->getStorageSalePivot('glass_id',$glass->mglass_id);
                if ($glassestoque->qtd > 0) {
                    $qtd_reservada = null;
                    $resto = 0;
                    if ($glassestoque->qtd < $m2) {
                        $qtd_reservada = $glassestoque->qtd;
                    } else {
                        $qtd_reservada = $m2;
                        $resto = $glassestoque->qtd - $m2;
                    }

                    if (!empty($qtdreservadavenda)) {
                        $qtd_reservada += $qtdreservadavenda->pivot->qtd_reservada;
                    }
                    $this->attachStorageAndReservedQuantity($glassestoque->id,$qtd_reservada);

                    $glassestoque->updateStorage('qtd',$resto);
                    $mensagem = ', estoque atualizado!';

                }
            }

            foreach ($product->aluminums as $aluminum) {
                $aluminumestoque = Storage::getFirstStorageWhere('aluminum_id', $aluminum->maluminum_id);
                $qtdreservadavenda = $this->getStorageSalePivot('aluminum_id',$aluminum->maluminum_id);
                $pecas6mQtd = ceil(((($aluminum->medida * $aluminum->qtd)*$product->qtd)/6));
                if ($aluminumestoque->qtd > 0) {

                    $qtd_reservada = null;
                    $resto = 0;

                    if ($aluminumestoque->qtd < $pecas6mQtd) {
                        $qtd_reservada = $aluminumestoque->qtd;
                    } else {
                        $qtd_reservada = $pecas6mQtd;
                        $resto = $aluminumestoque->qtd - $pecas6mQtd;
                    }

                    if (!empty($qtdreservadavenda)) {
                        $qtd_reservada += $qtdreservadavenda->pivot->qtd_reservada;
                    }
                    $this->attachStorageAndReservedQuantity($aluminumestoque->id,$qtd_reservada);

                    $aluminumestoque->updateStorage('qtd',$resto);
                    $mensagem = ', estoque atualizado!';

                }
            }

            foreach ($product->components as $component) {
                $componentestoque = Storage::getFirstStorageWhere('component_id', $component->mcomponent_id);
                $qtdreservadavenda = $this->getStorageSalePivot('component_id', $component->mcomponent_id);
                $qtdComponent = $component->qtd * $product->qtd;
                if ($componentestoque->qtd > 0) {
                    $qtd_reservada = null;
                    $resto = 0;

                    if ($componentestoque->qtd < $qtdComponent) {
                        $qtd_reservada = $componentestoque->qtd;
                    } else {
                        $qtd_reservada = $qtdComponent;
                        $resto = $componentestoque->qtd - $qtdComponent;
                    }

                    if (!empty($qtdreservadavenda)) {
                        $qtd_reservada += $qtdreservadavenda->pivot->qtd_reservada;
                    }
                    $this->attachStorageAndReservedQuantity($componentestoque->id,$qtd_reservada);

                    $componentestoque->updateStorage('qtd',$resto);
                    $mensagem = ', estoque atualizado!';

                }
            }


        }

        return $mensagem;

    }

    public static function filterSales($request){

        $sales = new Sale();
        $formas_pagamento = $request->tipo_pagamento;
        $totalde = $request->valor_inicial;
        $totalate = $request->valor_final;
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
            $sales =  self::where(function ($query) use ($data_inicial,$data_final, $totalde,$totalate,$totalentrou,$dataentrou){
                if($dataentrou){
                    $query->where(function ($q) use ($data_inicial,$data_final){
                        if($data_final !== null)
                            $q->whereDate('data_venda','<=',$data_final);

                        if($data_inicial !== null)
                            $q->whereDate('data_venda','>=',$data_inicial);
                    });
                }

                if($totalentrou){
                    $query->where(function ($q) use ($totalde,$totalate){
                        
                        if($totalate !== null)
                            $q->where('valor_venda','<=',$totalate);

                        if($totalde !== null)
                            $q->where('valor_venda','>=',$totalde);
                        
                    });
                }
            });
        }

        if($formas_pagamento === 'TODAS'){
            $sales = $sales->get();
        }else{
            $sales = $sales->where('tipo_pagamento',$formas_pagamento)->get();
        }
        return $sales;
    }

}
