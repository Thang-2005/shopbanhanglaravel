<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'tbl_coupon';
    protected $primaryKey = 'coupon_id';
    public $timestamps = false;
    protected $fillable = [
        'coupon_name', 'coupon_code', 'coupon_time', 'coupon_condition', 'coupon_number'
    ];
}
