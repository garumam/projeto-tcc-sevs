<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Category;

class Glass extends Model
{
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_glass',
            'vidro_id',
            'produto_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_vidro_id');
    }
}
