{{-- resources/views/admin/amenities/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Create Amenities')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4 class="page-title">Add New Amenity</h4>
    <a href="{{ route('admin.amenities.index') }}" class="btn btn-secondary">Back to List</a>
</div>

<form action="{{ route('admin.amenities.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Amenity Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Amenity</button>
        </div>
    </div>
</form>
@endsection
