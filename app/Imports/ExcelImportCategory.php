<?php

namespace App\Imports;

use App\Models\CategoryProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImportCategory implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CategoryProduct([
             'category_name'   => $row['0'],
            'category_desc'   => $row['1'],
            'category_status' => (int) $row['2'],
             'meta_keywords'   => $row['3'], 
        ]);
    }
}
