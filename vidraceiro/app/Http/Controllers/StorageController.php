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
        $materialType = 'storage_vidro_id';
        if($tab == 'aluminio'){
            $tabnumber = 2;
            $materialType = 'storage_aluminio_id';
        }elseif($tab == 'componente'){
            $tabnumber = 3;
            $materialType = 'storage_componente_id';
        }

        $validado = $this->rules_storage($request->all(),$materialType);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado)->with('tab',$tabnumber);
        }
        $storage = Storage::getFirstStorageWhere('id',$request->$materialType);
        $qtd = null;
        if($request->operacao === 'saida'){
            if($request->qtd > $storage->qtd){
                return redirect()->back()->with('error', "Não foi possível completar saída, valor superior ao estoque! Valor em estoque: ".$storage->qtd." | Valor retirado: ".$request->qtd)->with('tab',$tabnumber);
            }
            $qtd = $storage->qtd - $request->qtd;

        }elseif($request->operacao === 'entrada'){

            $qtd = $storage->qtd + $request->qtd;


        }else{
            return redirect()->back()->with('error', 'Operação não existe!')->with('tab',$tabnumber);
        }
        $storage->updateStorage('qtd',$qtd);
        

        if ($storage)
            return redirect()->back()->with('success', "Operação realizada com sucesso")->with('tab',$tabnumber);
    }

    public function rules_storage(array $data, $type)
    {
        $validator = Validator::make($data, [
            $type => 'required|integer|exists:storages,id',
            'qtd' => 'required|integer'
        ], [
            'exists' => 'Material não registrado no estoque!',
        ]);
        
        return $validator;
    }
}
