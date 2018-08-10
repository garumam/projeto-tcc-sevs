<?php

namespace App\Http\Controllers;

use App\Aluminum;
use App\Category;
use App\Component;
use App\Glass;
use App\MProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $products = MProduct::all();
        $mProducts = MProduct::with('category')->get();
//        dd($relations);
//        dd($mProducts);
        return view('dashboard.list.mproduct', compact('mProducts'))->with('title', 'Produtos');
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

        /*$mproduct = MProduct::with('aluminums', 'glasses', 'components')->find(3);
        $aluminumsProduct = $mproduct->aluminums()->get();
        $glassesProduct = $mproduct->glasses()->get();
        $componentsProduct = $mproduct->components()->get();*/

//        dd($componentsProduct);
//        var_dump($boxdiversos,$boxpadrao,$ferragem1000,$ferragem3000);
        return view('dashboard.create.mproduct', compact('titulotabs','categories', 'aluminums', 'glasses', 'components', 'boxdiversos', 'boxpadrao', 'ferragem1000', 'ferragem3000', 'kitsacada'))->with('title', 'Criar Produto');

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

                $mproduto = new MProduct;
                $mproductcriado = $mproduto->create($request->all());
                if ($mproductcriado)
                    return redirect()->back()->with('success', 'Produto criado com sucesso')
                                             ->with(compact('mproductcriado'));
                break;
            case '2':



                break;
            default:
        }
    }

    public function show()
    {

    }

    public function edit()
    {

    }


    public function update()
    {

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
}
