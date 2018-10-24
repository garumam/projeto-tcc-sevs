<?php

namespace App\Http\Controllers;

use App\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Financial;

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

        $titulotabs = ['Caixa', 'Receber'];

        if(!$request->ajax()){
            $allfinancial = Financial::getAll();
        }

        if($request->has('caixa') || !$request->ajax()){
            $financialsByPeriod = null;
            $financials = $this->financial->getWithSearchAndPagination($request->get('search'),$request->get('paginate'),$request->get('period'),$financialsByPeriod);
        }

        if($request->has('receber') || !$request->ajax()){
            $allInstallments = null;
            $installments = Installment::getPendingInstallmentsWithSearchAndPagination($request->get('search'),$request->get('paginate'),$allInstallments);
        }

        if ($request->ajax()){
            if($request->has('caixa'))
                return view('dashboard.list.tables.table-financial', compact('financialsByPeriod','financials'));

            if($request->has('receber'))
                return view('dashboard.list.tables.table-installments', compact('installments'));
        }



        return view('dashboard.list.financial', compact('allInstallments','installments','financialsByPeriod','allfinancial','financials','titulotabs'))->with('title', 'Financeiro');

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

        $financial = Financial::createFinancial(array_merge($request->all(),['usuario_id' => Auth::user()->id]));
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
            'descricao' => 'nullable|string|max:100',
            'valor' => 'required|numeric'
        ]);

        return $validator;
    }
}
