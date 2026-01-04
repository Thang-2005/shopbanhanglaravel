<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $table = 'tbl_product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name', 'product_price', 'product_desc', 'product_quantity','product_content', 'product_image', 'category_id', 'brand_id', 'product_status'
    ];
}
