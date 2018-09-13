<?php

use Illuminate\Database\Seeder;

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
        $this->call(RoleSeeds::class);
        $this->call(CarregaItens::class);
        $this->call(CarregaItensTeste::class);

        //INICIO FACTORY

        factory(App\Client::class, 10)->create();
        factory(App\MProduct::class, 20)->create();

        factory(App\Budget::class, 20)->create();
        factory(App\Financial::class,20)->create();
        factory(App\Product::class, 40)->create();
        $products = App\Product::whereNotIn('id',[1,2,3])->get();

        foreach ($products as $product){
            factory(App\Glass::class)->create(['product_id' => $product->id]);
        }

        factory(App\Aluminum::class, 65)->create();
        factory(App\Component::class, 65)->create();
        $this->atualizaTotal();

        $budgets = App\Budget::where('status','APROVADO')->whereNotIn('id',[1,2,3])->get();

        foreach ($budgets as $budget){
            factory(App\Sale::class)->create(['orcamento_id' => $budget->id]);
        }


        $sales = App\Sale::with('budget')->where('tipo_pagamento','A PRAZO')->whereNotIn('id',[1,2])->get();

        foreach ($sales as $sale){

            $valor_parcela = $sale->budget->total/$sale->qtd_parcelas;

            $valor_parcela = number_format($valor_parcela, 2, '.', '');

            for($i = 1; $i <= $sale->qtd_parcelas; $i++){
                $installments = new App\Installment();
                $dias = $i * 30;
                $datavencimento = date('Y-m-d', strtotime("+$dias days",strtotime($sale->data_venda)));
                $installments->create([
                    'valor_parcela'=>$valor_parcela,
                    'status_parcela'=>'ABERTO',
                    'data_vencimento'=> $datavencimento,
                    'venda_id'=> $sale->id
                ]);
            }

        }

        $sales = App\Sale::with('budget')->where('tipo_pagamento','A VISTA')->whereNotIn('id',[1,2])->get();

        foreach ($sales as $sale){

            $payment = new App\Payment();
            $payment = $payment->create([
                'valor_pago'=> $sale->budget->total,
                'data_pagamento'=>$sale->data_venda,
                'venda_id'=>$sale->id
            ]);
            App\Financial::create([
                'tipo'=>'RECEITA',
                'descricao'=>'Pagamento de venda à vista.',
                'valor'=>$payment->valor_pago
            ]);
        }


        $installments = App\Installment::whereNotIn('id',[1,2])->get();
        $installarray = $installments->toArray();
        $quantidade_parcelas = count($installarray);
        $loopqtd = ceil($quantidade_parcelas/2);
        for($i = 0;$i < $loopqtd;$i++){
            $position = rand(0,$quantidade_parcelas-1);
            $installments[$position]->update([
                'status_parcela'=>'PAGO'
            ]);
        }
        $installments = App\Installment::where('status_parcela','PAGO')->whereNotIn('id',[1,2])->get();
        foreach($installments as $installment){
            $payment = new App\Payment();
            $payment = $payment->create([
                'valor_pago'=> $installment->valor_parcela,
                'data_pagamento'=>$installment->data_vencimento,
                'venda_id'=>$installment->venda_id
            ]);
            App\Financial::create([
                'tipo'=>'RECEITA',
                'descricao'=>'Parcelas pagas.',
                'valor'=>$payment->valor_pago
            ]);
        }

        $budgets = App\Budget::where('status','FINALIZADO')->whereNotIn('id',[1,2,3])->get();
        $totalOrdem = 0;

        foreach($budgets as $budget){
            $totalOrdem += $budget->total;
        }

        if(!empty($budgets)){
            $totalOrdem = number_format($totalOrdem, 2, '.', '');

            $order = factory(App\Order::class)->create([
                'nome'=> 'order com orçamentos finalizados',
                'situacao' => 'CONCLUIDA',
                'total'=> $totalOrdem
            ]);

            foreach ($budgets as $budget){
                $budget->update(['ordem_id'=>$order->id]);
            }

        }

        $budgets = App\Budget::where('status','APROVADO')->whereNotIn('id',[1,2,3])->get();
        foreach($budgets as $budget){

            $order = $budget->order()->first();
            if(!empty($order)){
                $order->update(['total'=>$budget->total]);
            }

        }

        $budgets = App\Budget::where('status','APROVADO')->whereNotIn('id',[1,2,3])->get();
        foreach($budgets as $budget){

            if($budget->sale->tipo_pagamento === 'A PRAZO'){
                $sale = $budget->sale()->with('installments')->first();
                $devendo = $sale->installments->where('status_parcela','ABERTO')->shift();
                if($devendo !== null){
                    $budget->client()->first()->update(['status'=>'DEVENDO']);
                }
            }

        }


        //FIM FACTORY

    }

    public function atualizaTotal()
    {

        $budgets = App\Budget::with('products')->whereNotIn('id',[1,2,3])->get();

        foreach ($budgets as $budgetcriado){


            $productsids = array();
            foreach ($budgetcriado->products as $product) {
                $productsids[] = $product->id;
            }
            $products = App\Product::with('glasses', 'aluminums', 'components')->wherein('id', $productsids)->get();

            $valorTotalDeProdutos = 0.0;
            foreach ($products as $product) {
                $resultVidro = 0.0;
                $m2 = $product['altura'] * $product['largura'] * $product['qtd'];
                $resultVidro += $m2 * $product->glasses()->sum('preco');

                $resultAluminio = 0.0;
                foreach ($product->aluminums()->get() as $aluminum) {
                    //LINHA ONDE O CALCULO ESTÁ SENDO FEITO DIFERENTE DO APP
                    $resultAluminio += $aluminum['peso'] * $aluminum['preco'] * $aluminum['qtd'];
                }

                $resultComponente = 0.0;
                foreach ($product->components()->get() as $component) {
                    $resultComponente += $component['preco'] * $component['qtd'];
                }

                $valorTotalDeProdutos += ($resultAluminio + $resultVidro + $resultComponente + $product['valor_mao_obra']);

            }

            $valorTotalDeProdutos *= (1 + $budgetcriado['margem_lucro'] / 100);

            $valorTotalDeProdutos = number_format($valorTotalDeProdutos, 2, '.', '');

            $budgetcriado->update(['total' => $valorTotalDeProdutos]);


        }

    }
}
