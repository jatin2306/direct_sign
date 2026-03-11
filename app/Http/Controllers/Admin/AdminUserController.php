<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Support\AdminPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    private function currentAdmin(): Admin
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();
        return $admin;
    }

    private function onlySuperAdmin(): void
    {
        if (! $this->currentAdmin()->is_super_admin) {
            abort(403, 'Only a super admin can perform this action.');
        }
    }

    public function index()
    {
        $admins = Admin::orderBy('name')->get();
        return view('admin.admin-users.index', compact('admins'));
    }

    public function create()
    {
        $this->onlySuperAdmin();
        return view('admin.admin-users.create', [
            'permissionConfig' => AdminPermission::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->onlySuperAdmin();

        $superEmail = strtolower(trim(config('admin.super_email', '')));
        $emailRules = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:admins,email'];
        if ($superEmail !== '') {
            $emailRules[] = Rule::notIn([$superEmail]);
        }
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => $emailRules,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_super_admin' => ['nullable', 'boolean'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(AdminPermission::allFlattened())],
        ], [
            'email.not_in' => 'This email is reserved for the primary super admin and cannot be used for new accounts.',
        ]);

        $permissions = $request->boolean('is_super_admin') ? null : AdminPermission::ensureViewForPermissions($validated['permissions'] ?? []);
        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_super_admin' => $request->boolean('is_super_admin'),
            'permissions' => $permissions,
            'is_active' => true,
        ]);

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user created.');
    }

    public function edit($id)
    {
        $adminUser = Admin::findOrFail($id);
        $isProtected = is_protected_admin_email($adminUser->email);
        // Protected account: only the same user can open edit (to change password); others get 403
        if ($isProtected && $adminUser->id !== $this->currentAdmin()->id) {
            abort(403, 'This admin account is protected and cannot be edited.');
        }
        return view('admin.admin-users.edit', [
            'adminUser' => $adminUser,
            'permissionConfig' => AdminPermission::all(),
            'isProtected' => $isProtected,
        ]);
    }

    public function update(Request $request, $id)
    {
        $adminUser = Admin::findOrFail($id);
        $isProtected = is_protected_admin_email($adminUser->email);
        if ($isProtected && $adminUser->id !== $this->currentAdmin()->id) {
            abort(403, 'This admin account is protected and cannot be edited.');
        }

        if ($isProtected) {
            // Protected account: only name and password can be updated
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            ]);
            $adminUser->name = $validated['name'];
            if (! empty($validated['password'])) {
                $adminUser->password = Hash::make($validated['password']);
            }
            $adminUser->save();
            return redirect()->route('admin.admin-users.index')->with('success', 'Admin user updated.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($adminUser->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'is_super_admin' => ['nullable', 'boolean'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(AdminPermission::allFlattened())],
        ]);

        $adminUser->name = $validated['name'];
        $adminUser->email = $validated['email'];
        if (! empty($validated['password'])) {
            $adminUser->password = Hash::make($validated['password']);
        }
        if ($this->currentAdmin()->is_super_admin) {
            $adminUser->is_super_admin = $request->boolean('is_super_admin');
            $adminUser->permissions = $request->boolean('is_super_admin') ? null : AdminPermission::ensureViewForPermissions($validated['permissions'] ?? []);
        }
        $adminUser->save();

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user updated.');
    }

    public function destroy($id)
    {
        $this->onlySuperAdmin();

        $adminUser = Admin::findOrFail($id);
        $currentId = $this->currentAdmin()->id;
        if ($adminUser->id === $currentId) {
            return redirect()->route('admin.admin-users.index')->with('error', 'You cannot delete your own account.');
        }
        if (is_protected_admin_email($adminUser->email)) {
            return redirect()->route('admin.admin-users.index')->with('error', 'This admin account is protected and cannot be deleted.');
        }
        $adminUser->delete();
        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user deleted.');
    }

    public function toggleActive($id)
    {
        $this->onlySuperAdmin();

        $adminUser = Admin::findOrFail($id);
        $currentId = $this->currentAdmin()->id;
        if ($adminUser->id === $currentId) {
            return redirect()->route('admin.admin-users.index')->with('error', 'You cannot deactivate your own account.');
        }
        if (is_protected_admin_email($adminUser->email)) {
            return redirect()->route('admin.admin-users.index')->with('error', 'This admin account is protected and cannot be deactivated.');
        }
        $adminUser->is_active = ! $adminUser->is_active;
        $adminUser->save();
        $status = $adminUser->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.admin-users.index')->with('success', "Admin user {$status}.");
    }
}
