<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
   protected $table = 'tbl_category_product';
    protected $primaryKey = 'category_id';
    public $timestamps = false;
    protected $fillable = [
        'category_name','category_desc','category_status','meta_keywords',
    ]; 
}
