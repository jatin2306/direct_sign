@extends('admin.layouts.app')
@section('title', 'User Notifications')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">User Interest & Notifications</h4>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Notification</th>
                    <th>Related Property</th>
                    <th>Status</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
            @forelse($notifications as $index => $notification)
                @php
                $data = $notification->data;
                    $propertyId = $data['property_id'] ?? null;
                    $propertyTitle = $data['property_name'] ?? 'Property';
                    $user = \App\Models\User::find($notification->notifiable_id);
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($user)
                            @if(admin_can('users.edit'))
                                <a href="{{ route('admin.users.edit', $user->id) }}">{{ $user->name }}</a>
                            @else
                                {{ $user->name }}
                            @endif
                            <br>
                            <small>{{ $user->email }}</small>
                        @else
                            User #{{ $notification->notifiable_id }}
                        @endif
                    </td>
                    <td>
                        {{ class_basename($notification->type) }}
                        <br>
                        <small>{{ $data['message'] ?? '' }}</small>
                    </td>
                    <td>
                        @if($propertyId)
                            @if(admin_can('properties.edit'))
                                <a href="{{ route('admin.properties.edit', $propertyId) }}">
                                    {{ $propertyTitle }} (ID: {{ $propertyId }})
                                </a>
                            @else
                                {{ $propertyTitle }} (ID: {{ $propertyId }})
                            @endif
                        @else
                            &mdash;
                        @endif
                    </td>
                    <td>
                        @if($notification->read_at)
                            <span class="badge bg-success">Read</span>
                        @else
                            <span class="badge bg-warning text-dark">Unread</span>
                        @endif
                    </td>
                    <td>
  {{ $notification->created_at ? $notification->created_at->format('d M Y, h:i a') : '-' }}
</td>

                </tr>
            @empty
                <tr>
                    <td colspan="6">No notifications found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
