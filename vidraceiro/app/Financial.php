<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Financial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tipo',
        'descricao',
        'valor',
        'pagamento_id',
        'usuario_id'
    ];

    public function payment(){
        return $this->belongsTo(Payment::class, 'pagamento_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function getWithSearchAndPagination($search, $paginate){

        $paginate = $paginate ?? 10;

        return self::where('descricao', 'like', '%' . $search . '%')
            ->orWhere('tipo', 'like', '%' . $search . '%')
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })
            ->paginate($paginate);
    }

    public function findFinancialById($id){

        return self::find($id);

    }

    public function deleteFinancial(){

        return self::delete();

    }

    public static function getAll(){

        return self::all();

    }

    public static function createFinancial(array $input){

        return self::create($input);

    }

    public static function filterFinancial($request){

        $tipo_financa = $request->tipo_financa;
        $financials = new Financial();
        $valor_inicial = $request->valor_inicial;
        $valor_final = $request->valor_final;
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $valorentrou = $dataentrou = false;
        if($valor_inicial < $valor_final){
            $valorentrou = true;
        }

        if(strtotime($data_inicial) < strtotime($data_final)){

            $dataentrou = true;
        }

        if($valorentrou || $dataentrou){

            $financials =  self::where(function ($query) use ($data_inicial,$data_final, $valor_inicial,$valor_final,$valorentrou,$dataentrou){
                if($dataentrou){
                    $query->whereBetween('created_at', [$data_inicial,$data_final]);
                }

                if($valorentrou){
                    $query->whereBetween('valor', [$valor_inicial,$valor_final]);
                }
            });
        }

        if($tipo_financa === 'TODOS'){
            $financials = $financials->get();
        }else{
            $financials = $financials->where('tipo',$tipo_financa)->get();
        }
        return $financials;

    }
}
