<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function findPermissionById($id){

        return self::find($id);

    }

    public static function getAll(){

        return self::all();

    }

    public static function getPermissionsByRoleIdWithSearchAndPagination($id, $search, $paginate){

        $paginate = $paginate ?? 10;

        return self::with('roles')
            ->whereHas('roles', function ($q) use ($id) {
                $q->where('role_id', '=', $id);
            })
            ->where('nome', 'like', '%' . $search . '%')
            ->paginate($paginate);

    }
}
