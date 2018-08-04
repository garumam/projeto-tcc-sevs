<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluminum extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_aluminio_id');
    }
}
