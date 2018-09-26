<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'largura',
        'altura',
        'qtd',
        'localizacao',
        'valor_mao_obra',
        'm_produto_id',
        'budget_id'
    ];

    public function mproduct(){
        return $this->belongsTo(MProduct::class, 'm_produto_id');
    }

    public function glasses(){
        return $this->hasMany(
            Glass::class,
            'product_id'
        );
    }
    public function aluminums(){
        return $this->hasMany(
            Aluminum::class,
            'product_id'
        );
    }
    public function components(){
        return $this->hasMany(
            Component::class,
            'product_id'
        );
    }

    public function budget(){
        return $this->belongsTo(
            Budget::class,
            'budget_id'
        );
    }

    public function createProduct(array $input){

        return self::create($input);

    }

    public function updateProduct(array $input){

        return self::update($input);

    }

    public function deleteProduct(){

        return self::delete();

    }

    public function findProductById($id){

        return self::find($id);

    }

    public static function findProductsWithRelations(array $ids){

        return self::with('budget','glasses', 'aluminums', 'components')->wherein('id', $ids)->get();

    }

}
