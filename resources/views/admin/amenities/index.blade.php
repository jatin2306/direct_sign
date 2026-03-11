<!-- resources/views/admin/amenities/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Amenities')

@section('content')
@php $showAmenityActions = admin_can('amenities.edit') || admin_can('amenities.delete'); @endphp
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Amenities</h4>
        @if(admin_can('amenities.create'))
        <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary">Add Amenity</a>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                @if($showAmenityActions)<th>Actions</th>@endif
            </tr>
        </thead>
        <tbody>
            @foreach($amenities as $index => $amenity)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $amenity->name }}</td>
                    @if($showAmenityActions)
                    <td>
                        @if(admin_can('amenities.edit'))
                        <a href="{{ route('admin.amenities.edit', $amenity->id) }}" class="btn btn-sm btn-info">Edit</a>
                        @endif
                        @if(admin_can('amenities.delete'))
                        <form action="{{ route('admin.amenities.destroy', $amenity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this amenity?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
