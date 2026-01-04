<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    protected $table = 'tbl_feeship';
    public $timestamps = false;
    protected $primaryKey = 'fee_id';

    protected $fillable = ['fee_maqh','fee_maxa', 'fee_matp','fee_ship'];

    public function City() {
    return $this->belongsTo('App\Models\City', 'fee_matp', 'matp');
}
public function Province() {
    return $this->belongsTo('App\Models\Province', 'fee_maqh', 'maqh');
}
public function Wards() {
    return $this->belongsTo('App\Models\Wards', 'fee_maxa', 'maxa');
}

}