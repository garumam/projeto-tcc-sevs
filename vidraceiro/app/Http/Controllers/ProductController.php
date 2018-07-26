<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.list.product')->with('title', 'Produto');
    }


    public function create()
    {

        $boxdiversos = $this->retornaNomes('/img/boxdiversos/');
        $boxpadrao = $this->retornaNomes('/img/boxpadrao/');
        $ferragem1000 = $this->retornaNomes('/img/ferragem1000/');
        $ferragem3000 = $this->retornaNomes('/img/ferragem3000/');


//        var_dump($boxdiversos,$boxpadrao,$ferragem1000,$ferragem3000);
        return view('dashboard.create.product', compact('boxdiversos'))->with('title', 'Criar Produto');

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

    public function read()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
