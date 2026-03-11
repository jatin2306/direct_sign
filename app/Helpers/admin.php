<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('admin_can')) {
    /**
     * Check if the current admin user has the given permission.
     * Super admins always have full access.
     */
    function admin_can(string $permission): bool
    {
        $admin = Auth::guard('admin')->user();
        return $admin && $admin->canAccess($permission);
    }
}

if (! function_exists('is_protected_admin_email')) {
    /**
     * Check if the given email is the protected super admin email (from config).
     * This user cannot be edited, deactivated, deleted, or created again.
     */
    function is_protected_admin_email(?string $email): bool
    {
        if ($email === null || $email === '') {
            return false;
        }
        $super = config('admin.super_email');
        if ($super === null || $super === '') {
            return false;
        }
        return strtolower(trim($email)) === strtolower(trim($super));
    }
}
