@extends('admin.layouts.app')
@section('title', 'Admin Users')

@section('content')
@php
    $currentAdmin = Auth::guard('admin')->user();
    $showAdminUserActions = admin_can('admin-users.edit') || admin_can('admin-users.delete') || $currentAdmin->is_super_admin;
@endphp
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Admin Users</h4>
        @if(admin_can('admin-users.create'))
        <a href="{{ route('admin.admin-users.create') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i> Add Admin User</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        @if($showAdminUserActions)<th>Actions</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @php $currentAdminId = Auth::guard('admin')->id(); @endphp
                    @forelse($admins as $index => $admin)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            @if($admin->is_super_admin)
                                <span class="badge bg-danger">Super Admin</span>
                            @else
                                <span class="badge bg-info">Limited</span>
                            @endif
                        </td>
                        <td>
                            @if($admin->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $admin->created_at?->format('d M Y') }}</td>
                        @if($showAdminUserActions)
                        <td>
                            @if(is_protected_admin_email($admin->email))
                                @if($admin->id === $currentAdminId)
                                    <a href="{{ route('admin.admin-users.edit', $admin->id) }}" class="btn btn-sm btn-outline-primary">Edit (password)</a>
                                @else
                                    <span class="text-muted small">Protected</span>
                                @endif
                            @else
                                @if(admin_can('admin-users.edit'))
                                <a href="{{ route('admin.admin-users.edit', $admin->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                @endif
                                @if($currentAdmin->is_super_admin && $admin->id !== $currentAdminId)
                                    <form action="{{ route('admin.admin-users.toggleActive', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $admin->is_active ? "Deactivate" : "Activate" }} this admin user?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm {{ $admin->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                            {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    @if(admin_can('admin-users.delete'))
                                    <form action="{{ route('admin.admin-users.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete this admin user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                    @endif
                                @endif
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $showAdminUserActions ? 7 : 6 }}" class="text-center text-muted py-4">No admin users yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
