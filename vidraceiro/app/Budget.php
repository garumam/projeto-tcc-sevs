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
        'cliente_id',
        'usuario_id'
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

    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
    }


    public function getWithSearchAndPagination($search, $paginate, $restore = false,$status = false, $api = false){

        $paginate = $paginate ?? 10;

        $queryBuilder = self::where(function ($query) use ($search){
            $query->where('nome', 'like', '%' . $search . '%');
            $query->orWhere('status', 'like', '%' . $search . '%');
            $query->orWhereHas('user',function ($q) use ($search){
                    $q->where('name','like','%' . $search . '%');
                });
        });

        if($restore){
            $queryBuilder = $queryBuilder->onlyTrashed();
        }
        if($status !== false){
            $queryBuilder = $queryBuilder->where('status', $status)->whereNull('ordem_id');
        }

        if($api)
            $queryBuilder = $queryBuilder->with('client','user','products.mproduct','Order');

        if($paginate === false)
            return $queryBuilder->get();

        return $queryBuilder->paginate($paginate);
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

    public function restoreBudgetById($id){

        $budget = self::onlyTrashed()->find($id);

        return $budget? $budget->restore(): false;
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

    public function getBudgetProductsWithRelations($id){

        return self::findBudgetById($id)->with('products','glasses', 'aluminums', 'components')->get();

    }

    public static function filterBudgets($request){

        $budgets = new Budget();
        $status = $request->status;
        $totalde = $request->total_de;
        $totalate = $request->total_ate;
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
            $budgets =  self::where(function ($query) use ($data_inicial,$data_final, $totalde,$totalate,$totalentrou,$dataentrou){
                if($dataentrou){
                    $query->where(function ($q) use ($data_inicial,$data_final){
                        if($data_final !== null)
                            $q->whereDate('data','<=',$data_final);

                        if($data_inicial !== null)
                            $q->whereDate('data','>=',$data_inicial);
                    });
                }

                if($totalentrou){
                    $query->where(function ($q) use ($totalde,$totalate){
                        if($totalate !== null)
                            $q->where('total','<=',$totalate);

                        if($totalde !== null)
                            $q->where('total','>=',$totalde);
                    });
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

    public function makeCopyWithWaitingState($user_id){


        $budgetcriado = $this->replicate();
        $budgetcriado->status = 'AGUARDANDO';
        $budgetcriado->ordem_id = null;
        $budgetcriado->usuario_id = $user_id;
        $budgetcriado->push();

        foreach ($this->products as $product){

            $productcriado = $product->replicate();
            $productcriado->budget_id = $budgetcriado->id;
            $productcriado->push();

            foreach ($product->glasses as $glass){
                $glasscriado = $glass->replicate();
                $glasscriado->product_id = $productcriado->id;
                $glasscriado->save();
            }

            foreach ($product->aluminums as $aluminum){
                $aluminumcriado = $aluminum->replicate();
                $aluminumcriado->product_id = $productcriado->id;
                $aluminumcriado->save();
            }

            foreach ($product->components as $component){
                $componentcriado = $component->replicate();
                $componentcriado->product_id = $productcriado->id;
                $componentcriado->save();
            }

        }

    }

}
