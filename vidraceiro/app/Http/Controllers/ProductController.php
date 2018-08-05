<?php

namespace App\Http\Controllers;

use App\MProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = MProduct::all();
        return view('dashboard.list.product', compact('products'))->with('title', 'Produtos');
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
        return view('dashboard.create.product', compact('titulotabs', 'categorias', 'boxdiversos', 'boxpadrao', 'ferragem1000', 'ferragem3000', 'kitsacada'))->with('title', 'Criar Produto');

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

    public function destroy()
    {

    }
}
