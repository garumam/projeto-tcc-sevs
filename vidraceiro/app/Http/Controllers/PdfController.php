<?php

namespace App\Http\Controllers;

use App\Budget;

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
        return view('dashboard.create.pdf')->with('title','Gerar PDF');
    }

    public function store()
    {

    }

    public function show()
    {

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
