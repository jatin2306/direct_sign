@extends('admin.layouts.app')

@section('title', 'Add developer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add developer to carousel</h4>
        <a href="{{ route('admin.developers.index') }}" class="btn btn-secondary">Back to developers</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong class="text-danger">Please fix the errors below:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $e)
                    <li class="text-danger">{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.developers.store') }}" method="POST" class="card shadow-sm">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Developer name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Emaar Properties" required>
                    @error('name') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="logo_text" class="form-label">Logo text (short label)</label>
                    <input type="text" class="form-control {{ $errors->has('logo_text') ? 'is-invalid' : '' }}" id="logo_text" name="logo_text" value="{{ old('logo_text') }}" placeholder="e.g. EMAAR">
                    <small class="text-muted">Shown on the card. Leave empty to use first word of name.</small>
                    @error('logo_text') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="search_slug" class="form-label">Search slug (for project count)</label>
                    <input type="text" class="form-control {{ $errors->has('search_slug') ? 'is-invalid' : '' }}" id="search_slug" name="search_slug" value="{{ old('search_slug') }}" placeholder="e.g. Emaar">
                    <small class="text-muted">Used to count properties (address LIKE %slug%). Leave empty for manual/zero count.</small>
                    @error('search_slug') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="sort_order" class="form-label">Sort order</label>
                    <input type="number" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    @error('sort_order') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="hidden" name="logo_dark" value="0">
                        <input type="checkbox" class="form-check-input" id="logo_dark" name="logo_dark" value="1" {{ old('logo_dark') ? 'checked' : '' }}>
                        <label class="form-check-label" for="logo_dark">Dark logo style (navy background, white text)</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active (show on homepage)</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Save developer</button>
        </div>
    </form>
</div>
@endsection
