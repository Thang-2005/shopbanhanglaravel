<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'tbl_permissions';
    protected $primaryKey = 'permission_id';
    
    protected $fillable = [
        'permission_name',
        'permission_desc',
        'permission_module'
    ];

    // Một permission thuộc nhiều roles
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'tbl_role_permission',
            'permission_id',
            'role_id'
        );
    }
}