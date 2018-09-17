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

    //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO COMENTARIO NAS POSIÇÕES QUE PRECISA ALTERAR
    public function index(Request $request)
    {
        $paginate = 10;
        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        }
        $budgets = Budget::where('nome', 'like', '%' . $request->get('search') . '%')
            ->orWhere('status', 'like', '%' . $request->get('search') . '%')
//            ->orderBy($request->get('field'), $request->get('sort'))
            ->paginate($paginate);
        if ($request->ajax()) {
            return view('dashboard.list.tables.table-budget', compact('budgets'));
        } else {
            return view('dashboard.list.budget', compact('budgets'))->with('title', 'Orçamentos');
        }
    }

    public function create()
    {
        $states = $this->states;
        $aluminums = Aluminum::where('is_modelo', '1')->get();
        $glasses = Glass::where('is_modelo', '1')->get();
        $components = Component::where('is_modelo', '1')->get();
        $categories = Category::where('tipo', 'produto')->get();
        $mproducts = MProduct::all();
        $clients = Client::all();
        $titulotabs = ['Orçamento', 'Adicionar', 'Editar', 'Material', 'Total'];
        //dd($mproducts);
        return view('dashboard.create.budget', compact('titulotabs', 'states', 'glasses', 'aluminums', 'components', 'categories', 'mproducts', 'clients'))->with('title', 'Novo Orçamento');
    }

    public function store(Request $request, $tab)
    {
        switch ($tab) {
            case '1': //tab orçamento
                $validado = $this->rules_budget($request->all());
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $budgetcriado = new Budget;

                $margemlucro = $request->margem_lucro === null ? 100 : $request->margem_lucro;
                $budgetcriado = $budgetcriado->create(array_merge($request->except('margem_lucro'), ['margem_lucro' => $margemlucro, 'status' => 'AGUARDANDO', 'total' => 0]));
                if ($budgetcriado)
                    return redirect()->back()->with('success', 'Orçamento criado com sucesso')
                        ->with(compact('budgetcriado'));
                break;
            case '2': //tab adicionar
                $validado = $this->rules_budget_product_add($request->all());

                if ($validado->fails()) {
                    $budgetcriado = Budget::find($request->budget_id);
                    $products = $budgetcriado->products;
                    return redirect()->back()->withErrors($validado)
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }
                $product = new Product();
                $product = $product->create($request->all());
                $mproduct = MProduct::with('glasses', 'aluminums', 'components')->find($product->m_produto_id);

                foreach ($mproduct->glasses()->get() as $vidro) {
                    Glass::create([
                        'nome' => $vidro->nome,
                        'cor' => $vidro->cor,
                        'tipo' => $vidro->tipo,
                        'espessura' => $vidro->espessura,
                        'preco' => $vidro->preco,
                        'product_id' => $product->id,
                        'categoria_vidro_id' => $vidro->categoria_vidro_id,
                        'is_modelo' => 0,
                        'mglass_id' => $vidro->id
                    ]);

                }

                foreach ($mproduct->aluminums()->get() as $aluminio) {
                    //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO
                    $aluminioMedida = $aluminio->tipo_medida === 'largura' ? $product->largura :
                        ($aluminio->tipo_medida === 'altura' ? $product->altura : $aluminio->medida);
                    $aluminioPeso = ($aluminio->peso / $aluminio->medida) * $aluminioMedida;
                    $aluminioPeso = number_format($aluminioPeso, 3, '.', '');

                    Aluminum::create([
                        'perfil' => $aluminio->perfil,
                        'descricao' => $aluminio->descricao,
                        'medida' => $aluminioMedida,
                        'qtd' => $aluminio->qtd,
                        'peso' => $aluminioPeso,
                        'preco' => $aluminio->preco,
                        'tipo_medida' => $aluminio->tipo_medida,
                        'is_modelo' => 0,
                        'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,
                        'product_id' => $product->id,
                        'maluminum_id' => $aluminio->id

                    ]);

                }

                foreach ($mproduct->components()->get() as $componente) {
                    Component::create([
                        'nome' => $componente->nome,
                        'qtd' => $componente->qtd,
                        'preco' => $componente->preco,
                        'is_modelo' => 0,
                        'categoria_componente_id' => $componente->categoria_componente_id,
                        'product_id' => $product->id,
                        'mcomponent_id' => $componente->id

                    ]);

                }

                if ($product) {
                    $budgetcriado = Budget::find($request->budget_id);
                    //$budgetcriado->products()->attach($product->id);
                    if ($budgetcriado && self::atualizaTotal(null, $budgetcriado)) {
                        $products = $budgetcriado->products;
                        //$budgetcriado = Budget::find($request->budgetid);
                        return redirect()->back()->with('success', 'Produto adicionado ao orçamento com sucesso')
                            ->with(compact('budgetcriado'))
                            ->with(compact('products'));
                    }
                }

                break;
            case '3': //tab editar

                $validado = $this->rules_budget_product_edit($request->all());

                if ($validado->fails()) {
                    $budgetcriado = Budget::find($request->budget_id);
                    $products = $budgetcriado->products;
                    return redirect()->back()->withErrors($validado)
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }

                $product = Product::find($request->produtoid);
                $product->update($request->except(['produtoid']));

                foreach ($product->aluminums()->get() as $aluminio) {
                    //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO
                    $aluminioMedida = $aluminio->tipo_medida === 'largura' ? $product->largura :
                        ($aluminio->tipo_medida === 'altura' ? $product->altura : $aluminio->medida);
                    $aluminioPeso = ($aluminio->peso / $aluminio->medida) * $aluminioMedida;
                    $aluminioPeso = number_format($aluminioPeso, 3, '.', '');

                    $aluminio->update([
                        'medida' => $aluminioMedida,
                        'peso' => $aluminioPeso
                    ]);
                }

                $budgetcriado = Budget::find($request->budget_id);
                if ($product && self::atualizaTotal(null, $budgetcriado)) {
                    $products = $budgetcriado->products;
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso')
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }
                break;
            case '4': //tab material
                $budgetcriado = Budget::with('products')->find($request->budget_id);
                $products = $budgetcriado->products;

                foreach ($products as $product) {
                    $glass = 'id_vidro_' . $product->id;
                    $aluminum = 'id_aluminio_' . $product->id;
                    $component = 'id_componente_' . $product->id;
                    $vidrosProduto = $product->glasses();
                    $aluminiosProduto = $product->aluminums();
                    $componentesProduto = $product->components();

                    if ($request->has($glass)) {
                        $glassesAll = Glass::wherein('id', $request->$glass)->get();
                        $vidrosProduto->whereNotIn('id', $request->$glass)->delete();

                        foreach ($request->$glass as $id) {

                            $vidro = $glassesAll->where('id', $id)->shift();

                            if ($vidro->is_modelo == 1) {
                                Glass::create([
                                    'nome' => $vidro->nome,
                                    'cor' => $vidro->cor,
                                    'tipo' => $vidro->tipo,
                                    'espessura' => $vidro->espessura,
                                    'preco' => $vidro->preco,
                                    'product_id' => $product->id,
                                    'categoria_vidro_id' => $vidro->categoria_vidro_id,
                                    'is_modelo' => 0,
                                    'mglass_id' => $vidro->id
                                ]);

                            }
                        }

                    } else {

                        $vidrosProduto->delete();

                    }

                    if ($request->has($aluminum)) {

                        $aluminumsAll = Aluminum::wherein('id', $request->$aluminum)->get();
                        $aluminiosProduto->whereNotIn('id', $request->$aluminum)->delete();

                        foreach ($request->$aluminum as $id) {

                            $aluminio = $aluminumsAll->where('id', $id)->shift();

                            if ($aluminio->is_modelo == 1) {
                                //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO
                                $aluminioMedida = $aluminio->tipo_medida === 'largura' ? $product->largura :
                                    ($aluminio->tipo_medida === 'altura' ? $product->altura : $aluminio->medida);
                                $aluminioPeso = ($aluminio->peso / $aluminio->medida) * $aluminioMedida;
                                $aluminioPeso = number_format($aluminioPeso, 3, '.', '');

                                Aluminum::create([
                                    'perfil' => $aluminio->perfil,
                                    'descricao' => $aluminio->descricao,
                                    'medida' => $aluminioMedida,
                                    'qtd' => $aluminio->qtd,
                                    'peso' => $aluminioPeso,
                                    'preco' => $aluminio->preco,
                                    'tipo_medida' => $aluminio->tipo_medida,
                                    'is_modelo' => 0,
                                    'product_id' => $product->id,
                                    'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,
                                    'maluminum_id' => $aluminio->id
                                ]);

                            }
                        }

                    } else {

                        $aluminiosProduto->delete();

                    }


                    if ($request->has($component)) {
                        $componentsAll = Component::wherein('id', $request->$component)->get();
                        $componentesProduto->whereNotIn('id', $request->$component)->delete();

                        foreach ($request->$component as $id) {

                            $componente = $componentsAll->where('id', $id)->shift();

                            if ($componente->is_modelo == 1) {

                                Component::create([
                                    'nome' => $componente->nome,
                                    'qtd' => $componente->qtd,
                                    'preco' => $componente->preco,
                                    'is_modelo' => 0,
                                    'product_id' => $product->id,
                                    'categoria_componente_id' => $componente->categoria_componente_id,
                                    'mcomponent_id' => $componente->id
                                ]);

                            }
                        }

                    } else {

                        $componentesProduto->delete();

                    }

                }

                if ($budgetcriado && self::atualizaTotal(null, $budgetcriado)) {
                    $budgetcriado = Budget::with('products')->find($request->budget_id);
                    return redirect()->back()->with('success', 'Materiais dos produtos atualizados com sucesso')
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }
                break;
            case '5': //tab total


                break;
            default:
        }
        return redirect()->back()->with('error', "Erro ao adicionar");
    }

    public function show($id)
    {
        $budget = Budget::find($id);
        return view('dashboard.show.budget', compact('budget'))->with('title', 'Informações do orçamento');
    }

    public function edit($id)
    {
        $states = $this->states;
        $aluminums = Aluminum::where('is_modelo', '1')->get();
        $glasses = Glass::where('is_modelo', '1')->get();
        $components = Component::where('is_modelo', '1')->get();
        $categories = Category::where('tipo', 'produto')->get();
        $mproducts = MProduct::all();
        $clients = Client::all();
        $titulotabs = ['Orçamento', 'Adicionar', 'Editar', 'Material', 'Total'];

        $budgetedit = Budget::with('products')->find($id);
        if ($budgetedit) {
            $products = $budgetedit->products()->with('mproduct', 'glasses', 'aluminums', 'components')->get();

            return view('dashboard.create.budget', compact('titulotabs', 'states', 'glasses', 'aluminums', 'components', 'categories', 'mproducts', 'products', 'budgetedit', 'clients'))->with('title', 'Atualizar Orçamento');
        }
        return redirect('products')->with('error', 'Erro ao buscar produto');

    }


    public function update(Request $request, $tab, $id)
    {
        switch ($tab) {
            case '1': //tab orçamento
                $validado = $this->rules_budget($request->all());

                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $budgetcriado = Budget::find($id);
                $margemlucro = $request->margem_lucro === null ? 100 : $request->margem_lucro;
                $budgetcriado->update(array_merge($request->except('margem_lucro'), ['margem_lucro' => $margemlucro]));
                if ($budgetcriado && self::atualizaTotal(null, $budgetcriado))
                    return redirect()->back()->with('success', 'Orçamento atualizado com sucesso');
                break;
            case '2': //tab adicionar
                $validado = $this->rules_budget_product_add($request->all());

                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $product = new Product();
                $product = $product->create(array_merge($request->all(), ['budget_id' => $id]));
                $mproduct = MProduct::with('glasses', 'aluminums', 'components')->find($product->m_produto_id);

                foreach ($mproduct->glasses()->get() as $vidro) {
                    Glass::create([
                        'nome' => $vidro->nome,
                        'cor' => $vidro->cor,
                        'tipo' => $vidro->tipo,
                        'espessura' => $vidro->espessura,
                        'preco' => $vidro->preco,
                        'product_id' => $product->id,
                        'categoria_vidro_id' => $vidro->categoria_vidro_id,
                        'is_modelo' => 0,
                        'mglass_id' => $vidro->id
                    ]);

                }

                foreach ($mproduct->aluminums()->get() as $aluminio) {
                    //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO
                    $aluminioMedida = $aluminio->tipo_medida === 'largura' ? $product->largura :
                        ($aluminio->tipo_medida === 'altura' ? $product->altura : $aluminio->medida);
                    $aluminioPeso = ($aluminio->peso / $aluminio->medida) * $aluminioMedida;
                    $aluminioPeso = number_format($aluminioPeso, 3, '.', '');

                    Aluminum::create([
                        'perfil' => $aluminio->perfil,
                        'descricao' => $aluminio->descricao,
                        'medida' => $aluminioMedida,
                        'qtd' => $aluminio->qtd,
                        'peso' => $aluminioPeso,
                        'preco' => $aluminio->preco,
                        'tipo_medida' => $aluminio->tipo_medida,
                        'is_modelo' => 0,
                        'product_id' => $product->id,
                        'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,
                        'maluminum_id' => $aluminio->id
                    ]);
                }

                foreach ($mproduct->components()->get() as $componente) {
                    Component::create([
                        'nome' => $componente->nome,
                        'qtd' => $componente->qtd,
                        'preco' => $componente->preco,
                        'is_modelo' => 0,
                        'product_id' => $product->id,
                        'categoria_componente_id' => $componente->categoria_componente_id,
                        'mcomponent_id' => $componente->id
                    ]);
                }
                if ($product) {
                    $budgetcriado = Budget::find($id);
                    //$budgetcriado->products()->attach($product->id);
                    if ($budgetcriado && self::atualizaTotal(null, $budgetcriado))
                        return redirect()->back()->with('success', 'Produto adicionado ao orçamento com sucesso');
                }
                break;
            case '3': //tab editar
                $validado = $this->rules_budget_product_edit($request->all());

                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $product = Product::find($request->produtoid);
                $product->update($request->except(['produtoid']));

                foreach ($product->aluminums()->get() as $aluminio) {
                    //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO
                    $aluminioMedida = $aluminio->tipo_medida === 'largura' ? $product->largura :
                        ($aluminio->tipo_medida === 'altura' ? $product->altura : $aluminio->medida);
                    $aluminioPeso = ($aluminio->peso / $aluminio->medida) * $aluminioMedida;
                    $aluminioPeso = number_format($aluminioPeso, 3, '.', '');

                    $aluminio->update([
                        'medida' => $aluminioMedida,
                        'peso' => $aluminioPeso
                    ]);
                }

                if ($product && self::atualizaTotal($id, null))
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso');

                break;
            case '4': //tab material
                $budgetcriado = Budget::with('products')->find($id);
                $products = $budgetcriado->products;

                foreach ($products as $product) {
                    $glass = 'id_vidro_' . $product->id;
                    $aluminum = 'id_aluminio_' . $product->id;
                    $component = 'id_componente_' . $product->id;
                    $vidrosProduto = $product->glasses();
                    $aluminiosProduto = $product->aluminums();
                    $componentesProduto = $product->components();

                    if ($request->has($glass)) {
                        $glassesAll = Glass::wherein('id', $request->$glass)->get();
                        $vidrosProduto->whereNotIn('id', $request->$glass)->delete();

                        foreach ($request->$glass as $id) {

                            $vidro = $glassesAll->where('id', $id)->shift();

                            if ($vidro->is_modelo == 1) {

                                Glass::create([
                                    'nome' => $vidro->nome,
                                    'cor' => $vidro->cor,
                                    'tipo' => $vidro->tipo,
                                    'espessura' => $vidro->espessura,
                                    'preco' => $vidro->preco,
                                    'categoria_vidro_id' => $vidro->categoria_vidro_id,
                                    'product_id' => $product->id,
                                    'is_modelo' => 0,
                                    'mglass_id' => $vidro->id
                                ]);

                            }
                        }


                    } else {

                        $vidrosProduto->delete();

                    }

                    if ($request->has($aluminum)) {

                        $aluminumsAll = Aluminum::wherein('id', $request->$aluminum)->get();
                        $aluminiosProduto->whereNotIn('id', $request->$aluminum)->delete();

                        foreach ($request->$aluminum as $id) {

                            $aluminio = $aluminumsAll->where('id', $id)->shift();

                            if ($aluminio->is_modelo == 1) {
                                //FALTA GERAR A MEDIDA PARA TIPO M LINEAR PORTÃO
                                $aluminioMedida = $aluminio->tipo_medida === 'largura' ? $product->largura :
                                    ($aluminio->tipo_medida === 'altura' ? $product->altura : $aluminio->medida);
                                $aluminioPeso = ($aluminio->peso / $aluminio->medida) * $aluminioMedida;
                                $aluminioPeso = number_format($aluminioPeso, 3, '.', '');
                                Aluminum::create([
                                    'perfil' => $aluminio->perfil,
                                    'descricao' => $aluminio->descricao,
                                    'medida' => $aluminioMedida,
                                    'qtd' => $aluminio->qtd,
                                    'peso' => $aluminioPeso,
                                    'preco' => $aluminio->preco,
                                    'tipo_medida' => $aluminio->tipo_medida,
                                    'is_modelo' => 0,
                                    'product_id' => $product->id,
                                    'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,
                                    'maluminum_id' => $aluminio->id
                                ]);

                            }
                        }

                    } else {

                        $aluminiosProduto->delete();

                    }


                    if ($request->has($component)) {
                        $componentsAll = Component::wherein('id', $request->$component)->get();
                        $componentesProduto->whereNotIn('id', $request->$component)->delete();

                        foreach ($request->$component as $id) {

                            $componente = $componentsAll->where('id', $id)->shift();

                            if ($componente->is_modelo == 1) {

                                Component::create([
                                    'nome' => $componente->nome,
                                    'qtd' => $componente->qtd,
                                    'preco' => $componente->preco,
                                    'is_modelo' => 0,
                                    'product_id' => $product->id,
                                    'categoria_componente_id' => $componente->categoria_componente_id,
                                    'mcomponent_id' => $componente->id
                                ]);

                            }
                        }

                    } else {

                        $componentesProduto->delete();

                    }
                }
                if ($products && self::atualizaTotal(null, $budgetcriado))
                    return redirect()->back()->with('success', 'Materiais dos produtos atualizados com sucesso');
                break;
            case '5': //tab total


                break;
            default:
        }
        return redirect()->back()->with('error', "Erro ao atualizar");
    }

    public function destroy($del, $id)
    {
        if ($del == 'budget') {
            $budget = Budget::find($id);
            if ($budget) {
                foreach ($budget->products as $product) {
                    $product->delete();
                }
                $budget->delete();
                return redirect()->back()->with('success', 'Orçamento deletado com sucesso');
            } else {
                return redirect()->back()->with('error', 'Erro ao deletar orçamento');
            }
        } else {

            $product = Product::with('glasses', 'aluminums', 'components')->find($id);

            if ($product) {
                $product->glasses()->delete();
                $product->aluminums()->delete();
                $product->components()->delete();
                $budgetcriado = $product->budget;
                $product->delete();
                $voltar = redirect()->back();
                if (self::atualizaTotal(null, $budgetcriado)) {
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


    public function atualizaTotal($budgetid, $budget)
    {

        if ($budgetid === null) {
            $budgetcriado = $budget;
        } else {
            $budgetcriado = Budget::with('products')->find($budgetid);
        }

        $productsids = array();
        foreach ($budgetcriado->products as $product) {
            $productsids[] = $product->id;
        }
        $products = Product::with('glasses', 'aluminums', 'components')->wherein('id', $productsids)->get();

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

        return $budgetcriado->update(['total' => $valorTotalDeProdutos]);

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
            'produtoid' => 'required|integer',
            'largura' => 'required|string|max:255',
            'altura' => 'required|string|max:255',
            'qtd' => 'required|integer',
            'localizacao' => 'nullable|string|max:255',
            'valor_mao_obra' => 'nullable|numeric'
        ]);

        return $validator;
    }

}
