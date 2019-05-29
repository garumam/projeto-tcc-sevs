<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ConfigurationSeeds::class);
        $this->call(PermissionSeeds::class);
        $this->call(RoleSeeds::class);
        $this->call(CarregaItens::class);
        $this->call(CarregaItensTeste::class);

        //INICIO NOVO FACTORY

        factory(App\Client::class, 10)->create();
        factory(App\Provider::class, 25)->create();
        factory(App\MProduct::class, 20)->create();
        factory(App\Budget::class, 60)->create();
        factory(App\Financial::class,100)->create();
        factory(App\Product::class, 80)->create();
        $products = App\Product::whereNotIn('id',[1,2,3,4])->get();
        foreach ($products as $product){
            factory(App\Glass::class)->create(['product_id' => $product->id]);
        }
        factory(App\Aluminum::class, 100)->create();
        factory(App\Component::class, 100)->create();

        foreach(App\Budget::all() as $budget){
            $budget->updateBudgetTotal();
        }

        $budgets = App\Budget::whereIn('status',['APROVADO','FINALIZADO'])->whereNotIn('id',[1,2,3,4])->get();

        foreach ($budgets as $budget){
            factory(App\Sale::class)->create(['orcamento_id' => $budget->id,'data_venda' => $budget->data]);
        }

        $sales = App\Sale::with('budget')->whereNotIn('id',[1,2])->get();

        $juros = App\Configuration::first()->juros_mensal_parcel/100;

        foreach ($sales as $sale){
            $total = $sale->budget->total;
            if($sale->tipo_pagamento === 'A PRAZO'){
                $total = $total * pow(1+$juros,$sale->qtd_parcelas);
                $total = number_format($total,2,'.','');
                $request = new Request();
                $request->merge([
                    'qtd_parcelas'=>$sale->qtd_parcelas,
                    'data_venda'=>$sale->data_venda,
                    'valor_parcela'=>number_format($total/$sale->qtd_parcelas,2,'.',''),
                    'entrada'=> 0
                ]);
                $sale->createSaleInstallments($request,rand(1,2));

                $pagar = rand(0, 1) === 1 ? true : false;

                if($pagar){
                    $qtd = rand(1,ceil($sale->qtd_parcelas/2));

                    $installments = $sale->installments()->get()->take(ceil($qtd/2));
                    
                    foreach ($installments as $installment) {
                        $valorParcela = $installment->valor_parcela + $installment->multa;
                        $valorParcela = number_format($valorParcela,2,'.','');
                        $sale->createSalePayment($installment->data_vencimento,$valorParcela,'Pagamento de parcela de venda a prazo.', rand(1,2));

                        $installment->updateInstallment('status_parcela','PAGO');
                    }


                    $budget = $sale->budget;
                    $client = new App\Client();
                    $client = $client->findClientById($budget->cliente_id);
                    $client->updateStatus();

                }

            }else{
                $sale->createSalePayment($sale->data_venda,$total,'Pagamento de venda à vista.',$sale->usuario_id);
            }
            $sale->update(['valor_venda'=>$total]);
        }


        $budgets = App\Budget::with('sale')->where('status','FINALIZADO')->whereNotIn('id',[1,2,3,4])->get();

        foreach ($budgets as $budget){
            $data_inicial = date('Y-m-d', strtotime($budget->sale->data_venda));
            $dias = rand(2, 15);
            $data_final = date('Y-m-d', strtotime("+$dias days", strtotime($data_inicial)));
            $order = factory(App\Order::class)->create([
                'data_final' => $data_final,
                'data_inicial' => $data_inicial,
                'situacao' => 'CONCLUIDA',
                'total' => $budget->sale->valor_venda,
                'updated_at' => $data_final
            ]);
            $budget->update(['ordem_id'=>$order->id]);
        }

    
        $budgets = App\Budget::with('sale')->where('status','APROVADO')->whereNotIn('id',[1,2,3,4])->get();
      
        foreach($budgets as $budget){
            $criarordem = rand(0, 1) === 1 ? true : false;
            if ($criarordem) {
                $data_inicial = date('Y-m-d', strtotime($budget->sale->data_venda));
                $dias = rand(2, 15);
                $data_final = date('Y-m-d', strtotime("+$dias days", strtotime($data_inicial)));
                $order = factory(App\Order::class)->create([
                    'data_final' => $data_final,
                    'data_inicial' => $data_inicial,
                    'total' => $budget->sale->valor_venda,
                    'updated_at' => $data_inicial
                ]);
                $budget->update(['ordem_id'=>$order->id]);
            }
        }
        
        $qtdcanceladas = rand(5,15);

        $order = factory(App\Order::class, $qtdcanceladas)->create([
            'situacao' => 'CANCELADA'
        ]);

        $storages = App\Storage::all();
        
        foreach($storages as $storage){
            $qtd = rand(0,27);
            $storage->update(['qtd'=>$qtd]);
        }

        $providers = App\Provider::all();

        $glasses = App\Glass::where('is_modelo',1)->get();
        $aluminums = App\Aluminum::where('is_modelo',1)->get();
        $components = App\Component::where('is_modelo',1)->get();
        
        foreach($glasses as $glass){
            $providerRandom = $providers->random(rand(1,5));
            $ids = [];
            foreach($providerRandom as $provider){
                $ids[] = $provider->id;
            }
            $glass->syncProviders($ids);
        }

        foreach($aluminums as $aluminum){
            $providerRandom = $providers->random(rand(1,5));
            $ids = [];
            foreach($providerRandom as $provider){
                $ids[] = $provider->id;
            }
            $aluminum->syncProviders($ids);
        }

        foreach($components as $component){
            $providerRandom = $providers->random(rand(1,5));
            $ids = [];
            foreach($providerRandom as $provider){
                $ids[] = $provider->id;
            }
            $component->syncProviders($ids);
        }
        

        //FIM NOVO FACTORY

    }

}
