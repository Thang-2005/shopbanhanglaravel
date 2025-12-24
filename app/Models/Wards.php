<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
     protected $table = 'tbl_xa';
    public $timestamps = false;
    protected $primaryKey = 'maxa';

    protected $fillable = ['name_xa','type','maqh'];
}
