<?php

namespace App\Http\Controllers;

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


    public function create(Request $request)
    {
        $categorias = ['Box diversos', 'Box padrão', 'Ferragem 1000', 'Ferragem 3000', 'Kit sacada'];

        $boxdiversos = $this->retornaNomes('/img/boxdiversos/');
        $boxpadrao = $this->retornaNomes('/img/boxpadrao/');
        $ferragem1000 = $this->retornaNomes('/img/ferragem1000/');
        $ferragem3000 = $this->retornaNomes('/img/ferragem3000/');
        $kitsacada = $this->retornaNomes('/img/kitsacada/');
        $titulotabs = ['Produto', 'Material'];

//        var_dump($boxdiversos,$boxpadrao,$ferragem1000,$ferragem3000);
        return view('dashboard.create.mproduct', compact('titulotabs', 'categorias', 'boxdiversos', 'boxpadrao', 'ferragem1000', 'ferragem3000', 'kitsacada'))->with('title', 'Criar Produto');

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

    public function store()
    {

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
