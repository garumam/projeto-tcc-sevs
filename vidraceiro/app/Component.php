<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Component extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'qtd',
        'preco',
        'imagem',
        'is_modelo',
        'mcomponent_id',
        'categoria_componente_id',
        'product_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_componente_id')->withTrashed();
    }


    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }

    public function mProducts(){
        return $this->belongsToMany(
            MProduct::class,
            'm_product_component',
            'componente_id',
            'm_produto_id'
        );
    }

    public function providers(){
        return $this->belongsToMany(
            Provider::class,
            'provider_component',
            'componente_id',
            'provider_id'
        );
    }

    public function storage()
    {
        return $this->hasOne(
            Storage::class,
            'component_id'
        );
    }

    public function getWithSearchAndPagination($search, $paginate, $restore = false){

        $paginate = $paginate ?? 10;

        $queryBuilder = self::where('is_modelo', 1)->where(function($c) use ($search){
            $c->where('nome', 'like', '%' . $search . '%')
            ->orWhereHas('category',function ($q) use ($search){
                $q->where('nome','like', '%' . $search . '%');
            });
        });

        if($restore)
            $queryBuilder = $queryBuilder->onlyTrashed();

        return $queryBuilder->paginate($paginate);
    }

    public function findComponentById($id){

        return self::find($id);

    }

    public function restoreComponentById($id){

        $component = self::onlyTrashed()->find($id);

        return $component? $component->restore(): false;
    }

    public function createComponent(array $input){
        $component = self::create($input);

        if($component->is_modelo === 1){
            Storage::createStorage([
                'component_id' => $component->id
            ]);
        }

        return $component;
    }

    public function updateComponent(array $input){

        return self::update($input);

    }

    public function deleteComponent(){

        return self::delete();

    }

    public function syncProviders($ids){
        $this->providers()->sync($ids);
    }

    public static function getAllComponentsOrAllModels($is_modelo = 0){

        return self::where('is_modelo', $is_modelo)->get();

    }

    public static function getComponentsWhereIn(array $ids){

        return self::wherein('id', $ids)->get();

    }

    public static function deleteComponentOnListWhereNotIn($component,array $ids){

        return $component->whereNotIn('id', $ids)->forceDelete();

    }

}
