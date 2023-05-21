<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function SuratJalan($invoice)
    {
        $transaction = Transaction::with('sales')->with('stores')->with('transaction_details')->where('invoice_code', $invoice)->first();

        $pdf = Pdf::loadview('reports.suratJalan', compact("transaction"));
        return $pdf->stream();
    }
}
