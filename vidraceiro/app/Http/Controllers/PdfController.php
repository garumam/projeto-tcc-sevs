<?php

namespace App\Http\Controllers;

use App\Budget;
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
        return view('dashboard.create.pdf', compact('budgets'))->with('title', 'Gerar PDF');
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
        $budget = Budget::with('products')->find($request->idorcamento);
        $pdf = PDF::loadView('dashboard.pdf.budget', compact('budget'));
        return $pdf->stream('orcamento.pdf');
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
