<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aluminum;
use App\Glass;
use App\Component;
use App\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StorageController extends Controller
{
    protected $storage;
    public function __construct(Storage $storage)
    {
        $this->middleware('auth');

        $this->storage = $storage;
    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('estoque_listar', Storage::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        if(!$request->ajax()){
            $allglasses = Glass::getAllGlassesOrAllModels(1);
            $allaluminums = Aluminum::getAllAluminumsOrAllModels(1);
            $allcomponents = Component::getAllComponentsOrAllModels(1);
        }

        if($request->has('vidros') || !$request->ajax()){
            $glass = new Glass();
            $glasses = $glass->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));
        }

        if($request->has('aluminios') || !$request->ajax()){
            $aluminum = new Aluminum();
            $aluminums = $aluminum->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));
        }

        if($request->has('componentes') || !$request->ajax()){
            $component = new Component();
            $components = $component->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));
        }

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
            return view('dashboard.list.storage', compact('titulotabs', 'aluminums', 'glasses', 'components','allglasses','allaluminums','allcomponents'))->with('title', 'Estoque de materiais');
        }
    }

    public function update(Request $request,$tab)
    {
        if(!Auth::user()->can('estoque_atualizar', Storage::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }
        $tabnumber = 1;
        switch($tab){
            case 'vidro':
                $tabnumber = 1;
                $validado = $this->rules_storage($request->all(),$tab);

                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado)->with('tab',1);
                }
                $storage = Storage::getFirstStorageWhere('id',$request->storage_vidro_id);
                $m2 = null;
                if($request->operacao === 'saida'){
                    if($request->m2 > $storage->metros_quadrados){
                        return redirect()->back()->with('error', "Não foi possível completar saída, valor superior ao estoque! Valor em estoque: ".$storage->metros_quadrados." | Valor retirado: ".$request->m2)->with('tab',1);
                    }
                    $m2 = $storage->metros_quadrados - $request->m2;

                }elseif($request->operacao === 'entrada'){

                    $m2 = $storage->metros_quadrados + $request->m2;


                }else{
                    return redirect()->back()->with('error', 'Operação não existe!')->with('tab',1);
                }
                $storage->updateStorage('metros_quadrados',$m2);
                break;

            case 'aluminio':
                $tabnumber = 2;
                $validado = $this->rules_storage($request->all(),$tab);
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado)->with('tab',2);
                }
                $storage = Storage::getFirstStorageWhere('id',$request->storage_aluminio_id);
                $qtd = null;
                if($request->operacao === 'saida'){
                    if($request->qtd > $storage->qtd){
                        return redirect()->back()->with('error', "Não foi possível completar saída, valor superior ao estoque! Valor em estoque: ".$storage->qtd." | Valor retirado: ".$request->qtd)->with('tab',2);
                    }
                    $qtd = $storage->qtd - $request->qtd;

                }elseif($request->operacao === 'entrada'){

                    $qtd = $storage->qtd + $request->qtd;


                }else{
                    return redirect()->back()->with('error', 'Operação não existe!')->with('tab',2);
                }
                $storage->updateStorage('qtd',$qtd);
                break;

            case 'componente':
                $tabnumber = 3;
                $validado = $this->rules_storage($request->all(),$tab);
                if ($validado->fails()) {
                    return redirect()->back()->withErrors($validado)->with('tab',3);
                }
                $storage = Storage::getFirstStorageWhere('id',$request->storage_componente_id);
                $qtd = null;
                if($request->operacao === 'saida'){
                    if($request->qtd > $storage->qtd){
                        return redirect()->back()->with('error', "Não foi possível completar saída, valor superior ao estoque! Valor em estoque: ".$storage->qtd." | Valor retirado: ".$request->qtd)->with('tab',3);
                    }
                    $qtd = $storage->qtd - $request->qtd;

                }elseif($request->operacao === 'entrada'){

                    $qtd = $storage->qtd + $request->qtd;


                }else{
                    return redirect()->back()->with('error', 'Operação não existe!')->with('tab',3);
                }
                $storage->updateStorage('qtd',$qtd);
                break;
        }


        if ($storage)
            return redirect()->back()->with('success', "Operação realizada com sucesso")->with('tab',$tabnumber);
    }

    public function rules_storage(array $data, $type)
    {
        switch ($type) {
            case 'vidro':
                $validator = Validator::make($data, [
                    'storage_vidro_id' => 'required|integer|exists:storages,id',
                    'm2' => 'required|integer'
                ], [
                    'exists' => 'Material não registrado no estoque!',
                ]);
                break;
            case 'aluminio':
                $validator = Validator::make($data, [
                    'storage_aluminio_id' => 'required|integer|exists:storages,id',
                    'qtd' => 'required|integer'
                ], [
                    'exists' => 'Material não registrado no estoque!',
                ]);
                break;
            case 'componente':
                $validator = Validator::make($data, [
                    'storage_componente_id' => 'required|integer|exists:storages,id',
                    'qtd' => 'required|integer'
                ], [
                    'exists' => 'Material não registrado no estoque!',
                ]);
                break;
        }

        return $validator;
    }
}
