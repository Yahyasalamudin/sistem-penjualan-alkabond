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
    protected $products, $start_month, $end_month, $product_type;

    public function __construct($products, $start_month, $end_month, $product_type)
    {
        $this->products = $products;
        $this->start_month = $start_month;
        $this->end_month = $end_month;
        $this->product_type = $product_type;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        $title = $this->product_type ? $this->product_type : '';

        return [
            [
                'Laporan Barang Terjual ' . $title . ' Dari Bulan ' . Carbon::parse($this->start_month)->locale('id')->isoFormat('MMMM') . ' Sampai ' . Carbon::parse($this->end_month)->locale('id')->isoFormat('MMMM')
            ],
            [
                'No',
                'Kode Produk',
                'Nama Produk',
                'Merk Produk',
                'Satuan Berat',
                'Total Terjual',
            ]
        ];
    }

    public function map($product): array
    {
        static $i = 1;

        return [
            $i++,
            $product->product_code,
            $product->product_name,
            $product->product_brand,
            $product->unit_weight,
            $product->total_quantity,
        ];
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
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:F1');

        return [
            'A' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'B' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'C' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'D' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'E' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'F' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
        ];
    }
}