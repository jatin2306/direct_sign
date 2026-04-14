@extends('admin.layouts.app')
@section('title', 'Create Home CTA Section')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Create Home CTA Section</h4>
        <a href="{{ route('admin.home-cta-sections.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.home-cta-sections.store') }}" method="POST" class="card shadow-sm">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Primary Button Text</label>
                    <input type="text" name="primary_button_text" class="form-control" value="{{ old('primary_button_text', 'Search Verified Properties') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Primary Button URL</label>
                    <input type="text" name="primary_button_url" class="form-control" value="{{ old('primary_button_url', url('properties')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Secondary Button Text</label>
                    <input type="text" name="secondary_button_text" class="form-control" value="{{ old('secondary_button_text', 'List Your Property Free') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Secondary Button URL</label>
                    <input type="text" name="secondary_button_url" class="form-control" value="{{ old('secondary_button_url', route('add.listing')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Background Color</label>
                    <input type="color" name="background_color" class="form-control form-control-color w-100" value="{{ old('background_color', '#e9f7f0') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Title Color</label>
                    <input type="color" name="title_color" class="form-control form-control-color w-100" value="{{ old('title_color', '#26AE61') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Description Color</label>
                    <input type="color" name="description_color" class="form-control form-control-color w-100" value="{{ old('description_color', '#4A225B') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Secondary Button Text Color</label>
                    <input type="color" name="secondary_button_color" class="form-control form-control-color w-100" value="{{ old('secondary_button_color', '#26AE61') }}">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active (show this section on homepage)</label>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <button type="submit" class="btn btn-primary">Create Section</button>
        </div>
    </form>
</div>
@endsection
