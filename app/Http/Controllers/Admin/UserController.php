<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->get();
        return view('admin.users.index', compact('users'));
    }

    public function edit($user)
    {
        $user = User::find($user);
        if (!$user) {
            return back()->with('error', 'User not found.');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $user)
    {
        $user = User::find($user);
        if (!$user) {
            return back()->with('error', 'User not found.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone_number' => 'nullable|string|max:15',
        ]);
        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy($user)
    {
        $user = User::find($user);
        if (!$user) {
            return back()->with('error', 'User not found.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    public function toggleSuspend($user)
    {
        $user = \App\Models\User::find($user);
        if (!$user) {
            return back()->with('error', 'User not found.');
        }
        $user->is_suspended = !$user->is_suspended;
        $user->save();

        return back()->with('success', 'User ' . ($user->is_suspended ? 'suspended' : 'activated') . ' successfully.');
    }

}
