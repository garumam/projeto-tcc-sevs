<?php

namespace App\Http\Controllers\Api;

use App\Budget;
use App\Client;
use App\Financial;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Installment;
use App\MProduct;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function products(Request $request){

        $request->merge(['ordenar'=>'DESC']);
        $mproducts = MProduct::filterMProducts($request);
        $mproducts = $mproducts->take(10);
        $nomes = [];
        $qtds = [];
        foreach($mproducts as $mproduct){
            $nomes[] = $mproduct->nome;
            $qtds[] = $mproduct->products->sum('qtd');
        }
        return response()->json(array('nomes' => $nomes, 'qtds' => $qtds));
    }

    public function sales()
    {
        $sales = DB::table('sales')->get();
        $salesArray = $this->getMonth($sales);

        return response()->json($salesArray);

    }

    function getMonth($objeto)
    {
        $meses = [];
        for ($i = 1; $i <= 12; $i++) {
            $meses[] = $objeto->filter(function ($value) use ($i) {

                $mes = substr($value->data_venda, 5, 2);

                if ($i < 10)
                    return $mes == '0' . $i;

                return $mes == $i;
            })->count();
        }
        return $meses;
    }

    public function financial()
    {

        $receitaperiodos = $despesasperiodos = null;

        $financials = Financial::getAllByStatus('CONFIRMADO');
        $this->getPeriods($financials,$receitaperiodos,$despesasperiodos,'financial');

        return response()->json(array('receitas' => $receitaperiodos, 'despesas' => $despesasperiodos));
    }

    public function futureFinancial(){

        $receitaperiodos = $despesasperiodos = null;

        $financials = Financial::getAllByStatus('PENDENTE');
        $installments = Installment::getPendingInstallmentsBySearch(null);
        foreach($installments as $installment){
            $financials->push($installment);
        }

        $this->getPeriods($financials,$receitaperiodos,$despesasperiodos,'futurefinancial');
        
        return response()->json(array('receitas' => $receitaperiodos, 'despesas' => $despesasperiodos));

    }


    public function orders()
    {

        $ordens = Order::where('situacao','CONCLUIDA')->orWhere('situacao','CANCELADA')->get();
        $ordermconcluida = $ordermcancelada = null;

        $this->getPeriods($ordens,$ordermconcluida,$ordermcancelada,'order');

        return response()->json(array('concluidas' => $ordermconcluida, 'canceladas' => $ordermcancelada));
    }

    public function clients()
    {
        $clients = Client::all();
        $clientesarray[] = $clients->where('status','=','EM DIA')->count();
        $clientesarray[] = $clients->where('status','=','DEVENDO')->count();

        return response()->json(array('clientes' => $clientesarray));
    }

    public function budgets()
    {
        $budgets = Budget::where('status','APROVADO')->orWhere('status','FINALIZADO')->get();
        $budgetsaprovado = $budgetsfinalizado = null;

        $this->getPeriods($budgets,$budgetsaprovado,$budgetsfinalizado,'budget');

        return response()->json(array('aprovados' => $budgetsaprovado, 'finalizados' => $budgetsfinalizado));
    }


    public function getPeriods($objects,&$firstArgument,&$secondArgument,$modelName){


        $periodos = ['anual','semestre','mes','semana','hoje'];
        if($modelName === 'futurefinancial'){
            $periodos = array_reverse($periodos);
            $sinal = '+';
        }else{
            $sinal = '-';
        }
        
        foreach($periodos as $value) {
            $data_inicial = $data_final = date_format(date_create(today()), 'Y-m-d');

            switch ($value){
                case 'hoje':
                    break;
                case 'semana':

                    $data_inicial = date('Y-m-d', strtotime($sinal."6 days", strtotime($data_inicial)));

                    break;
                case 'mes':

                    $data_inicial = date('Y-m-d', strtotime($sinal."29 days", strtotime($data_inicial)));

                    break;
                case 'semestre':

                    $data_inicial = date('Y-m-d', strtotime($sinal."179 days", strtotime($data_inicial)));

                    break;
                case 'anual':

                    $data_inicial = date('Y-m-d', strtotime($sinal."359 days", strtotime($data_inicial)));

                    break;
            }

            if($modelName === 'futurefinancial'){
                $aux = $data_final;
                $data_final = $data_inicial;
                $data_inicial = $aux;
            }


            $objectsfilter = $objects->filter(function ($object) use($data_inicial,$data_final,$modelName){
                if($modelName === 'order'){
                    $data = date_format(date_create($object->updated_at), 'Y-m-d');
                }elseif($modelName === 'financial' || $modelName === 'futurefinancial'){
                    
                    $data = $object->data_vencimento;
                    $data = date_format(date_create($data), 'Y-m-d');
                }elseif($modelName === 'budget'){
                    if($object->status === 'APROVADO'){
                        $sale = $object->sale;
                        if($sale)
                            $data = $sale->data_venda;
                    }else{
                        $data = $object->updated_at;
                    }

                    $data = date_format(date_create($data), 'Y-m-d');
                }

                return strtotime($data) >= strtotime($data_inicial) && strtotime($data) <= strtotime($data_final);
            });

            if($modelName === 'order'){
                $firstArgument[] = $objectsfilter->where('situacao','=','CONCLUIDA')->count();

                $secondArgument[] = $objectsfilter->where('situacao','=','CANCELADA')->count();
            }elseif($modelName === 'financial' || $modelName === 'futurefinancial'){
                
                $receitas =  $objectsfilter->where('tipo','=','RECEITA');
                $valor = $receitas->sum('valor');

                if($modelName === 'futurefinancial'){
                    $receitas = $objectsfilter->where('status_parcela','=','ABERTO');
                    $valor += $receitas->sum('valor_parcela');
                }

                $valor = number_format($valor,2,'.','');
                $firstArgument[] = (double)$valor;

                $despesas = $objectsfilter->where('tipo','=','DESPESA');
                $valor = $despesas->sum('valor');
                $valor = number_format($valor,2,'.','');
                $secondArgument[] = (double)$valor;
                

            }elseif($modelName === 'budget'){

                $firstArgument[] = $objectsfilter->where('status','=','APROVADO')->count();

                $secondArgument[] = $objectsfilter->where('status','=','FINALIZADO')->count();

            }


        }


    }
}
