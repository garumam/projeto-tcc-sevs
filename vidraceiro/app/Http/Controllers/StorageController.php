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

    public function index(Request $request)
    {
        $paginate = 10;
        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        }
        $glasses = Glass::where('is_modelo',1)->where('nome', 'like', '%' . $request->get('search') . '%')
            ->paginate($paginate);

        $aluminums = Aluminum::where('is_modelo',1)->where('perfil', 'like', '%' . $request->get('search') . '%')
            ->paginate($paginate);

        $components = Component::where('is_modelo',1)->where('nome', 'like', '%' . $request->get('search') . '%')
            ->paginate($paginate);

        $titulotabs = ['Vidros','Aluminios','Componentes'];

        if ($request->ajax()) {
            if ($request->has('vidros')) {
                return view('dashboard.list.tables.table-storage-glass', compact('glasses'));
            }
            if ($request->has('aluminios')) {
                return view('dashboard.list.tables.table-storage-aluminum', compact('aluminums'));
            }
            if ($request->has('componentes')) {
                return view('dashboard.list.tables.table-storage-component', compact('components'));
            }
        } else {
            return view('dashboard.list.storage', compact('titulotabs', 'aluminums', 'glasses', 'components'))->with('title', 'Estoque de materiais');
        }
    }

    public function update(Request $request,$tab)
    {
        switch($tab){
            case 'vidro':

                $validado = Validator::make($request->all(), [
                    'storage_vidro_id' => 'required|integer|exists:storages,id',
                    'm2' => 'required|integer'
                ], [
                    'exists' => 'Material não registrado no estoque!',
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
                ], [
                    'exists' => 'Material não registrado no estoque!',
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
                ], [
                    'exists' => 'Material não registrado no estoque!',
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
