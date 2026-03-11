<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Default landing routes for admins without dashboard permission (same order as sidebar).
     */
    protected static array $landingRoutePermissionMap = [
        'admin.dashboard' => 'dashboard.view',
        'admin.property-list' => 'properties.view',
        'admin.banners.index' => 'banners.view',
        'admin.featured-sections.index' => 'carousels.view',
        'admin.amenities.index' => 'amenities.view',
        'admin.transactions.index' => 'transactions.view',
        'admin.users.index' => 'users.view',
        'admin.notifications' => 'notifications.view',
        'admin.admin-users.index' => 'admin-users.view',
        'admin.user-listings.index' => 'user-listings.view',
    ];

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(AdminLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->to($this->defaultAdminRedirectUrl());
    }

    /**
     * Get the URL to redirect to after login. If admin has dashboard permission, use dashboard;
     * otherwise redirect to the first page they have view permission for.
     */
    protected function defaultAdminRedirectUrl(): string
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::guard('admin')->user();
        if (! $admin) {
            return route('admin.dashboard', absolute: false);
        }

        foreach (self::$landingRoutePermissionMap as $routeName => $permission) {
            if ($admin->canAccess($permission)) {
                return route($routeName, [], absolute: false);
            }
        }

        return route('admin.dashboard', absolute: false);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
