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
use phpDocumentor\Reflection\Types\Array_;

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
        $titulotabs = ['Orçamento', 'Adicionar', 'Editar', 'Material', 'Total'];
        //dd($mproducts);
        return view('dashboard.create.budget', compact('titulotabs', 'states', 'glasses', 'aluminums', 'components', 'categories', 'mproducts'))->with('title', 'Novo Orçamento');
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
            case '2': //tab adicionar
                $product = new Product();
                $product = $product->create($request->except('budgetid'));
                $mproduct = MProduct::with('glasses', 'aluminums', 'components')->find($product->m_produto_id);

                foreach ($mproduct->glasses()->get() as $vidro) {
                    $glassCreate = Glass::create([
                        'nome' => $vidro->nome,
                        'descricao' => $vidro->descricao,
                        'tipo' => $vidro->tipo,
                        'espessura' => $vidro->espessura,
                        'preco' => $vidro->preco,
                        'categoria_vidro_id' => $vidro->categoria_vidro_id,
                        'is_modelo' => 0
                    ]);

                    $product->glasses()->attach($glassCreate->id);
                }

                foreach ($mproduct->aluminums()->get() as $aluminio) {
                    $aluminumCreate = Aluminum::create([
                        'perfil' => $aluminio->perfil,
                        'descricao' => $aluminio->descricao,
                        'medida' => $aluminio->medida,
                        'qtd' => $aluminio->qtd,
                        'peso' => $aluminio->peso,
                        'preco' => $aluminio->preco,
                        'tipo_medida' => $aluminio->tipo_medida,
                        'is_modelo' => 0,
                        'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,

                    ]);
                    $product->aluminums()->attach($aluminumCreate->id);
                }

                foreach ($mproduct->components()->get() as $componente) {
                    $componentCreate = Component::create([
                        'nome' => $componente->nome,
                        'qtd' => $componente->qtd,
                        'preco' => $componente->preco,
                        'is_modelo' => 0,
                        'categoria_componente_id' => $componente->categoria_componente_id,

                    ]);
                    $product->components()->attach($componentCreate->id);
                }

                if ($product) {
                    $budgetcriado = Budget::find($request->budgetid);
                    $budgetcriado->products()->attach($product->id);
                    if ($budgetcriado) {
                        $products = $budgetcriado->products;
                        return redirect()->back()->with('success', 'Produto adicionado ao orçamento com sucesso')
                            ->with(compact('budgetcriado'))
                            ->with(compact('products'));
                    }
                }

                break;
            case '3': //tab editar
                $budgetcriado = Budget::find($request->budgetid);
                $product = Product::find($request->produtoid);
                $product->update($request->except(['produtoid', 'budgetid']));

                if ($product && $budgetcriado) {
                    $products = $budgetcriado->products;
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso')
                        ->with(compact('budgetcriado'))
                        ->with(compact('products'));
                }
                break;
            case '4': //tab material
                $budgetcriado = Budget::with('products')->find($request->budgetid);
                $products = $budgetcriado->products;
                $glassesAll = Glass::where('is_modelo', 1)->get();
                $aluminumsAll = Aluminum::where('is_modelo', 1)->get();
                $componentsAll = Component::where('is_modelo', 1)->get();

                foreach ($products as $product) {
                    $glass = 'id_vidro_' . $product->id;
                    $aluminum = 'id_aluminio_' . $product->id;
                    $component = 'id_componente_' . $product->id;

                    if ($request->has($glass)) {
                        $idsNew = array();
                        $idsExists = array();
                        foreach ($request->get($glass) as $glassRequest) {
                            foreach ($product->glasses()->get() as $glassProduct) {
                                if ($glassProduct->id == $glassRequest) {
                                    $idsExists[] = $glassRequest;
                                }
                            }
                            $idsExists = array_unique($idsExists);
                            foreach ($glassesAll as $vidro) {
                                if ($vidro->id == $glassRequest) {
                                    $glassCreate = Glass::create([
                                        'nome' => $vidro->nome,
                                        'descricao' => $vidro->descricao,
                                        'tipo' => $vidro->tipo,
                                        'espessura' => $vidro->espessura,
                                        'preco' => $vidro->preco,
                                        'categoria_vidro_id' => $vidro->categoria_vidro_id,
                                        'is_modelo' => 0
                                    ]);
                                    $idsNew[] = $glassCreate->id;
                                    break;
                                }
                            }
                        }
                        $product->glasses()->sync(array_merge($idsNew, $idsExists));
                    } else {
                        $product->glasses()->detach();
                    }

                    if ($request->has($aluminum)) {
                        $idsNew = array();
                        $idsExists = array();
                        foreach ($request->get($aluminum) as $aluminumRequest) {
                            foreach ($product->aluminums()->get() as $aluminumProduct) {
                                if ($aluminumProduct->id == $aluminumRequest) {
                                    $idsExists[] = $aluminumRequest;
                                }
                            }
                            $idsExists = array_unique($idsExists);
                            foreach ($aluminumsAll as $aluminio) {
                                if ($aluminio->id == $aluminumRequest) {
                                    $aluminumCreate = Aluminum::create([
                                        'perfil' => $aluminio->perfil,
                                        'descricao' => $aluminio->descricao,
                                        'medida' => $aluminio->medida,
                                        'qtd' => $aluminio->qtd,
                                        'peso' => $aluminio->peso,
                                        'preco' => $aluminio->preco,
                                        'tipo_medida' => $aluminio->tipo_medida,
                                        'is_modelo' => 0,
                                        'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,
                                    ]);
                                    $idsNew[] = $aluminumCreate->id;
                                    break;
                                }
                            }
                        }
                        $product->aluminums()->sync(array_merge($idsNew, $idsExists));
                    } else {
                        $product->aluminums()->detach();
                    }


                    if ($request->has($component)) {
                        $idsNew = array();
                        $idsExists = array();
                        foreach ($request->get($component) as $componentRequest) {
                            foreach ($product->components()->get() as $componentProduct) {
                                if ($componentProduct->id == $componentRequest) {
                                    $idsExists[] = $componentRequest;
                                }
                            }
                            $idsExists = array_unique($idsExists);
                            foreach ($componentsAll as $componente) {
                                if ($componente->id == $componentRequest) {
                                    $componentCreate = Component::create([
                                        'nome' => $componente->nome,
                                        'qtd' => $componente->qtd,
                                        'preco' => $componente->preco,
                                        'is_modelo' => 0,
                                        'categoria_componente_id' => $componente->categoria_componente_id,

                                    ]);
                                    $idsNew[] = $componentCreate->id;
                                    break;
                                }
                            }
                        }
                        $product->components()->sync(array_merge($idsNew, $idsExists));
                    } else {
                        $product->components()->detach();
                    }
                }

                if ($budgetcriado) {
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
        $titulotabs = ['Orçamento', 'Adicionar', 'Editar', 'Material', 'Total'];

        $budgetedit = Budget::with('products')->find($id);
        if ($budgetedit) {
            $products = $budgetedit->products()->with('mproduct', 'glasses', 'aluminums', 'components')->get();
            return view('dashboard.create.budget', compact('titulotabs', 'states', 'glasses', 'aluminums', 'components', 'categories', 'mproducts', 'products', 'budgetedit'))->with('title', 'Atualizar Orçamento');
        }
        return redirect('products')->with('error', 'Erro ao buscar produto');

    }


    public function update(Request $request, $tab, $id)
    {
        switch ($tab) {
            case '1': //tab orçamento
                $budgetcriado = Budget::find($id);
                $budgetcriado = $budgetcriado->update($request->all());
                if ($budgetcriado)
                    return redirect()->back()->with('success', 'Orçamento atualizado com sucesso');
                break;
            case '2': //tab adicionar
                $product = new Product();
                $product = $product->create($request->all());
                $mproduct = MProduct::with('glasses', 'aluminums', 'components')->find($product->m_produto_id);

                foreach ($mproduct->glasses()->get() as $vidro) {
                    $glassCreate = Glass::create([
                        'nome' => $vidro->nome,
                        'descricao' => $vidro->descricao,
                        'tipo' => $vidro->tipo,
                        'espessura' => $vidro->espessura,
                        'preco' => $vidro->preco,
                        'categoria_vidro_id' => $vidro->categoria_vidro_id,
                        'is_modelo' => 0
                    ]);

                    $product->glasses()->attach($glassCreate->id);
                }

                foreach ($mproduct->aluminums()->get() as $aluminio) {
                    $aluminumCreate = Aluminum::create([
                        'perfil' => $aluminio->perfil,
                        'descricao' => $aluminio->descricao,
                        'medida' => $aluminio->medida,
                        'qtd' => $aluminio->qtd,
                        'peso' => $aluminio->peso,
                        'preco' => $aluminio->preco,
                        'tipo_medida' => $aluminio->tipo_medida,
                        'is_modelo' => 0,
                        'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,

                    ]);
                    $product->aluminums()->attach($aluminumCreate->id);
                }

                foreach ($mproduct->components()->get() as $componente) {
                    $componentCreate = Component::create([
                        'nome' => $componente->nome,
                        'qtd' => $componente->qtd,
                        'preco' => $componente->preco,
                        'is_modelo' => 0,
                        'categoria_componente_id' => $componente->categoria_componente_id,

                    ]);
                    $product->components()->attach($componentCreate->id);
                }
                if ($product) {
                    $budgetcriado = Budget::find($id);
                    $budgetcriado->products()->attach($product->id);
                    if ($budgetcriado)
                        return redirect()->back()->with('success', 'Produto adicionado ao orçamento com sucesso');
                }
                break;
            case '3': //tab editar
                $product = Product::find($request->produtoid);
                $product->update($request->except(['produtoid']));
                if ($product)
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso');

                break;
            case '4': //tab material
                $budgetcriado = Budget::with('products')->find($id);
                $products = $budgetcriado->products;
                $glassesAll = Glass::where('is_modelo', 1)->get();
                $aluminumsAll = Aluminum::where('is_modelo', 1)->get();
                $componentsAll = Component::where('is_modelo', 1)->get();
                foreach ($products as $product) {
                    $glass = 'id_vidro_' . $product->id;
                    $aluminum = 'id_aluminio_' . $product->id;
                    $component = 'id_componente_' . $product->id;

                    if ($request->has($glass)) {
                        $idsNew = array();
                        $idsExists = array();
                        foreach ($request->get($glass) as $glassRequest) {
                            foreach ($product->glasses()->get() as $glassProduct) {
                                if ($glassProduct->id == $glassRequest) {
                                    $idsExists[] = $glassRequest;
                                }
                            }
                            $idsExists = array_unique($idsExists);
                            foreach ($glassesAll as $vidro) {
                                if ($vidro->id == $glassRequest) {
                                    $glassCreate = Glass::create([
                                        'nome' => $vidro->nome,
                                        'descricao' => $vidro->descricao,
                                        'tipo' => $vidro->tipo,
                                        'espessura' => $vidro->espessura,
                                        'preco' => $vidro->preco,
                                        'categoria_vidro_id' => $vidro->categoria_vidro_id,
                                        'is_modelo' => 0
                                    ]);
                                    $idsNew[] = $glassCreate->id;
                                    break;
                                }
                            }
                        }
                        $product->glasses()->sync(array_merge($idsNew, $idsExists));
                    } else {
                        $product->glasses()->detach();
                    }

                    if ($request->has($aluminum)) {
                        $idsNew = array();
                        $idsExists = array();
                        foreach ($request->get($aluminum) as $aluminumRequest) {
                            foreach ($product->aluminums()->get() as $aluminumProduct) {
                                if ($aluminumProduct->id == $aluminumRequest) {
                                    $idsExists[] = $aluminumRequest;
                                }
                            }
                            $idsExists = array_unique($idsExists);
                            foreach ($aluminumsAll as $aluminio) {
                                if ($aluminio->id == $aluminumRequest) {
                                    $aluminumCreate = Aluminum::create([
                                        'perfil' => $aluminio->perfil,
                                        'descricao' => $aluminio->descricao,
                                        'medida' => $aluminio->medida,
                                        'qtd' => $aluminio->qtd,
                                        'peso' => $aluminio->peso,
                                        'preco' => $aluminio->preco,
                                        'tipo_medida' => $aluminio->tipo_medida,
                                        'is_modelo' => 0,
                                        'categoria_aluminio_id' => $aluminio->categoria_aluminio_id,
                                    ]);
                                    $idsNew[] = $aluminumCreate->id;
                                    break;
                                }
                            }
                        }
                        $product->aluminums()->sync(array_merge($idsNew, $idsExists));
                    } else {
                        $product->aluminums()->detach();
                    }


                    if ($request->has($component)) {
                        $idsNew = array();
                        $idsExists = array();
                        foreach ($request->get($component) as $componentRequest) {
                            foreach ($product->components()->get() as $componentProduct) {
                                if ($componentProduct->id == $componentRequest) {
                                    $idsExists[] = $componentRequest;
                                }
                            }
                            $idsExists = array_unique($idsExists);
                            foreach ($componentsAll as $componente) {
                                if ($componente->id == $componentRequest) {
                                    $componentCreate = Component::create([
                                        'nome' => $componente->nome,
                                        'qtd' => $componente->qtd,
                                        'preco' => $componente->preco,
                                        'is_modelo' => 0,
                                        'categoria_componente_id' => $componente->categoria_componente_id,

                                    ]);
                                    $idsNew[] = $componentCreate->id;
                                    break;
                                }
                            }
                        }
                        $product->components()->sync(array_merge($idsNew, $idsExists));
                    } else {
                        $product->components()->detach();
                    }
                }
                if ($products)
                    return redirect()->back()->with('success', 'Materiais dos produtos atualizados com sucesso');
                break;
            case '5': //tab total


                break;
            default:
        }
        return redirect()->back()->with('error', "Erro ao atualizar");
    }

    public function destroy($id)
    {
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
    }


}
