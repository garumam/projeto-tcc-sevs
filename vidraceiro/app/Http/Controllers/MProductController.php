<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Category;
use App\Component;
use App\Glass;
use App\MProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
//        $mProducts = MProduct::with('category')->get();
        $paginate = 10;
        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        }
        $mProducts = MProduct::with('category')->where('nome', 'like', '%' . $request->get('search') . '%')
//            ->orderBy($request->get('field'), $request->get('sort'))
            ->paginate($paginate);
        if ($request->ajax()) {
            return view('dashboard.list.tables.table-mproduct', compact('mProducts'));
        } else {
            return view('dashboard.list.mproduct', compact('mProducts'))->with('title', 'Produtos');
        }
    }


    public function create()
    {
        $categories = Category::where('tipo', 'produto')->get();
        $aluminums = Aluminum::where('is_modelo', '1')->get();
        $glasses = Glass::where('is_modelo', '1')->get();
        $components = Component::where('is_modelo', '1')->get();
        $boxdiversos = $this->retornaNomes('/img/boxdiversos/');
        $boxpadrao = $this->retornaNomes('/img/boxpadrao/');
        $ferragem1000 = $this->retornaNomes('/img/ferragem1000/');
        $ferragem3000 = $this->retornaNomes('/img/ferragem3000/');
        $kitsacada = $this->retornaNomes('/img/kitsacada/');
        $titulotabs = ['Produto', 'Material'];


//        dd($componentsProduct);
//        var_dump($boxdiversos,$boxpadrao,$ferragem1000,$ferragem3000);
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

        switch ($tab) {
            case '1':
                $validado = $this->rules_mproduct($request->all());
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $mproductcriado = new MProduct;
                $mproductcriado = $mproductcriado->create($request->all());
                if ($mproductcriado)
                    return redirect()->back()->with('success', 'Produto criado com sucesso')
                        ->with(compact('mproductcriado'));
                break;
            case '2':
                $validado = $this->rules_mproduct_material($request->all());
                if ($validado->fails()) {
                    $mproductcriado = MProduct::orderBy('created_at', 'desc')->first();
                    return redirect()->back()->withErrors($validado)
                        ->with(compact('mproductcriado'));
                }
                $mproductcriado = MProduct::find($request->m_produto_id);
                if ($mproductcriado) {
                    $mproductcriado->glasses()->detach();
                    $mproductcriado->aluminums()->detach();
                    $mproductcriado->components()->detach();
                    $mproductcriado->glasses()->attach($request->id_vidro_);
                    $mproductcriado->aluminums()->attach($request->id_aluminio_);
                    $mproductcriado->components()->attach($request->id_componente_);
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
        $aluminums = Aluminum::where('is_modelo', '1')->get();
        $glasses = Glass::where('is_modelo', '1')->get();
        $components = Component::where('is_modelo', '1')->get();
        $boxdiversos = $this->retornaNomes('/img/boxdiversos/');
        $boxpadrao = $this->retornaNomes('/img/boxpadrao/');
        $ferragem1000 = $this->retornaNomes('/img/ferragem1000/');
        $ferragem3000 = $this->retornaNomes('/img/ferragem3000/');
        $kitsacada = $this->retornaNomes('/img/kitsacada/');
        $categories = Category::where('tipo', 'produto')->get();
        $mproductedit = MProduct::with('glasses', 'aluminums', 'components')->find($id);
//        dd($mproductedit);
        $titulotabs = ['Produto', 'Material'];
        if ($mproductedit) {
            $categoryEdit = $mproductedit->category()->get();
            return view('dashboard.create.mproduct', compact('aluminums', 'glasses', 'components', 'boxdiversos', 'boxpadrao', 'ferragem1000', 'ferragem3000', 'kitsacada', 'categories', 'mproductedit', 'categoryEdit', 'aluminumsProduct', 'glassesProduct', 'componentsProduct', 'titulotabs'))->with('title', 'Atualizar produto');
        }
        return redirect('products')->with('error', 'Erro ao buscar produto');
    }


    public function update(Request $request, $id, $tab)
    {
//        var_dump($request->all());
        switch ($tab) {
            case '1':

                $mproductcriado = MProduct::find($id);

                $validado = $this->rules_mproduct($request->all());
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado)
                        ->with(compact('mproductcriado'));
                }
                $mproductcriado->update($request->all());

                if ($mproductcriado) {
                    return redirect()->back()->with('success', 'Produto atualizado com sucesso')
                        ->with(compact('mproductcriado'));
                }
                break;
            case '2':
                $mproductcriado = MProduct::find($id);
                $validado = $this->rules_mproduct_material($request->all());
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado)
                        ->with(compact('mproductcriado'));
                }
                if ($mproductcriado) {
                    $mproductcriado->glasses()->detach();
                    $mproductcriado->aluminums()->detach();
                    $mproductcriado->components()->detach();
                    $mproductcriado->glasses()->attach($request->id_vidro_);
                    $mproductcriado->aluminums()->attach($request->id_aluminio_);
                    $mproductcriado->components()->attach($request->id_componente_);
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
        $mproduct = MProduct::find($id);
        if ($mproduct) {
            $mproduct->delete();
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
            'categoria_produto_id' => 'required|integer'
        ]);

        return $validator;
    }

    public function rules_mproduct_material(array $data)
    {
        $validator = Validator::make($data, [
            'm_produto_id' => 'required|integer',
            'id_vidro_' => 'nullable|array'
        ]);

        return $validator;
    }

}
