<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdeDetails extends Model
{
    protected $table = 'tbl_order_details';
    protected $primaryKey = 'order_details_id';
    public $timestamps = false;
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'product_price', 'product_sales_quantity', 'product_coupon', 'product_feeship','order_code'
    ];
}
