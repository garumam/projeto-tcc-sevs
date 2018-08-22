<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Order;
use App\Company;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $budgets = Budget::all();
        $orders = Order::all();
        return view('dashboard.create.pdf', compact('budgets','orders'))->with('title', 'Gerar PDF');
    }

    public function create()
    {
        return view('dashboard.create.pdf')->with('title', 'Gerar PDF');
    }

    public function store(Request $request)
    {

    }

    public function show(Request $request)
    {
        $company = Company::all()->first();
        $pdf = null;
        $nomearquivo = '';
        if($request->has('idorcamento') && $request->idorcamento != ''){
            $budget = Budget::with('products')->find($request->idorcamento);
            $pdf = PDF::loadView('dashboard.pdf.budget', compact('budget','company'));
            $nomearquivo = 'orcamento.pdf';
        }else{
            $order = Order::with('budgets.products')->find($request->idordem);
            $pdf = PDF::loadView('dashboard.pdf.order', compact('order','company'));
            $nomearquivo = 'ordem_servico.pdf';
        }


        return $pdf->stream($nomearquivo);
    }

    public function edit()
    {

    }


    public function update()
    {

    }

    public function destroy()
    {

    }
}
