<?php

namespace App\Http\Controllers;

use App\Uf;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    protected $states;
    protected $budget;
    public function __construct(Budget $budget)
    {
        $this->middleware('auth');

        $this->budget = $budget;
        $this->states = Uf::getUfs();
    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('orcamento_listar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $budgets = $this->budget->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));
        if ($request->ajax()) {
            return view('dashboard.list.tables.table-budget', compact('budgets'));
        }

        return view('dashboard.list.budget', compact('budgets'))->with('title', 'Orçamentos');

    }

    public function create(Request $request)
    {
        if(!Auth::user()->can('orcamento_adicionar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $states = $this->states;
        $clients = Client::getAllClients();

        $titulotabs = ['Orçamento', 'Adicionar', 'Editar', 'Material', 'Total'];

        $budgetid = $request->id ?? null;

        if ($budgetid != null){
            $budget = new Budget();
            $budget = $budget->findBudgetById($budgetid);
            if($budget){
                $budget->makeCopyWithWaitingState(Auth::user()->id);
                return redirect(route('budgets.index'))->with('success','Orçamento copiado com sucesso!');
            }
            return redirect(route('budgets.index'))->with('error','Não foi possível realizar a cópia');

        }

        return view('dashboard.create.budget', compact('titulotabs', 'states', 'clients','budgetedit'))->with('title', 'Novo Orçamento');
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('orcamento_adicionar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_budget($request->all());
        if ($validado->fails())
            return redirect()->back()->withErrors($validado);

        $margemlucro = $request->margem_lucro ?? 100;

        $budgetcriado = $this->budget->createBudget(array_merge($request->except('margem_lucro'), ['margem_lucro' => $margemlucro, 'status' => 'AGUARDANDO', 'total' => 0,'usuario_id'=>Auth::user()->id]));

        if ($budgetcriado)
            return redirect()->route('budgets.edit',['id'=>$budgetcriado->id])->with('success', 'Orçamento criado com sucesso');


        return redirect()->back()->with('error', "Erro ao adicionar");
    }

    public function show($id)
    {
        if(!Auth::user()->can('orcamento_listar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_budget_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('budgets.index'))->withErrors($validado);
        }

        $budget = $this->budget->findBudgetById($id);
        return view('dashboard.show.budget', compact('budget'))->with('title', 'Informações do orçamento');
    }

    public function edit($id)
    {
        if(!Auth::user()->can('orcamento_atualizar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_budget_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('budgets.index'))->withErrors($validado);
        }

        $budgetedit = $this->budget->findBudgetById($id);

        if($budgetedit->status !== 'AGUARDANDO'){
            return redirect(route('budgets.index'))->with('error','Este orçamento não pode ser editado!');
        }

        $states = $this->states;
        $aluminums = Aluminum::getAllAluminumsOrAllModels(1);
        $glasses = Glass::getAllGlassesOrAllModels(1);
        $components = Component::getAllComponentsOrAllModels(1);
        $categories = Category::getAllCategoriesByType('produto');
        $mproducts = MProduct::getAllMProducts();
        $clients = Client::getAllClients();
        $titulotabs = ['Orçamento', 'Adicionar', 'Editar', 'Material', 'Total'];


        if ($budgetedit) {
            $products = $budgetedit->getBudgetProductsWithRelations();

            return view('dashboard.create.budget', compact('titulotabs', 'states', 'glasses', 'aluminums', 'components', 'categories', 'mproducts', 'products', 'budgetedit', 'clients'))->with('title', 'Atualizar Orçamento');
        }
        return redirect('budgets')->with('error', 'Erro ao buscar orçamento');

    }


    public function update(Request $request, $tab, $id)
    {
        if(!Auth::user()->can('orcamento_atualizar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_budget_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('budgets.index'))->withErrors($validado);
        }

        $budgetcriado = $this->budget->findBudgetById($id);

        if($budgetcriado->status !== 'AGUARDANDO'){
            return redirect(route('budgets.index'))->with('error','Este orçamento não pode ser editado!');
        }

        switch ($tab) {
            case '1': //tab orçamento

                $validado = $this->rules_budget($request->all());

                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }

                $margemlucro = $request->margem_lucro ?? 100;

                $budgetcriado->updateBudget(array_merge($request->except('margem_lucro'), ['margem_lucro' => $margemlucro]));
                if ($budgetcriado && $budgetcriado->updateBudgetTotal())
                    return redirect()->back()->with('success', 'Orçamento atualizado com sucesso');
                break;
            case '2': //tab adicionar
                $validado = $this->rules_budget_product($request->all(),['m_produto_id' => 'required|integer']);

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
                $validado = $this->rules_budget_product_exists(['produtoid'=>$request->get('produtoid')]);

                if(!$validado->fails()){
                    $validado = $this->rules_budget_product($request->all(),[]);
                }

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
        if(!Auth::user()->can('orcamento_deletar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        if ($del == 'budget') {
            $budget = $this->budget->findBudgetById($id);
            if($budget->status !== 'AGUARDANDO'){
                return redirect(route('budgets.index'))->with('error','Este orçamento não pode ser deletado!');
            }
            if ($budget) {

                $budget->deleteBudget();
                return redirect()->back()->with('success', 'Orçamento deletado com sucesso');
            } else {
                return redirect()->back()->with('error', 'Erro ao deletar orçamento');
            }
        } else {

            $product = Product::findProductsWithRelations([$id]);
            $product = $product->shift();

            if ($product) {
                $budgetcriado = $product->budget;

                if($budgetcriado->status !== 'AGUARDANDO'){
                    return redirect(route('budgets.index'))->with('error','Este orçamento não pode ser editado!');
                }

                $product->deleteProduct();


                if ($budgetcriado->updateBudgetTotal()) {
                    return redirect()->back()->with('success', 'Produto deletado com sucesso');
                }
            } else {
                return redirect()->back()->with('error', 'Erro ao deletar produto');
            }

        }

    }


    public function editMaterial($type,$id)
    {
        if(!Auth::user()->can('orcamento_atualizar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        switch ($type) {
            case 'glass':
                $glass = new Glass();
                $material = $glass->findGlassById($id);

                $nome = 'vidro';
                $tabela = 'glasses';
                break;
            case 'aluminum':
                $aluminum = new Aluminum();
                $material = $aluminum->findAluminumById($id);

                $nome = 'alumínio';
                $tabela = 'aluminums';
                break;
            case 'component':
                $component = new Component();
                $material = $component->findComponentById($id);

                $nome = 'componente';
                $tabela = 'components';
                break;
            default:
                return redirect()->back();
        }

        $validado = $this->rules_budget_material_exists(['id'=>$id],$tabela);

        if ($validado->fails()) {
            return redirect(route('budgets.index'))->withErrors($validado);
        }else{
            if($material->is_modelo === 1) {
                return redirect(route('budgets.index'))->with('error', 'Este material não existe!');
            }
        }


        if ($material) {

            return view('dashboard.create.budget-material', compact('type', 'material'))->with('title', 'Atualizar ' . $nome);
        }
        return redirect('budgets')->with('error', 'Erro ao editar material');

    }

    public function updateMaterial(Request $request, $type,$id)
    {
        if(!Auth::user()->can('orcamento_atualizar', Budget::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_budget_materiais($request->all(), $type);
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $tabela = '';
        switch ($type) {
            case 'glass':

                $glass = new Glass();
                $material = $glass->findGlassById($id);
                $nome = 'Vidro';
                $tabela = 'glasses';

                break;
            case 'aluminum':

                $aluminum = new Aluminum();
                $material = $aluminum->findAluminumById($id);
                $nome = 'Alumínio';
                $tabela = 'aluminums';

                break;
            case 'component':

                $component = new Component();
                $material = $component->findComponentById($id);
                $nome = 'Componente';
                $tabela = 'components';

                break;
            default:
                return redirect()->back();
        }


        $validado = $this->rules_budget_material_exists(['id'=>$id],$tabela);

        if ($validado->fails()) {
            return redirect(route('budgets.index'))->withErrors($validado);
        }else{
            if($material->is_modelo === 1) {
                return redirect(route('budgets.index'))->with('error', 'Este material não existe!');
            }
        }

        $product = $material->product;
        $budget = $product->findProductById($product->id)->budget;

        if($budget->status !== 'AGUARDANDO'){
            return redirect(route('budgets.index'))->with('error','Este orçamento não pode ser editado!');
        }

        switch ($type) {
            case 'glass':

                $material->updateGlass($request->all());

                break;
            case 'aluminum':

                $material->updateAluminum($request->all());

                break;
            case 'component':

                $material->updateComponent($request->all());

                break;
            default:
                return redirect()->back();
        }

        if ($material){

            if($budget && $budget->updateBudgetTotal()){

                return redirect(route('budgets.edit',['id'=>$budget->id]))->with('success', "$nome atualizado com sucesso");
            }


        }

        return redirect(route('budgets.index'))->with('error', 'Erro!');

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

    public function rules_budget_product(array $data, array $mproductValidation)
    {
        $validator = Validator::make($data, array_merge(
            $mproductValidation,
            [
                'largura' => 'required|string|max:255',
                'altura' => 'required|string|max:255',
                'qtd' => 'required|integer',
                'localizacao' => 'nullable|string|max:255',
                'valor_mao_obra' => 'nullable|numeric'
            ]
        ));

        return $validator;
    }

    public function rules_budget_product_exists(array $data)
    {
        $validator = Validator::make($data, [
            'produtoid' => 'required|integer|exists:products,id'
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

    public function rules_budget_material_exists(array $data, $tabela)
    {

        $validator = Validator::make($data,

            [
                'id' => 'exists:'.$tabela.',id'
            ], [
                'exists' => 'Este material não existe!',
            ]

        );

        return $validator;
    }

    public function rules_budget_materiais(array $data, $type)
    {
        switch ($type) {
            case 'glass':
                $validator = Validator::make($data, [
                    'preco' => 'nullable|numeric'
                ]);
                break;
            case 'component':
            case 'aluminum':
                $validator = Validator::make($data, [
                    'qtd' => 'required|integer',
                    'preco' => 'nullable|numeric'
                ]);
                break;

        }

        return $validator;
    }

}
