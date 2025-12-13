<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    protected $table = 'tbl_feeship';
    public $timestamps = false;
    protected $primaryKey = 'fee_id';

    protected $fillable = ['fee_maqh','fee_maxa', 'fee_matp','fee_ship'];

    public function tinh() {
    return $this->belongsTo('App\Models\Tinh', 'fee_matp', 'matp');
}
public function huyen() {
    return $this->belongsTo('App\Models\Huyen', 'fee_maqh', 'maqh');
}
public function xa() {
    return $this->belongsTo('App\Models\Xa', 'fee_maxa', 'maxa');
}

}