<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImportProduct implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'product_name'    => $row['product_name'],
            'category_id'     => (int) $row['category_id'],
            'brand_id'        => (int) $row['brand_id'],
            'product_desc'    => $row['product_desc'],
            'product_content' => $row['product_content'],
            'product_price'   => $row['product_price'],
            'product_image'   => $row['product_image'],
            'product_status'  => (int) $row['product_status'],
        ]);
    }
}
