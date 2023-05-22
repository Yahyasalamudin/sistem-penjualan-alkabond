<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function suratJalan($invoice)
    {
        $transaction = Transaction::with('sales')->with('stores')->with('transaction_details')->where('invoice_code', $invoice)->first();

        $pdf = Pdf::loadview('reports.suratJalan', compact("transaction"));
        return $pdf->stream();
    }

    public function transactionReport()
    {
        $pdf = Pdf::loadview('reports.transactionReport');
        return $pdf->stream();
    }

    public function incomeReport()
    {
        $pdf = Pdf::loadview('reports.incomeReport');
        return $pdf->stream();
    }
}
