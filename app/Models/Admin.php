<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tbl_admin';
    protected $primaryKey = 'admin_id';
    
    protected $fillable = [
        'admin_name',
        'admin_email',
        'admin_password',
        'admin_phone',
        'role_id'
    ];

    /**
     * Quan hệ: Một admin thuộc một role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * Kiểm tra admin có role nhất định
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->role_name === $roleName;
    }

    /**
     * Kiểm tra admin có bất kỳ role nào trong mảng
     */
    public function hasAnyRole($roles)
    {
        if (!$this->role) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($this->role->role_name, $roles);
        }

        return $this->hasRole($roles);
    }

    /**
     * Kiểm tra admin có permission cụ thể
     */
    public function hasPermission($permissionName)
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()->where('permission_name', $permissionName)->exists();
    }

    /**
     * Lấy tất cả permission của admin
     */
    public function getPermissions()
    {
        if (!$this->role) {
            return collect();
        }
        
        return $this->role->permissions;
    }
}
