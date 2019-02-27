<?php

namespace App\Http\Controllers\Api;

use App\Budget;
use App\Client;
use App\Financial;
use App\Http\Controllers\Controller;
use App\Order;
use App\Company;
use App\Provider;
use App\Storage;
use App\Sale;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function __construct()
    {

    }
    
    //O show MOSTRA OS PDFS NOS MENUS RESPECTIVAS(BUDGETS, ORDER E ETC..)
    public function show($tipo, $id)
    {
        $company = new Company();
        $company = $company->getCompany();
        $pdf = null;
        $nomearquivo = '';

        switch($tipo){
            case 'budget':
                $budget = new Budget();
                $budget = $budget->findBudgetById($id);
                $pdf = PDF::loadView('dashboard.pdf.budget', compact('budget','company'))->setPaper('A3','portrait');
                $nomearquivo = 'orcamento.pdf';

                break;
            case 'order':
                $order = new Order();
                $order = $order->findOrderById($id);
                $pdf = PDF::loadView('dashboard.pdf.order', compact('order','company'))->setPaper('A3','portrait');
                $nomearquivo = 'ordem_servico.pdf';

                break;
            case 'order-comprar':
                $order = new Order();
                $order = $order->findOrderById($id);
                $pdf = PDF::loadView('dashboard.pdf.order-comprar', compact('order','company'));
                $nomearquivo = 'OS_comprar.pdf';

                break;
            case 'client':
                $client = new Client();
                $client = $client->findClientById($id);
                $pdf = PDF::loadView('dashboard.pdf.client', compact('client','company'));
                $nomearquivo = 'cliente.pdf';

                break;
            case 'sale':
                $sale = new Sale();
                $sale = $sale->findSaleById($id);
                $pdf = PDF::loadView('dashboard.pdf.sale', compact('sale','company'));
                $nomearquivo = 'venda.pdf';

                break;
            case 'provider':
                $provider = new Provider();
                $provider = $provider->findProviderById($id);
                $pdf = PDF::loadView('dashboard.pdf.provider', compact('provider','company'));
                $nomearquivo = 'fornecedor.pdf';

                break;
        }

        return $pdf->stream($nomearquivo);

    }

}
