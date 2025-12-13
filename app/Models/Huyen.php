<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Huyen extends Model
{
     protected $table = 'tbl_huyen';
    public $timestamps = false;
    protected $primaryKey = 'maqh';

    protected $fillable = ['name_huyen','type', 'matp'];
}
