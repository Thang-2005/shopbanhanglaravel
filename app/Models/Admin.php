<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Admin extends Model
{
    protected $table = 'tbl_admin';
    public $timestamps = false;
    protected $primaryKey = 'admin_id';

    protected $fillable = ['admin_name','admin_email','admin_phone','admin_password'];

    // Quan hệ nhiều-nhiều với role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_roles', 'admin_id', 'role_id');
    }
    public function getAuthPassword(){
        return $this->admin_password;
    }
}
