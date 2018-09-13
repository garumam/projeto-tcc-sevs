<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

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
}
