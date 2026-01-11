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
        'role_id',
        'is_super'
    ];

    /**
     * =========================
     * RELATIONSHIPS
     * =========================
     */

    // Một admin thuộc một role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * =========================
     * ROLE CHECK
     * =========================
     */

    // Kiểm tra admin có role cụ thể
    public function hasRole($roleName)
    {
        return $this->role && $this->role->role_name === $roleName;
    }

    // Kiểm tra admin có 1 trong các role
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
     * =========================
     * PERMISSION CHECK
     * =========================
     */

    // Kiểm tra admin có permission cụ thể
    public function hasPermission($permissionName)
    {
        // ADMIN luôn có toàn quyền
        if ($this->role && $this->role->role_name === 'admin') {
            return true;
        }

        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()
            ->where('permission_name', $permissionName)
            ->exists();
    }

    // Lấy toàn bộ permission của admin
    public function getPermissions()
    {
        // Admin lấy toàn bộ permission
        if ($this->role && $this->role->role_name === 'admin') {
            return Permission::all();
        }

        if (!$this->role) {
            return collect();
        }

        return $this->role->permissions;
    }
}
