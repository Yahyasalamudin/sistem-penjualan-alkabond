<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\Store;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

    public function transaction_report(Request $request)
    {
        $filter = $request->status;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $stores = Store::all();

        $transactions = Transaction::when($request->store_id, function ($query) use ($request) {
            return $query->where('store_id', $request->store_id);
        })->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->get();

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
                    if ($request->excel == 1) {
                        return Excel::download(new TransactionExport($transactions, $start_date, $end_date), 'transactions.xlsx');
                    } elseif ($request->pdf == 1) {
                        $pdf = Pdf::loadview('reports.prints.transaction-pdf', compact('transactions', 'start_date', 'end_date'));
                        return $pdf->stream();
                    }

                    return view('reports.transaction-report', compact('transactions', 'stores'));
            }
        }

        if ($request->excel == 1) {
            return Excel::download(new TransactionExport($transactions, $start_date, $end_date), 'transactions.xlsx');
        } elseif ($request->pdf == 1) {
            $pdf = Pdf::loadview('reports.prints.transaction-pdf', compact('transactions', 'start_date', 'end_date'));
            return $pdf->stream();
        }
        return view('reports.transaction-report', compact('transactions', 'stores'));
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
