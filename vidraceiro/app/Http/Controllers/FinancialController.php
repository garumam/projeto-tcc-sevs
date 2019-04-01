<?php

namespace App\Http\Controllers;

use App\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Financial;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FinancialController extends Controller
{
    protected $financial;

    public function __construct(Financial $financial)
    {
        $this->middleware('auth');
        $this->financial = $financial;
    }

    public function index(Request $request)
    {
        if(!Auth::user()->can('financeiro_listar', Financial::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $titulotabs = ['Caixa', 'Receber','Pagar'];

        if(!$request->ajax()){
            $allfinancial = Financial::getAllByStatus('CONFIRMADO');
        }

        if($request->has('caixa') || !$request->ajax()){
            $financialsByPeriod = null;
            $financials = $this->financial->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),$request->get('period'),$financialsByPeriod,false,'CONFIRMADO');
        }

        if($request->has('receber') || !$request->ajax()){
            $allInstallments = Installment::getPendingInstallmentsBySearch($request->get('search'));
            $pendingFinancials = null;
            $this->financial->getWithSearchAndPagination($request->get('search'),null,'tudo',$pendingFinancials,false,'PENDENTE','RECEITA');
            
            foreach($allInstallments as $install){
                $pendingFinancials->push($install);
            }
            $receberOuPagar = 'receber';
            $paginate = $request->get('paginate') ?? 10;
            $futureReceipts = $this->paginate($pendingFinancials,$paginate,$request->page);
            
        }

        if($request->has('pagar') || !$request->ajax()){
            $payPending = null;
            $this->financial->getWithSearchAndPagination($request->get('search'),null,'tudo',$payPending,false,'PENDENTE','DESPESA');
            
            $receberOuPagar = 'pagar';

            $paginate = $request->get('paginate') ?? 10;
            $futurePayments = $this->paginate($payPending,$paginate,$request->page);
            
        }

        
        if ($request->ajax()){
            if($request->has('caixa'))
                return view('dashboard.list.tables.table-financial', compact('financialsByPeriod','financials'));

            if($request->has('receber'))
                return view('dashboard.list.tables.table-receber-pagar', compact('futureReceipts','receberOuPagar'));

            if($request->has('pagar'))
                return view('dashboard.list.tables.table-receber-pagar', compact('futurePayments','receberOuPagar'));
        }



        return view('dashboard.list.financial', compact('payPending','pendingFinancials','futureReceipts','futurePayments','financialsByPeriod','allfinancial','financials','titulotabs'))->with('title', 'Financeiro');

    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('financeiro_adicionar', Financial::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $validado = $this->rules_financial($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $financial = Financial::createFinancial(array_merge($request->all(),['usuario_id' => Auth::user()->id, 'status'=>$request->status]));
        if ($financial) {
            $mensagem = '';
            if ($financial->tipo === 'RECEITA') {
                $mensagem = 'Receita';
            } else {
                $mensagem = 'Despesa';
            }
            return redirect()->back()->with('success', $mensagem . ' adicionada com sucesso');
        }


    }

    public function update($id){

        $financial = $this->financial->findFinancialById($id);

        if($financial){
            $financial->updateFinancial(['data_vencimento'=>date_format(today(),'Y-m-d'),'status'=>'CONFIRMADO']);
            return redirect()->back()->with('success', 'Movimentação confirmada com sucesso');
        }
        return redirect()->back()->with('error', 'Falha ao confirmar movimentação financeira');
    }

    public function destroy($id)
    {
        if(!Auth::user()->can('financeiro_deletar', Financial::class)){
            return redirect('/home')->with('error', 'Você não tem permissão para acessar essa página');
        }

        $financial = $this->financial->findFinancialById($id);
        if ($financial) {
            $mensagem = '';
            if ($financial->tipo === 'RECEITA') {
                $mensagem = 'Receita';
            } else {
                $mensagem = 'Despesa';
            }
            $financial->deleteFinancial();
            return redirect()->back()->with('success', $mensagem . ' deletada com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao deletar item');
        }
    }

    public function rules_financial(array $data)
    {
        $validator = Validator::make($data, [
            'tipo' => [
                'required',
                Rule::in(['RECEITA', 'DESPESA'])
            ],
            'status' => [
                'required',
                Rule::in(['CONFIRMADO', 'PENDENTE'])
            ],
            'descricao' => 'nullable|string|max:100',
            'valor' => 'required|numeric',

        ]);

        return $validator;
    }
}
