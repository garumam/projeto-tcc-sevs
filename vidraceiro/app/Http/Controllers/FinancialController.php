<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
        $allfinancial = Financial::getAll();
        $financials = $this->financial->getWithSearchAndPagination($request->get('search'),$request->get('paginate'));
        if ($request->ajax())
            return view('dashboard.list.tables.table-financial', compact('allfinancial','financials'));


        return view('dashboard.list.financial', compact('allfinancial','financials'))->with('title', 'Financeiro');

    }

    public function store(Request $request)
    {
        $validado = $this->rules_financial($request->all());
        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado);
        }

        $financial = Financial::createFinancial($request->all());
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
