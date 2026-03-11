<?php

namespace App\Http\Middleware;

use App\Models\Property;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPermission
{
    protected static array $routePermissionMap = [
        'admin.dashboard' => 'dashboard.view',
        'admin.property-list' => 'properties.view',
        'admin.properties.edit' => 'properties.edit',
        'admin.properties.update' => 'properties.edit',
        'admin.properties.destroy' => 'properties.delete',
        'admin.properties.toggleVerified' => 'properties.verify',
        'admin.property.image.delete' => 'properties.edit',
        'admin.properties.duplicate' => 'properties.create',
        'admin.banners.index' => 'banners.view',
        'admin.banners.create' => 'banners.create',
        'admin.banners.store' => 'banners.create',
        'admin.banners.edit' => 'banners.edit',
        'admin.banners.update' => 'banners.edit',
        'admin.banners.destroy' => 'banners.delete',
        'admin.featured-sections.index' => 'carousels.view',
        'admin.featured-sections.create' => 'carousels.create',
        'admin.featured-sections.store' => 'carousels.create',
        'admin.featured-sections.edit' => 'carousels.edit',
        'admin.featured-sections.update' => 'carousels.edit',
        'admin.featured-sections.destroy' => 'carousels.delete',
        'admin.amenities.index' => 'amenities.view',
        'admin.amenities.create' => 'amenities.create',
        'admin.amenities.store' => 'amenities.create',
        'admin.amenities.edit' => 'amenities.edit',
        'admin.amenities.update' => 'amenities.edit',
        'admin.amenities.destroy' => 'amenities.delete',
        'admin.transactions.index' => 'transactions.view',
        'admin.transactions.create' => 'transactions.create',
        'admin.transactions.store' => 'transactions.create',
        'admin.transactions.edit' => 'transactions.edit',
        'admin.transactions.update' => 'transactions.edit',
        'admin.transactions.destroy' => 'transactions.delete',
        'admin.users.index' => 'users.view',
        'admin.users.edit' => 'users.view',
        'admin.users.update' => 'users.edit',
        'admin.users.destroy' => 'users.delete',
        'admin.users.toggleSuspend' => 'users.suspend',
        'admin.user-listings.index' => 'user-listings.view',
        'admin.user-listings.approve' => 'user-listings.approve',
        'admin.user-listings.reject' => 'user-listings.reject',
        'admin.notifications' => 'notifications.view',
        'admin.admin-users.index' => 'admin-users.view',
        'admin.admin-users.create' => 'admin-users.create',
        'admin.admin-users.store' => 'admin-users.create',
        'admin.admin-users.edit' => 'admin-users.edit',
        'admin.admin-users.update' => 'admin-users.edit',
        'admin.admin-users.destroy' => 'admin-users.delete',
        'admin.admin-users.toggleActive' => 'admin-users.edit',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        if ($admin->is_super_admin || is_protected_admin_email($admin->email)) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();
        if (! $routeName) {
            return $next($request);
        }

        $requiredPermission = self::$routePermissionMap[$routeName] ?? null;
        if ($requiredPermission === null) {
            return $next($request);
        }

        if ($admin->canAccess($requiredPermission)) {
            return $next($request);
        }

        // Allow edit/update for properties the admin created via duplicate (create but not edit permission)
        if ($requiredPermission === 'properties.edit') {
            $propertyId = $request->route('property') ?? $request->route('id');
            if ($propertyId && $admin->canAccess('properties.create')) {
                $property = Property::find($propertyId);
                if ($property && (int) $property->created_by_admin_id === (int) $admin->id) {
                    return $next($request);
                }
            }
        }

        abort(403, 'You do not have permission to perform this action.');
    }
}
