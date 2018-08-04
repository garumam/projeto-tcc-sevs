<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
}
