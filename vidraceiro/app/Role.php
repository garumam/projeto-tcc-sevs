<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function addPermission($permission)
    {
        if (!empty($permission)) {
            return !$this->permissions()->where('nome', $permission->nome)->first() ? $this->permissions()->save($permission) : false;
        }
        return false;
    }

    public function removePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::where('nome', 'like', '%' . $search . '%')
            ->paginate($paginate);
    }

    public function findRoleById($id){

        return self::find($id);

    }

    public function createRole(array $input){

        return self::create($input);

    }

    public function updateRole(array $input){

        return self::update($input);

    }

    public function deleteRole(){

        return self::delete();

    }

    public static function getAll(){

        return self::all();

    }

    public static function getRoleByUserIdWithSearchAndPagination($id, $search, $paginate){

        $paginate = $paginate ?? 10;

        return self::with('users')
            ->whereHas('users', function ($q) use ($id) {
                $q->where('user_id', '=', $id);
            })
            ->where('nome', 'like', '%' . $search . '%')
            ->paginate($paginate);

    }
}
