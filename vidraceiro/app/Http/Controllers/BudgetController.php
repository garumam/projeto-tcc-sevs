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
use App\Client;
use phpDocumentor\Reflection\Types\Array_;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    protected $states;
    protected $budget;
    public function __construct(Budget $budget)
    {
        $this->middleware('auth');

        $this->budget = $budget;
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

    //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO COMENTARIO NAS POSIÇÕES QUE PRECISA ALTERAR
    public function index(Request $request)
    {
        $budgets = $this->budget->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));
        if ($request->ajax()) {
            return view('dashboard.list.tables.table-budget', compact('budgets'));
        }

        return view('dashboard.list.budget', compact('budgets'))->with('title', 'Orçamentos');

    }

    public function create()
    {
        $states = $this->states;
        $aluminums = Aluminum::getAllAluminumsOrAllModels(1);
        $glasses = Glass::getAllGlassesOrAllModels(1);
        $components = Component::getAllComponentsOrAllModels(1);
        $categories = Category::getAllCategoriesByType('produto');
        $mproducts = MProduct::getAllMProducts();
        $clients = Client::getAllClients();

        $titulotabs = ['Orçamento', 'Adicionar', 'Editar', 'Material', 'Total'];

        return view('dashboard.create.budget', compact('titulotabs', 'states', 'glasses', 'aluminums', 'components', 'categories', 'mproducts', 'clients'))->with('title', 'Novo Orçamento');
    }

    public function store(Request $request, $tab)
    {
        switch ($tab) {
            case '1': //tab orçamento
                $validado = $this->rules_budget($request->all());
                if ($validado->fails())
                    return redirect()->back()->withErrors($validado);

                $margemlucro = $request->margem_lucro ?? 100;

                $budgetcriado = $this->budget->createBudget(array_merge($request->except('margem_lucro'), ['margem_lucro' => $margemlucro, 'status' => 'AGUARDANDO', 'total' => 0]));

                if ($budgetcriado)
                    return redirect()->back()->with('success', 'Orçamento criado com sucesso')
                        ->with(compact('budgetcriado'));
                break;
            case '2': //tab adicionar
                $validado = $this->rules_budget_product_add($request->all());

                if ($validado->fails()) {
                    $budgetcriado = $this->budget->findBudgetById($request->budget_id);
                    $products = $budgetcriado->products;

                    return redirect()->back()->withErrors($validado)
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }
                $product = new Product();
                $product = $product->createProduct($request->all());

                $product->createMaterialsOfMProductToProduct();

                if ($product) {
                    $budgetcriado = $this->budget->findBudgetById($request->budget_id);

                    if ($budgetcriado && $budgetcriado->updateBudgetTotal()) {
                        $products = $budgetcriado->products;

                        return redirect()->back()->with('success', 'Produto adicionado ao orçamento com sucesso')
                            ->with(compact('budgetcriado'))
                            ->with(compact('products'));
                    }
                }

                break;
            case '3': //tab editar

                $validado = $this->rules_budget_product_edit($request->all());

                if ($validado->fails()) {
                    $budgetcriado = $this->budget->findBudgetById($request->budget_id);
                    $products = $budgetcriado->products;
                    return redirect()->back()->withErrors($validado)
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }

                $product = new Product();
                $product = $product->findProductById($request->produtoid);
                $product->updateProduct($request->all());

                $product->updateAluminunsWithProductMeasure();

                $budgetcriado = $this->budget->findBudgetById($request->budget_id);
                if ($product && $budgetcriado->updateBudgetTotal()) {
                    $products = $budgetcriado->products;
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso')
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }
                break;
            case '4': //tab material
                $budgetcriado = $this->budget->findBudgetById($request->budget_id);
                $products = $budgetcriado->products;

                foreach ($products as $product) {

                    $product->createMaterialsToProduct($request);

                }

                if ($budgetcriado && $budgetcriado->updateBudgetTotal()) {

                    return redirect()->back()->with('success', 'Materiais dos produtos atualizados com sucesso')
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }
                break;
            default:
        }
        return redirect()->back()->with('error', "Erro ao adicionar");
    }

    public function show($id)
    {
        $validado = $this->rules_budget_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('budgets.index'))->withErrors($validado);
        }

        $budget = $this->budget->findBudgetById($id);
        return view('dashboard.show.budget', compact('budget'))->with('title', 'Informações do orçamento');
    }

    public function edit($id)
    {
        $validado = $this->rules_budget_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('budgets.index'))->withErrors($validado);
        }

        $states = $this->states;
        $aluminums = Aluminum::getAllAluminumsOrAllModels(1);
        $glasses = Glass::getAllGlassesOrAllModels(1);
        $components = Component::getAllComponentsOrAllModels(1);
        $categories = Category::getAllCategoriesByType('produto');
        $mproducts = MProduct::getAllMProducts();
        $clients = Client::getAllClients();
        $titulotabs = ['Orçamento', 'Adicionar', 'Editar', 'Material', 'Total'];

        $budgetedit = $this->budget->findBudgetById($id);

        if ($budgetedit) {
            $products = $budgetedit->getBudgetProductsWithRelations();

            return view('dashboard.create.budget', compact('titulotabs', 'states', 'glasses', 'aluminums', 'components', 'categories', 'mproducts', 'products', 'budgetedit', 'clients'))->with('title', 'Atualizar Orçamento');
        }
        return redirect('budgets')->with('error', 'Erro ao buscar orçamento');

    }


    public function update(Request $request, $tab, $id)
    {
        $validado = $this->rules_budget_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('budgets.index'))->withErrors($validado);
        }

        switch ($tab) {
            case '1': //tab orçamento

                $validado = $this->rules_budget($request->all());

                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $budgetcriado = $this->budget->findBudgetById($id);

                $margemlucro = $request->margem_lucro ?? 100;

                $budgetcriado->updateBudget(array_merge($request->except('margem_lucro'), ['margem_lucro' => $margemlucro]));
                if ($budgetcriado && $budgetcriado->updateBudgetTotal())
                    return redirect()->back()->with('success', 'Orçamento atualizado com sucesso');
                break;
            case '2': //tab adicionar
                $validado = $this->rules_budget_product_add($request->all());

                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }

                $product = new Product();
                $product = $product->createProduct(array_merge($request->all(), ['budget_id' => $id]));

                $product->createMaterialsOfMProductToProduct();

                if ($product) {
                    $budgetcriado = $this->budget->findBudgetById($id);

                    if ($budgetcriado && $budgetcriado->updateBudgetTotal())
                        return redirect()->back()->with('success', 'Produto adicionado ao orçamento com sucesso');
                }
                break;
            case '3': //tab editar
                $validado = $this->rules_budget_product_edit($request->all());

                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }

                $product = new Product();
                $product = $product->findProductById($request->produtoid);
                $product->updateProduct($request->all());

                $product->updateAluminunsWithProductMeasure();

                $budgetcriado = $this->budget->findBudgetById($id);
                if ($product && $budgetcriado->updateBudgetTotal())
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso');

                break;
            case '4': //tab material
                $budgetcriado = $this->budget->findBudgetById($id);
                $products = $budgetcriado->products;

                foreach ($products as $product) {

                    $product->createMaterialsToProduct($request);

                }

                if ($products && $budgetcriado->updateBudgetTotal())
                    return redirect()->back()->with('success', 'Materiais dos produtos atualizados com sucesso');
                break;
            default:
        }
        return redirect()->back()->with('error', "Erro ao atualizar");
    }

    public function destroy($del, $id)
    {
        if ($del == 'budget') {
            $budget = $this->budget->findBudgetById($id);
            if ($budget) {
                foreach ($budget->products as $product) {
                    $product->deleteProduct();
                }
                $this->budget->deleteBudget($budget->id);
                return redirect()->back()->with('success', 'Orçamento deletado com sucesso');
            } else {
                return redirect()->back()->with('error', 'Erro ao deletar orçamento');
            }
        } else {

            $product = Product::findProductsWithRelations([$id]);
            $product = $product->shift();

            if ($product) {
                $budgetcriado = $product->budget;

                $product->deleteProduct();

                $voltar = redirect()->back();
                if ($budgetcriado->updateBudgetTotal()) {
                    if (strpos($voltar->getTargetUrl(), 'create')) {
                        return redirect()->back()->with('success', 'Produto deletado com sucesso')
                            ->with(compact('budgetcriado'));
                    }
                    return redirect()->back()->with('success', 'Produto deletado com sucesso');
                }
            } else {
                return redirect()->back()->with('error', 'Erro ao deletar produto');
            }

        }

    }


    public function rules_budget(array $data)
    {
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|min:10|max:255',
            'cep' => 'required|string|min:8|max:8',
            'endereco' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'margem_lucro' => 'nullable|numeric|max:255'
        ]);

        return $validator;
    }

    public function rules_budget_product_add(array $data)
    {
        $validator = Validator::make($data, [
            'm_produto_id' => 'required|integer',
            'largura' => 'required|string|max:255',
            'altura' => 'required|string|max:255',
            'qtd' => 'required|integer',
            'localizacao' => 'nullable|string|max:255',
            'valor_mao_obra' => 'nullable|numeric'
        ]);

        return $validator;
    }

    public function rules_budget_product_edit(array $data)
    {
        $validator = Validator::make($data, [
            'produtoid' => 'required|integer|exists:products,id',
            'largura' => 'required|string|max:255',
            'altura' => 'required|string|max:255',
            'qtd' => 'required|integer',
            'localizacao' => 'nullable|string|max:255',
            'valor_mao_obra' => 'nullable|numeric'
        ], [
            'exists' => 'Este produto não existe!',
        ]);

        return $validator;
    }

    public function rules_budget_exists(array $data)
    {
        $validator = Validator::make($data,

            [
                'id' => 'exists:budgets,id'
            ], [
                'exists' => 'Este orçamento não existe!',
            ]

        );

        return $validator;
    }

}
