<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $guarded = [];

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

    public function updateProvider(array $input,$id){

        $provider = self::find($id);

        return $provider->update($input);

    }

    public function deleteProvider($id){

        $provider = self::find($id);
        if($provider){
            return $provider->delete();
        }

        return false;

    }

    public function findProviderById($id){

        return self::find($id);

    }

    public static function getAll(){
        return self::all();
    }
}
