<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Budget extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'data',
        'status',
        'telefone',
        'cep',
        'endereco',
        'bairro',
        'uf',
        'cidade',
        'complemento',
        'total',
        'margem_lucro',
        'ordem_id',
        'cliente_id'
    ];

    public function products(){
        return $this->hasMany(
            Product::class,
            'budget_id'
        );
    }

    public function order(){
        return $this->belongsTo(Order::class,'ordem_id');
    }

    public function client(){
        return $this->belongsTo(Client::class,'cliente_id');
    }

    public function sale(){
        return $this->hasOne(Sale::class, 'orcamento_id');
    }


    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::where('nome', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->paginate($paginate);
    }

    public function createBudget(array $input){

        return self::create($input);

    }

    public function updateBudget(array $input){

        return self::update($input);

    }

    public function deleteBudget(){

        return self::delete();

    }

    public function findBudgetById($id){

        return self::find($id);

    }

    public static function getBudgetsWhereStatusWaiting(){

        return self::where('status', 'AGUARDANDO')->get();

    }

    public static function getBudgetsWhereStatusApproved($order_id){

        $budgetQuery = self::where('status', 'APROVADO')->where('ordem_id', null);

        if($order_id !== null){
            $budgetQuery = $budgetQuery->orWhere('ordem_id', $order_id);
        }
        return $budgetQuery->get();

    }

    public static function getBudgetsWhereIn(array $ids){

        return self::whereIn('id', $ids)->get();

    }

    public function getBudgetProductsWithRelations(){

        return self::products()->with('mproduct', 'glasses', 'aluminums', 'components')->get();

    }

    public static function filterBudgets($request){

        $budgets = new Budget();
        $status = $request->status;
        $totalde = $request->total_de;
        $totalate = $request->total_ate;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $totalentrou = $dataentrou = false;
        if($totalde < $totalate){
            $totalentrou = true;
        }
        if(strtotime($data_inicial) < strtotime($data_final)){
            $dataentrou = true;
        }

        if($totalentrou || $dataentrou){
            $budgets =  self::where(function ($query) use ($data_inicial,$data_final, $totalde,$totalate,$totalentrou,$dataentrou){
                if($dataentrou){
                    $query->whereBetween('data', [$data_inicial,$data_final]);
                }

                if($totalentrou){
                    $query->whereBetween('total', [$totalde,$totalate]);
                }
            });
        }

        if($status === 'TODOS'){
            $budgets = $budgets->get();
        }else{
            $budgets = $budgets->where('status',$status)->get();
        }
        return $budgets;
    }

    public function updateBudgetTotal()
    {

        $productsids = array();
        foreach ($this->products as $product) {
            $productsids[] = $product->id;
        }
        $products = Product::findProductsWithRelations($productsids);

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

        $valorTotalDeProdutos *= (1 + $this['margem_lucro'] / 100);

        $valorTotalDeProdutos = number_format($valorTotalDeProdutos, 2, '.', '');

        return self::update(['total' => $valorTotalDeProdutos]);

    }


}
