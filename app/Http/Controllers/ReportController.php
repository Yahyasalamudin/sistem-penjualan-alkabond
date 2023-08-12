<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function suratJalan($invoice)
    {
        $transaction = Transaction::with('sales')->with('stores')->with('transaction_details')->where('invoice_code', $invoice)->first();

        $pdf = Pdf::loadview('reports.prints.suratJalan', compact("transaction"));
        return $pdf->stream();
    }

    public function struk($invoice)
    {
        $transaction = Transaction::with('sales')->with('stores')->with('transaction_details')->where('invoice_code', $invoice)->first();

        $pdf = Pdf::loadview('reports.prints.struk', compact("transaction"));
        return $pdf->stream();
    }

    public function transactionReport()
    {
        return view('reports.transactionReport');
    }

    public function printTransactionReport(Request $request)
    {
        $filter = $request->status;
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        $transactions = Transaction::whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();

        if ($filter != "semua") {
            switch ($filter) {
                case 'unsent':
                    $transactions = $transactions->where('delivery_status', 'unsent');
                    break;
                case 'process':
                    $transactions = $transactions->where('delivery_status', 'proccess');
                    break;
                case 'sent':
                    $transactions = $transactions
                        ->where('status', 'unpaid')
                        ->where('delivery_status', 'sent');
                    break;
                case 'partial':
                    $transactions = $transactions
                        ->where('payment_method', 'tempo')
                        ->where('status', 'partial');
                    break;
                case 'paid':
                    $transactions = $transactions->where('status', 'paid');
                    break;
                default:
                    $pdf = Pdf::loadview('reports.prints.transactionReport', compact('transactions', 'tgl_awal', 'tgl_akhir'));
                    return $pdf->stream();
            }
        }

        $pdf = Pdf::loadview('reports.prints.transactionReport', compact('transactions', 'tgl_awal', 'tgl_akhir'));
        return $pdf->stream();
    }

    public function incomeReport()
    {
        $transactions = Transaction::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(id) as transaction_count'),
            DB::raw('SUM(grand_total) as transaction_gross'),
            DB::raw('SUM(grand_total - remaining_pay) as transaction_net'),
        )
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->get();

        $pdf = Pdf::loadview('reports.prints.incomeReport', compact('transactions'));
        return $pdf->stream();
    }
}
