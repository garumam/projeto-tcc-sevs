<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Category;
use App\Component;
use App\Glass;
use App\MProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MProductController extends Controller
{
    protected $mproduct;
    public function __construct(MProduct $mproduct)
    {
        $this->middleware('auth');
        $this->mproduct = $mproduct;
    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('modelo_listar', MProduct::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $mProducts = $this->mproduct->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));
        if ($request->ajax()) {
            return view('dashboard.list.tables.table-mproduct', compact('mProducts'));
        } else {
            return view('dashboard.list.mproduct', compact('mProducts'))->with('title', 'Produtos');
        }
    }


    public function create()
    {
        if(!Auth::user()->can('modelo_adicionar', MProduct::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $categories = Category::getAllCategoriesByType('produto');
        $aluminums = Aluminum::getAllAluminumsOrAllModels(1);
        $glasses = Glass::getAllGlassesOrAllModels(1);
        $components = Component::getAllComponentsOrAllModels(1);
        $boxdiversos = $this->retornaNomes('/img/boxdiversos/');
        $boxpadrao = $this->retornaNomes('/img/boxpadrao/');
        $ferragem1000 = $this->retornaNomes('/img/ferragem1000/');
        $ferragem3000 = $this->retornaNomes('/img/ferragem3000/');
        $kitsacada = $this->retornaNomes('/img/kitsacada/');
        $titulotabs = ['Produto', 'Material'];

        return view('dashboard.create.mproduct', compact('titulotabs', 'categories', 'aluminums', 'glasses', 'components', 'boxdiversos', 'boxpadrao', 'ferragem1000', 'ferragem3000', 'kitsacada'))->with('title', 'Criar Produto');

    }

    public function retornaNomes($folder)
    {
        $filename = [];
        $files = File::files(public_path() . $folder);
        foreach ($files as $file) {
            $filename[] = pathinfo($file, PATHINFO_BASENAME);
        }
        return $filename;
    }

    public function store(Request $request, $tab)
    {
        if(!Auth::user()->can('modelo_adicionar', MProduct::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        switch ($tab) {
            case '1':
                $validado = $this->rules_mproduct($request->all());
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $mproductcriado = $this->mproduct->createMProduct($request->all());
                if ($mproductcriado)
                    return redirect()->back()->with('success', 'Produto criado com sucesso')
                        ->with(compact('mproductcriado'));
                break;
            case '2':
                $validado = $this->rules_mproduct_material($request->all());

                $mproductcriado = $this->mproduct->findMProductById($request->m_produto_id);

                if ($validado->fails()) {

                    return redirect()->back()->withErrors($validado)
                        ->with(compact('mproductcriado'));
                }

                if ($mproductcriado) {

                    $mproductcriado->syncMaterialsOfMProduct($request->id_vidro_,$request->id_aluminio_,$request->id_componente_);

                    if ($mproductcriado)
                        return redirect()->back()->with('success', 'Material adicionado ao produto com sucesso')
                            ->with(compact('mproductcriado'));
                }
                break;
            default:
        }
        return redirect()->back()->with('error', 'Erro ao salvar produto');
    }

    public function show()
    {

    }

    public function edit($id)
    {
        if(!Auth::user()->can('modelo_atualizar', MProduct::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_mproduct_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('mproducts.index'))->withErrors($validado);
        }

        $aluminums = Aluminum::getAllAluminumsOrAllModels(1);
        $glasses = Glass::getAllGlassesOrAllModels(1);
        $components = Component::getAllComponentsOrAllModels(1);
        $boxdiversos = $this->retornaNomes('/img/boxdiversos/');
        $boxpadrao = $this->retornaNomes('/img/boxpadrao/');
        $ferragem1000 = $this->retornaNomes('/img/ferragem1000/');
        $ferragem3000 = $this->retornaNomes('/img/ferragem3000/');
        $kitsacada = $this->retornaNomes('/img/kitsacada/');
        $categories = Category::getAllCategoriesByType('produto');
        $mproductedit = MProduct::findMProductWithRelationsById($id);

        $titulotabs = ['Produto', 'Material'];
        if ($mproductedit) {
            $categoryEdit = $mproductedit->category;

            return view('dashboard.create.mproduct', compact('aluminums', 'glasses', 'components', 'boxdiversos', 'boxpadrao', 'ferragem1000', 'ferragem3000', 'kitsacada', 'categories', 'mproductedit', 'categoryEdit', 'aluminumsProduct', 'glassesProduct', 'componentsProduct', 'titulotabs'))->with('title', 'Atualizar produto');
        }
        return redirect('products')->with('error', 'Erro ao buscar produto');
    }


    public function update(Request $request, $id, $tab)
    {
        if(!Auth::user()->can('modelo_atualizar', MProduct::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_mproduct_exists(['id'=>$id]);

        if ($validado->fails()) {
            return redirect(route('mproducts.index'))->withErrors($validado);
        }

        switch ($tab) {
            case '1':

                $mproductcriado = $this->mproduct->findMProductById($id);

                $validado = $this->rules_mproduct($request->all());
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado)
                        ->with(compact('mproductcriado'));
                }
                $mproductcriado->updateMProduct($request->all());

                if ($mproductcriado) {
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso')
                        ->with(compact('mproductcriado'));
                }
                break;
            case '2':
                $mproductcriado = $this->mproduct->findMProductById($id);
                $validado = $this->rules_mproduct_material($request->all());
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado)
                        ->with(compact('mproductcriado'));
                }
                if ($mproductcriado) {

                    $mproductcriado->syncMaterialsOfMProduct($request->id_vidro_,$request->id_aluminio_,$request->id_componente_);

                    if ($mproductcriado)
                        return redirect()->back()->with('success', 'Material atualizado no produto com sucesso')
                            ->with(compact('mproductcriado'));
                }
                break;
            default:
        }
    }

    public function destroy($id)
    {
        if(!Auth::user()->can('modelo_deletar', MProduct::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $mproduct = $this->mproduct->findMProductById($id);
        if ($mproduct) {
            $mproduct->deleteMProduct();
            return redirect()->back()->with('success', 'Modelo de produto deletado com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar modelo de produto');
        }
    }

    public function rules_mproduct(array $data)
    {
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'imagem' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'categoria_produto_id' => 'required|integer|exists:categories,id'
        ]);

        return $validator;
    }

    public function rules_mproduct_material(array $data)
    {
        $validator = Validator::make($data, [
            'm_produto_id' => 'required|integer|exists:m_products,id',
            'id_vidro_' => 'nullable|array'
        ], [
            'exists' => 'Este modelo de produto não existe!',
        ]);

        return $validator;
    }

    public function rules_mproduct_exists(array $data)
    {
        $validator = Validator::make($data,

            [
                'id' => 'exists:m_products,id'
            ], [
                'exists' => 'Este modelo de produto não existe!',
            ]

        );

        return $validator;
    }

}
