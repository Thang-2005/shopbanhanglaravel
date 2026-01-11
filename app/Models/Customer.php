<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tbl_customers';
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'customer_name', 'customer_email', 'customer_password', 'customer_phone', 'role','google_id','facebook_id','login_type'
    ];
}   
