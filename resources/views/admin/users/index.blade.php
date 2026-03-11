@extends('admin.layouts.app')
@section('title', 'Users')

@section('content')
@php $showUserActions = admin_can('users.edit') || admin_can('users.delete') || admin_can('users.suspend'); @endphp
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Users</h4>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Email Verified</th>
                    <th>User Status</th>
                    <th>Created At</th>
                    @if($showUserActions)<th>Actions</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number ?? '-' }}</td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-warning text-dark">No</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_suspended)
                                <span class="badge bg-danger">Suspended</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </td>

                        <td>{{ $user->created_at ? $user->created_at->format('d M Y, h:i a') : '-' }}</td>
                        @if($showUserActions)
                        <td>
                            @if(admin_can('users.edit'))
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                            @endif
                            @if(admin_can('users.delete'))
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            @endif
                            @if(admin_can('users.suspend'))
                            <form action="{{ route('admin.users.toggleSuspend', $user->id) }}" method="POST" class="d-inline ms-1">
                                @csrf @method('PUT')
                                <button class="btn btn-sm {{ $user->is_suspended ? 'btn-success' : 'btn-warning' }}">
                                    {{ $user->is_suspended ? 'Activate' : 'Suspend' }}
                                </button>
                            </form>
                            @endif
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ $showUserActions ? 8 : 7 }}">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
