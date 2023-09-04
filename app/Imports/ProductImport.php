<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Type;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    public function model(array $row)
    {
        $type = Type::where('type', $row[1])->first();

        return new Product([
            'product_code' => $row[0],
            'product_name' => $type->type,
            'product_brand' => $row[2],
            'unit_weight' => $row[3],
        ]);
    }
}
