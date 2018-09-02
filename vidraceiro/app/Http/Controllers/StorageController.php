<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aluminum;
use App\Glass;
use App\Component;
use App\Storage;
use Illuminate\Support\Facades\Validator;

class StorageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aluminums = Aluminum::where('is_modelo',1)->get();
        $glasses = Glass::where('is_modelo',1)->get();
        $components = Component::where('is_modelo',1)->get();
        $storages = Storage::all();
        $titulotabs = ['Vidros','Aluminios','Componentes'];
        return view('dashboard.list.storage', compact('titulotabs', 'aluminums', 'glasses', 'components','storages'))->with('title', 'Estoque de materiais');
    }

    public function update(Request $request,$tab)
    {
        switch($tab){
            case 'vidro':

                $validado = Validator::make($request->all(), [
                    'storage_vidro_id' => 'required|integer|exists:storages,id',
                    'm2' => 'required|integer'
                ]);
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $storage = Storage::find($request->storage_vidro_id);
                $m2 = null;
                if($request->operacao === 'retirada'){
                    if($request->m2 > $storage->metros_quadrados){
                        return redirect()->back()->with('error', "Não foi possível completar retirada, valor superior ao estoque! Valor em estoque: ".$storage->metros_quadrados." | Valor retirado: ".$request->m2);
                    }
                    $m2 = $storage->metros_quadrados - $request->m2;

                }elseif($request->operacao === 'entrada'){

                    $m2 = $storage->metros_quadrados + $request->m2;


                }else{
                    return redirect()->back()->with('error', 'Operação não existe!');
                }
                $storage->update(['metros_quadrados'=>$m2]);
                break;

            case 'aluminio':

                $validado = Validator::make($request->all(), [
                    'storage_aluminio_id' => 'required|integer|exists:storages,id',
                    'qtd' => 'required|integer'
                ]);
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $storage = Storage::find($request->storage_aluminio_id);
                $qtd = null;
                if($request->operacao === 'retirada'){
                    if($request->qtd > $storage->qtd){
                        return redirect()->back()->with('error', "Não foi possível completar retirada, valor superior ao estoque! Valor em estoque: ".$storage->qtd." | Valor retirado: ".$request->qtd);
                    }
                    $qtd = $storage->qtd - $request->qtd;

                }elseif($request->operacao === 'entrada'){

                    $qtd = $storage->qtd + $request->qtd;


                }else{
                    return redirect()->back()->with('error', 'Operação não existe!');
                }
                $storage->update(['qtd'=>$qtd]);
                break;

            case 'componente':

                $validado = Validator::make($request->all(), [
                    'storage_componente_id' => 'required|integer|exists:storages,id',
                    'qtd' => 'required|integer'
                ]);
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado);
                }
                $storage = Storage::find($request->storage_componente_id);
                $qtd = null;
                if($request->operacao === 'retirada'){
                    if($request->qtd > $storage->qtd){
                        return redirect()->back()->with('error', "Não foi possível completar retirada, valor superior ao estoque! Valor em estoque: ".$storage->qtd." | Valor retirado: ".$request->qtd);
                    }
                    $qtd = $storage->qtd - $request->qtd;

                }elseif($request->operacao === 'entrada'){

                    $qtd = $storage->qtd + $request->qtd;


                }else{
                    return redirect()->back()->with('error', 'Operação não existe!');
                }
                $storage->update(['qtd'=>$qtd]);
                break;
        }


        if ($storage)
            return redirect()->back()->with('success', "Operação realizada com sucesso");
    }
}