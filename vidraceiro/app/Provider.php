<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'nome',
        'situacao',
        'cnpj',
        'endereco_id',
        'contato_id'
    ];

    public function location(){
        return $this->hasOne(Location::class,'id','endereco_id');
    }

    public function contact(){
        return $this->hasOne(Contact::class,'id','endereco_id');
    }

    public function glasses(){
        return $this->belongsToMany(
            Glass::class,
            'provider_glass',
            'provider_id',
            'vidro_id'
        );
    }
    public function aluminums(){
        return $this->belongsToMany(
            Aluminum::class,
            'provider_aluminum',
            'provider_id',
            'aluminio_id'
        );
    }
    public function components(){
        return $this->belongsToMany(
            Component::class,
            'provider_component',
            'provider_id',
            'componente_id'
        );
    }

    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::where('nome', 'like', '%' . $search . '%')
            ->orWhere('situacao', 'like', '%' . $search . '%')
            ->paginate($paginate);
    }

    public function createProvider(array $input){

        return self::create($input);

    }

    public function updateProvider(array $input){

        return self::update($input);

    }

    public function deleteProvider(){

        return self::delete();

    }

    public function findProviderById($id){

        return self::find($id);

    }

    public static function getAll(){
        return self::all();
    }

    public static function filterProviders($request){

        $situacao = $request->situacao;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $providers = new Provider();

        if($data_inicial !== null || $data_final !== null){

            $providers = self::where(function ($q) use ($data_inicial,$data_final){
                if($data_final !== null)
                    $q->whereDate('created_at','<=',$data_final);

                if($data_inicial !== null)
                    $q->whereDate('created_at','>=',$data_inicial);
            });
        }

        if($situacao === 'TODAS'){
            $providers = $providers->get();
        }else{
            $providers = $providers->where('situacao',$situacao)->get();
        }

        return $providers;

    }
}
