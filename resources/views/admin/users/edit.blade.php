@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit User</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
