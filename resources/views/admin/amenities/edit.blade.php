@extends('admin.layouts.app')
@section('title', 'Edit Amenity')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>Edit Amenity</h4>
    </div>
    <div class="card-body">
        
    <form action="{{ route('admin.amenities.update', ['amenity' => $amenity->id]) }}" method="POST">

            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Amenity Name *</label>
                <input type="text" name="name" class="form-control" value="{{ $amenity->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Amenity</button>
            <a href="{{ route('admin.amenities.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
