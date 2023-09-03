<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BestSellerProductExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    protected $products, $start_date, $end_date;

    public function __construct($products, $start_date, $end_date)
    {
        $this->products = $products;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        return [
            [
                'Laporan Transaksi Dari ' . Carbon::parse($this->start_date)->locale('id')->isoFormat('D MMMM Y') . ' Sampai Tanggal ' . Carbon::parse($this->end_date)->locale('id')->isoFormat('D MMMM Y')
            ],
            [
                'No',
                'Invoice Code',
                'Nama Toko',
                'Nama Sales',
                'Metode Pembayaran',
                'Status Pembayaran',
                'Status Pengiriman',
                'Tanggal Transaksi',
                'Total Transaksi',
            ]
        ];
    }

    public function map($transaction): array
    {
        static $i = 1;

        return [
            $i++,
            $transaction->invoice_code,
            $transaction->stores->store_name,
            $transaction->sales->sales_name,
            $transaction->payment_method ?: '-',
            $this->payment_status($transaction->status),
            $this->delivery_status($transaction->delivery_status),
            $transaction->created_at->format('d F Y'),
            'Rp ' . number_format($transaction->grand_total),
        ];
    }

    public function payment_status($status)
    {
        switch ($status) {
            case 'paid':
                return 'Dibayar';
            case 'unpaid':
                return 'Belum Dibayar';
            case 'partial':
                return 'Dicicil';
            default:
                return $status;
        }
    }

    public function delivery_status($delivery_status)
    {
        switch ($delivery_status) {
            case 'unsent':
                return 'Belum Dikirim';
            case 'proccess':
                return 'Proses';
            case 'sent':
                return 'Dikirim';
            default:
                return $delivery_status;
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            // No
            'B' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            // Invoice Code
            'C' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            // Nama Toko
            'D' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            // Nama Sales
            'E' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            // Metode Pembayaran
            'F' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            // Status Pembayaran
            'G' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            // Status Pengiriman
            'H' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            // Tanggal Transaksi
            'I' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Total
        ];
    }
}