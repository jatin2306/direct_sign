@extends('admin.layouts.app')

@section('title', 'Add Banner')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add Banner</h4>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Back to Banners</a>
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

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="heading" class="form-label">Heading</label>
                    <input type="text" class="form-control {{ $errors->has('heading') ? 'is-invalid' : '' }}" id="heading" name="heading" value="{{ old('heading') }}" placeholder="e.g. Be Direct! Be Intelligent!">
                    @error('heading') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="sub_heading" class="form-label">Sub heading</label>
                    <input type="text" class="form-control {{ $errors->has('sub_heading') ? 'is-invalid' : '' }}" id="sub_heading" name="sub_heading" value="{{ old('sub_heading') }}" placeholder="e.g. Buy, Sell or Rent">
                    @error('sub_heading') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="cta_text" class="form-label">Button / CTA text</label>
                    <input type="text" class="form-control {{ $errors->has('cta_text') ? 'is-invalid' : '' }}" id="cta_text" name="cta_text" value="{{ old('cta_text') }}" placeholder="e.g. GET STARTED">
                    @error('cta_text') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="cta_url" class="form-label">Button / CTA URL</label>
                    <input type="url" class="form-control {{ $errors->has('cta_url') ? 'is-invalid' : '' }}" id="cta_url" name="cta_url" value="{{ old('cta_url') }}" placeholder="https://... or /properties">
                    @error('cta_url') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="text_placement" class="form-label">Text placement</label>
                    <select class="form-select {{ $errors->has('text_placement') ? 'is-invalid' : '' }}" id="text_placement" name="text_placement">
                        <option value="left" {{ old('text_placement', 'left') === 'left' ? 'selected' : '' }}>Left</option>
                        <option value="center" {{ old('text_placement') === 'center' ? 'selected' : '' }}>Center</option>
                        <option value="right" {{ old('text_placement') === 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                    @error('text_placement') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label for="banner-create-image" class="form-label">Image <span class="text-danger">*</span></label>
                    <div id="banner-create-dropzone" class="banner-dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}">
                        <input type="file" class="d-none {{ $errors->has('image') ? 'is-invalid' : '' }}" id="banner-create-image" name="image" accept="image/*" required>
                        <div class="banner-dropzone-inner">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                            <p class="mb-1 fw-medium">Drag and drop your image here</p>
                            <p class="mb-0 small text-muted">or <span class="text-primary">browse</span> to choose a file</p>
                        </div>
                    </div>
                    <div id="banner-create-size-error" class="invalid-feedback d-block text-danger" style="display: none;"></div>
                    @error('image') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                    <small class="text-muted d-block mt-1">Image must be <strong>exactly 1280 × 400 px</strong>. JPEG, PNG, GIF, WebP. Max 5MB.</small>
                </div>
                <div class="col-12" id="banner-create-preview-wrap" style="display: none;">
                    <label class="form-label">Preview</label>
                    <div class="border rounded overflow-hidden bg-light text-center" style="max-height: 320px;">
                        <img id="banner-create-preview-img" src="" alt="" class="img-fluid" style="max-height: 300px; width: auto;">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="sort_order" class="form-label">Sort order</label>
                    <input type="number" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    @error('sort_order') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active (show on homepage)</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Save Banner</button>
        </div>
    </form>
</div>

@push('styles')
<style>
#banner-create-preview-wrap .img-fluid { display: block; margin: 0 auto; }
.banner-dropzone {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 28px 20px;
    text-align: center;
    background: #f8f9fa;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}
.banner-dropzone:hover,
.banner-dropzone.drag-over { border-color: #26ae61; background: #e9f7f0; }
.banner-dropzone.is-invalid { border-color: #dc3545; }
.banner-dropzone-inner { pointer-events: none; }
</style>
@endpush
@push('scripts')
<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('banner-create-image');
        var wrap = document.getElementById('banner-create-preview-wrap');
        var previewImg = document.getElementById('banner-create-preview-img');
        var sizeErrorEl = document.getElementById('banner-create-size-error');
        var requiredWidth = 1280, requiredHeight = 400;

        if (!fileInput || !wrap || !previewImg) return;

        var dropzone = document.getElementById('banner-create-dropzone');
        if (dropzone) {
            dropzone.addEventListener('click', function() { fileInput.click(); });
            dropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('drag-over');
            });
            dropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('drag-over');
            });
            dropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('drag-over');
                var files = e.dataTransfer && e.dataTransfer.files;
                if (files && files.length && files[0].type.match('image.*')) {
                    var dt = new DataTransfer();
                    dt.items.add(files[0]);
                    fileInput.files = dt.files;
                    fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        }

        fileInput.addEventListener('change', function() {
            var file = this.files[0];
            if (sizeErrorEl) { sizeErrorEl.style.display = 'none'; sizeErrorEl.textContent = ''; }
            if (!file || !file.type.match('image.*')) {
                wrap.style.display = 'none';
                previewImg.src = '';
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImg.onload = function() {
                    var w = previewImg.naturalWidth, h = previewImg.naturalHeight;
                    if (w !== requiredWidth || h !== requiredHeight) {
                        if (sizeErrorEl) {
                            sizeErrorEl.textContent = 'Image must be exactly ' + requiredWidth + ' × ' + requiredHeight + ' px. This image is ' + w + ' × ' + h + ' px.';
                            sizeErrorEl.style.display = 'block';
                        }
                        fileInput.classList.add('is-invalid');
                        wrap.style.display = 'none';
                        previewImg.src = '';
                        fileInput.value = '';
                        return;
                    }
                    fileInput.classList.remove('is-invalid');
                    wrap.style.display = 'block';
                };
                previewImg.src = e.target.result;
                if (previewImg.complete) previewImg.onload();
            };
            reader.readAsDataURL(file);
        });
    });
})();
</script>
@endpush
@endsection
