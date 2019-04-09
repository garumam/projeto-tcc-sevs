<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'tipo',
        'grupo_imagem'
    ];

    public function mproducts()
    {
        return $this->hasMany(MProduct::class, 'categoria_produto_id');
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

    public function getWithSearchAndPagination($search, $paginate, $restore = false)
    {

        $paginate = $paginate ?? 10;

        $queryBuilder = self::where('nome', 'like', '%' . $search . '%')
                        ->orWhere('tipo', 'like', '%' . $search . '%')
                        ->orWhere('grupo_imagem', 'like', '%' . $search . '%');

        if ($restore)
            $queryBuilder = $queryBuilder->onlyTrashed();

        return $queryBuilder->paginate($paginate);
    }

    public function findCategoryById($id)
    {

        return self::find($id);

    }

    public function restoreCategoryById($id)
    {

        $category = self::onlyTrashed()->find($id);

        return $category ? $category->restore() : false;
    }

    public function createCategory(array $input)
    {

        return self::create($input);

    }

    public function updateCategory(array $input)
    {

        return self::update($input);

    }

    public function deleteCategory()
    {

        return self::delete();

    }

    public static function getAllCategoriesByType($type)
    {

        return self::where('tipo', $type)->get();

    }

    public static function getAllCategoriesByTypeApi($type)
    {

        return self::with('glasses', 'aluminums', 'components', 'mproducts.glasses', 'mproducts.aluminums', 'mproducts.components')->where('tipo', $type)->get();

    }

    public static function getAllCategoriesMaterials()
    {

        return self::with([
                'glasses' => function ($query) {
                    $query->where('is_modelo', '=', '1');
                },
                'aluminums' => function ($query) {
                    $query->where('is_modelo', '=', '1');
                }, 'components' => function ($query) {
                    $query->where('is_modelo', '=', '1');
                }
            ]
        )->where('tipo', '<>', 'produto')->get();

    }
}
