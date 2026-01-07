<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tbl_roles';
    protected $primaryKey = 'role_id';
    
    protected $fillable = [
        'role_name',
        'role_desc',
        'role_status'
    ];

    // Một role có nhiều permissions
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'tbl_role_permission',
            'role_id',
            'permission_id'
        );
    }

    // Một role có nhiều admins
    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id', 'role_id');
    }
}