<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_componente_id');
    }
}
