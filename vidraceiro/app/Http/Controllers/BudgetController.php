<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Budget;
use App\Aluminum;
use App\Product;
use App\MProduct;
use App\Component;
use App\Glass;
use App\Category;

class BudgetController extends Controller
{
    protected $states;
    public function __construct()
    {
        $this->middleware('auth');
        $this->states = $states = array(
            ' ' => 'Selecione...',
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins'
        );
    }

    public function index()
    {
        $budgets = Budget::all();
        return view('dashboard.list.budget', compact('budgets'))->with('title', 'Orçamentos');
    }

    public function create()
    {
        $states = $this->states;
        $aluminums = Aluminum::where('is_modelo', '1')->get();
        $glasses = Glass::where('is_modelo', '1')->get();
        $components = Component::where('is_modelo', '1')->get();
        $categories = Category::where('tipo', 'produto')->get();
        $mproducts = MProduct::all();
        $titulotabs = ['Orçamento','Editar','Adicionar','Material','Total'];
        //dd($mproducts);
        return view('dashboard.create.budget',compact('titulotabs','states','glasses','aluminums','components','categories','mproducts'))->with('title', 'Novo Orçamento');
    }

    public function store(Request $request, $tab)
    {
        switch ($tab) {
            case '1': //tab orçamento

                $budgetcriado = new Budget;
                $budgetcriado = $budgetcriado->create($request->all());

                if ($budgetcriado)
                    return redirect()->back()->with('success', 'Orçamento criado com sucesso')
                        ->with(compact('budgetcriado'));
                break;
            case '2': //tab editar
                $budgetcriado = Budget::find($request->budgetid);
                $product = Product::find($request->produtoid);
                $product->update($request->except(['produtoid','budgetid']));

                if($product && $budgetcriado){
                    $products = $budgetcriado->products;
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso')
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }

                break;
            case '3': //tab adicionar

                $product = new Product();
                $product = $product->create($request->except('budgetid'));
                if ($product){
                    $budgetcriado = Budget::find($request->budgetid);
                    $budgetcriado->products()->attach($product->id);
                    if ($budgetcriado){

                        $products = $budgetcriado->products;

                        return redirect()->back()->with('success', 'Produto adicionado ao orçamento com sucesso')
                            ->with(compact('budgetcriado'))
                            ->with(compact('products'));
                    }

                }

                break;
            case '4': //tab material


                break;
            case '5': //tab total


                break;
            default:
        }
    }

    public function show()
    {

    }

    public function edit($id)
    {
        $states = $this->states;
        $aluminums = Aluminum::where('is_modelo', '1')->get();
        $glasses = Glass::where('is_modelo', '1')->get();
        $components = Component::where('is_modelo', '1')->get();
        $categories = Category::where('tipo', 'produto')->get();
        $mproducts = MProduct::all();
        $titulotabs = ['Orçamento','Editar','Adicionar','Material','Total'];

        $budgetedit = Budget::with('products')->find($id);
        if($budgetedit){
            $products = $budgetedit->products()->with('mproduct')->get();
            return view('dashboard.create.budget',compact('titulotabs','states','glasses','aluminums','components','categories','mproducts','products','budgetedit'))->with('title', 'Atualizar Orçamento');
        }
        return redirect('products')->with('error', 'Erro ao buscar produto');

    }


    public function update(Request $request,$tab,$id)
    {
        switch ($tab) {
            case '1': //tab orçamento

                $budgetcriado = Budget::find($id);
                $budgetcriado = $budgetcriado->update($request->all());

                if ($budgetcriado)
                    return redirect()->back()->with('success', 'Orçamento atualizado com sucesso');
                break;
            case '2': //tab editar

                $product = Product::find($request->produtoid);
                $product->update($request->except(['produtoid']));

                if($product)
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso');

                break;
            case '3': //tab adicionar

                $product = new Product();
                $product = $product->create($request->all());
                if ($product){
                    $budgetcriado = Budget::find($id);
                    $budgetcriado->products()->attach($product->id);
                    if ($budgetcriado)
                        return redirect()->back()->with('success', 'Produto adicionado ao orçamento com sucesso');

                }

                break;
            case '4': //tab material


                break;
            case '5': //tab total


                break;
            default:
        }
    }

    public function destroy($id)
    {
        $budget = Budget::find($id);
        if ($budget) {
            $budget->delete();
            return redirect()->back()->with('success', 'Orçamento deletado com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar orçamento');
        }
    }
}
