<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Array_;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Configuration;
use App\Location;
use App\Contact;
use Illuminate\Support\Collection;

class BudgetController extends Controller
{
    protected $states;
    protected $budget;

    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
        $this->states = Uf::getUfs();
    }

    public function index(Request $request)
    {
        if (!Auth::user()->can('orcamento_listar', Budget::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página'], 401);
        }

        $budgets = $this->budget->getWithSearchAndPagination($request->get('search'), false, false, false, true);

        $budgets = $this->mergeLocationAndContactToObjects($budgets);

        return response()->json(['budgets' => $budgets]);

    }

    
    public function create()
    {
        if (!Auth::user()->can('orcamento_adicionar', Budget::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página'], 401);
        }

        $clients = Client::getAllClients();

        $clients = $this->mergeLocationAndContactToObjects($clients);

        $mproducts = MProduct::getAllMProducts();
        $categories = Category::getAllCategories("produto");
        $categoriesmaterials = Category::getAllCategoriesMaterials();

        return response()->json(['clients' => $clients, 'mproducts' => $mproducts, 'categories' => $categories,'categoriesmaterials' => $categoriesmaterials], 200);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('orcamento_adicionar', Budget::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página'], 401);
        }

        $validado = $this->rules_budget($request->all());
        if ($validado->fails())
            return response()->json(['error' => $validado->messages()], 202);

        $configuration = Configuration::all()->first();

        $margemlucro = $request->margem_lucro ?? $configuration->porcent_m_lucro;
        $location = new Location();
        $location = $location->createLocation($request->all());
        $contact = new Contact();
        $contact = $contact->createContact($request->all());

        $budgetcriado = $this->budget->createBudget(array_merge($request->except('margem_lucro'), ['margem_lucro' => $margemlucro, 'status' => 'AGUARDANDO', 'total' => 0, 'usuario_id' => Auth::user()->id,'endereco_id'=>$location->id,'contato_id'=>$contact->id]));


        if ($budgetcriado){
            $budgetcriado = $this->mergeLocationAndContactToObject($budgetcriado);
            return response()->json(['success' => 'Orçamento criado com sucesso', 'budget' => $budgetcriado], 200);
        }


        return response()->json(['error' => 'Erro ao adicionar'], 202);
    }


    public function update(Request $request, $tab, $id)
    {
        if (!Auth::user()->can('orcamento_atualizar', Budget::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página'], 401);
        }

        $validado = $this->rules_budget_exists(['id' => $id]);

        if ($validado->fails()) {
            return response()->json(['error' => $validado->messages()], 202);
        }

        $budgetcriado = $this->budget->findBudgetById($id);

        if ($budgetcriado->status !== 'AGUARDANDO') {
            return response()->json(['error' => 'Este orçamento não pode ser editado!', 'res' => true], 202);


        }

        switch ($tab) {
            case '1': //tab orçamento
                $validado = $this->rules_budget($request->all());

                if ($validado->fails()) {
                    return response()->json(['error' => $validado->messages()], 202);
                }

                $configuration = Configuration::all()->first();

                $margemlucro = $request->margem_lucro ?? $configuration->porcent_m_lucro;

                $location = $budgetcriado->location()->first();
                $location->updateLocation($request->all());
                $contact = $budgetcriado->contact()->first();
                $contact->updateContact($request->all());

                $budgetcriado->updateBudget(array_merge($request->except('margem_lucro'), ['margem_lucro' => $margemlucro]));
                $budgetcriado->load('products.mproduct','products.glasses','products.aluminums','products.components');
                if ($budgetcriado && $budgetcriado->updateBudgetTotal()){
                    $budgetcriado = $this->mergeLocationAndContactToObject($budgetcriado);
                    return response()->json(['success' => 'Orçamento atualizado com sucesso', 'budget' => $budgetcriado], 200);
                }
                    
                break;
            case '2': //tab adicionar
                $validado = $this->rules_budget_product($request->all(), ['m_produto_id' => 'required|integer']);

                if ($validado->fails()) {
                    return response()->json(['error' => $validado->messages()], 202);
                }

                $product = new Product();
                $product = $product->createProduct(array_merge($request->all(), ['budget_id' => $id]));

                $product->createMaterialsOfMProductToProduct();

                if ($product) {
                    $budgetcriado->load('products.mproduct','products.glasses','products.aluminums','products.components');
                    
                    if ($budgetcriado && $budgetcriado->updateBudgetTotal()){
                        $budgetcriado = $this->mergeLocationAndContactToObject($budgetcriado);    
                        return response()->json(['success' => 'Produto adicionado ao orçamento com sucesso', 'budget' => $budgetcriado], 200);
                    }
                  
                }
                break;
            case '3': //tab editar
                $validado = $this->rules_budget_product_exists(['produtoid' => $request->get('produtoid')]);

                if (!$validado->fails()) {
                    $validado = $this->rules_budget_product($request->all(), []);
                }

                if ($validado->fails()) {
                    return response()->json(['error' => $validado->messages()], 202);
                }

                $product = new Product();
                $product = $product->findProductById($request->produtoid);
                $product->updateProduct($request->all());
                $product->updateAluminunsWithProductMeasure();

                $budgetcriado->load('products.mproduct','products.glasses','products.aluminums','products.components');

                if ($product && $budgetcriado->updateBudgetTotal()){
                    $budgetcriado = $this->mergeLocationAndContactToObject($budgetcriado);
                    return response()->json(['success' => 'Produto atualizado com sucesso', 'budget' => $budgetcriado], 200);    
                }
                    

                break;
            case '4': //tab material
                                
                $products = $budgetcriado->products;
                foreach ($products as $product) {
                    $returnId = $product->createMaterialsToProduct($request);
                    if($returnId != -1){
                        $id = $returnId;
                    }
                }

                $budgetcriado->load('products.mproduct','products.glasses','products.aluminums','products.components');
                if ($products && $budgetcriado->updateBudgetTotal()){
                    $budgetcriado = $this->mergeLocationAndContactToObject($budgetcriado);
                    return response()->json(['success' => 'Materiais dos produtos atualizados com sucesso', 'budget' => $budgetcriado], 200);
                }
                    
                break;
            default:
        }
        return response()->json(['error' => 'Erro ao atualizar'], 202);
    }

    public function destroy($del, $id)
    {
        if (!Auth::user()->can('orcamento_deletar', Budget::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página','res'=>true], 401);
        }

        if ($del == 'budget') {
            $budget = $this->budget->findBudgetById($id);
            if ($budget->status !== 'AGUARDANDO') {
                return response()->json(['error' => 'Este orçamento não pode ser deletado!','res'=>true], 202);
            }
            if ($budget) {

                $budget->deleteBudget();
                return response()->json(['success' => 'Orçamento deletado com sucesso', 'id' => $id], 200);
            } else {
                return response()->json(['error' => 'Erro ao deletar orçamento','res'=>true], 202);
            }
        } else {

            $product = Product::findProductsWithRelations([$id]);
            $product = $product->shift();

            if ($product) {
                $budgetcriado = $product->budget;

                if ($budgetcriado->status !== 'AGUARDANDO') {
                    return response()->json(['error' => 'Este orçamento não pode ser deletado!','res'=>true], 202);
                }

                $product->deleteProduct();

                $budgetcriado->load('products.mproduct','products.glasses','products.aluminums','products.components');
                if ($budgetcriado->updateBudgetTotal()) {
                    $budgetcriado = $this->mergeLocationAndContactToObject($budgetcriado);
                    return response()->json(['success' => 'Produto deletado com sucesso', 'budget' => $budgetcriado], 200);
                }
            } else {
                return response()->json(['error' => 'Erro ao deletar produto','res'=>true], 202);
            }

        }

    }


    public function updateMaterial(Request $request, $type, $id)
    {
        if (!Auth::user()->can('orcamento_atualizar', Budget::class)) {
            return response()->json(['error' => 'Você não tem permissão para acessar essa página'],401);
        }

        $validado = $this->rules_budget_materiais($request->all(), $type);
        if ($validado->fails()) {
            return response()->json(['error' => $validado->messages()], 202);
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
        }


        $validado = $this->rules_budget_material_exists(['id' => $id], $tabela);

        if ($validado->fails()) {
            return response()->json(['error' => $validado->messages()], 202);
        } else {
            if ($material->is_modelo === 1) {
                return response()->json(['error' => 'Este material não existe!','res'=>true], 202);
            }
        }

        $product = $material->product;
        $budget = $product->findProductById($product->id)->budget;

        if ($budget->status !== 'AGUARDANDO') {
            return response()->json(['error' => 'Este orçamento não pode ser deletado!','res'=>true],202);
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
        }
        $budget->load('products.mproduct','products.glasses','products.aluminums','products.components');
        if ($material) {

            if ($budget && $budget->updateBudgetTotal()) {
                $budget = $this->mergeLocationAndContactToObject($budget);
                return response()->json(['success' => "$nome atualizado com sucesso", 'budget'=>$budget],200);
            }


        }
        return response()->json(['error' => 'Erro ao editar material !','res'=>true],202);

    }


    public function mergeLocationAndContactToObjects($objects){
        
        return $objects->map(function($b){
            $location = $b->location()->first([
                'cep',
                'endereco',
                'bairro',
                'uf',
                'cidade',
                'complemento'
            ]);

            $contact = $b->contact()->first(['telefone','celular','email']);
           
            $b = array_merge($b->toArray(),$location->toArray(),$contact->toArray());
            
            return $b;
        });
    }

    public function mergeLocationAndContactToObject($object){
        
        $location = $object->location()->first([
                'cep',
                'endereco',
                'bairro',
                'uf',
                'cidade',
                'complemento'
        ]);

        $contact = $object->contact()->first(['telefone','celular','email']);
           
        $object = array_merge($object->toArray(),$location->toArray(),$contact->toArray());
        return $object;
        
    }


    public function rules_budget(array $data)
    {
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|min:10|max:255',
            'cep' => 'required|digits:8',
            'endereco' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => ['required',
                Rule::notIn('Selecionar')],
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
                'largura' => 'required|numeric|max:255',
                'altura' => 'required|numeric|max:255',
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
                'id' => 'exists:' . $tabela . ',id'
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
