<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tbl_roles';
    public $timestamps = false;
    protected $primaryKey = 'role_id';

    protected $fillable = ['role_name','description'];

    public function admin()
    {
        return $this->belongsToMany(Admin::class, 'admin_roles', 'role_id', 'admin_id');
    }
}
