<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'tbl_banner';
    protected $primaryKey = 'banner_id';
    public $timestamps = false;

    protected $fillable = [
        'banner_name', 'banner_image', 'banner_status','banner_desc'
    ];
}
