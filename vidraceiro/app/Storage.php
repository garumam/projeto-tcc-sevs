<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $guarded = [];
    
    public function glass()
    {
        return $this->belongsTo(
            Glass::class,
            'glass_id'
        );
    }

    public function aluminum()
    {
        return $this->belongsTo(
            Aluminum::class,
            'aluminum_id'
        );
    }

    public function component()
    {
        return $this->belongsTo(
            Component::class,
            'component_id'
        );
    }

    public function sales(){
        return $this->belongsToMany(
            Sale::class,
            'storage_sale',
            'estoque_id',
            'venda_id'
        )->withPivot('qtd_reservada');
    }


    public function updateStorage($column,$value){

        return self::update([$column => $value]);

    }

    public static function createStorage(array $input){
        return self::create($input);
    }

    public static function getFirstStorageWhere($column, $value){
        return self::where($column,$value)->first();
    }

    public static function filterStorages($request, &$glasses, &$aluminums, &$components){

        $material = $request->material;
        $qtd_de = $request->qtd_de;
        $qtd_ate = $request->qtd_ate;
        $ordenar = $request->ordenar;

        if($material === 'TODOS') {
            $glasses = self::with('glass')->where('glass_id', '!=', null);
            $aluminums = self::with('aluminum')->where('aluminum_id', '!=', null);
            $components = self::with('component')->where('component_id', '!=', null);
        }else{
            if($material === 'glass_id'){
                $glasses = self::with('glass')->where('glass_id', '!=', null);
            }elseif($material === 'aluminum_id'){
                $aluminums = self::with('aluminum')->where('aluminum_id', '!=', null);
            }elseif($material === 'component_id'){
                $components = self::with('component')->where('component_id', '!=', null);
            }
        }

        if($qtd_de !== null || $qtd_ate !== null){

            switch($material){
                case 'TODOS':
                case 'glass_id':

                    $glasses = $glasses->where(function ($q) use ($qtd_de,$qtd_ate){
                        if($qtd_ate !== null)
                            $q->where('metros_quadrados','<=',$qtd_ate);

                        if($qtd_de !== null)
                            $q->where('metros_quadrados','>=',$qtd_de);
                    });

                    if($material !== 'TODOS')
                        break;
                case 'aluminum_id':

                    $aluminums = $aluminums->where(function ($q) use ($qtd_de,$qtd_ate){
                        if($qtd_ate !== null)
                            $q->where('qtd','<=',$qtd_ate);

                        if($qtd_de !== null)
                            $q->where('qtd','>=',$qtd_de);
                    });

                    if($material !== 'TODOS')
                        break;
                case 'component_id':

                    $components = $components->where(function ($q) use ($qtd_de,$qtd_ate){
                        if($qtd_ate !== null)
                            $q->where('qtd','<=',$qtd_ate);

                        if($qtd_de !== null)
                            $q->where('qtd','>=',$qtd_de);
                    });

                    if($material !== 'TODOS')
                        break;
            }

        }


        if($ordenar !== 'nao') {
            if ($material === 'TODOS') {
                $glasses = $glasses->orderBy('metros_quadrados',$ordenar);
                $aluminums = $aluminums->orderBy('qtd',$ordenar);
                $components = $components->orderBy('qtd',$ordenar);
            } else {
                if ($glasses !== null) {
                    $glasses = $glasses->orderBy('metros_quadrados',$ordenar);
                } elseif ($aluminums !== null) {
                    $aluminums = $aluminums->orderBy('qtd',$ordenar);
                } elseif ($components !== null) {
                    $components = $components->orderBy('qtd',$ordenar);
                }
            }
        }
        if($material === 'TODOS'){
            $glasses = $glasses->get();
            $aluminums = $aluminums->get();
            $components = $components->get();
        }else{
            if($glasses !== null){
                $glasses = $glasses->get();
            }elseif($aluminums !== null){
                $aluminums = $aluminums->get();
            }elseif($components !== null){
                $components = $components->get();
            }
        }

    }
}
