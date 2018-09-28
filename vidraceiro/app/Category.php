<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'nome',
        'tipo',
        'grupo_imagem'
    ];

    public function mProducts(){
        return $this->hasMany(MProduct::class,'categoria_produto_id');
    }

    public function glasses()
    {
        return $this->hasMany(Glass::class, 'categoria_vidro_id');
    }

    public function aluminums()
    {
        return $this->hasMany(Aluminum::class, 'categoria_aluminio_id');
    }

    public function components()
    {
        return $this->hasMany(Component::class, 'categoria_componente_id');
    }

    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::where('nome', 'like', '%' . $search . '%')
            ->paginate($paginate);
    }

    public function findCategoryById($id){

        return self::find($id);

    }

    public function createCategory(array $input){

        return self::create($input);

    }

    public function updateCategory(array $input){

        return self::update($input);

    }

    public function deleteCategory(){

        return self::delete();

    }

    public static function getAllCategoriesByType($type){

        return self::where('tipo', $type)->get();

    }
}
