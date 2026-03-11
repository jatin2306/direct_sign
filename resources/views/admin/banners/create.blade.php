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
                    <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" id="banner-create-image" name="image" accept="image/*" required>
                    <div id="banner-create-size-error" class="invalid-feedback d-block text-danger" style="display: none;"></div>
                    @error('image') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                    <small class="text-muted">Image must be <strong>exactly 1280 × 400 px</strong>. JPEG, PNG, GIF, WebP. Max 5MB. After choosing a file, use the preview below to crop and zoom.</small>
                </div>
                <div class="col-12" id="banner-create-preview-wrap" style="display: none;">
                    <label class="form-label">Preview &amp; adjust</label>
                    <p class="text-muted small">Crop by dragging the corners, zoom with buttons, drag image to position left/right.</p>
                    <div id="banner-create-cropper-container" class="border rounded bg-dark position-relative overflow-hidden" style="height: 280px; width: 100%; min-height: 280px;">
                        <img id="banner-create-preview-img" src="" alt="" style="display: block; max-width: none;">
                    </div>
                    <div class="mt-2 d-flex flex-wrap gap-2 align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="banner-create-zoom-out" title="Zoom out">− Zoom out</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="banner-create-zoom-in" title="Zoom in">+ Zoom in</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="banner-create-reset" title="Reset">Reset</button>
                    </div>
                    <input type="hidden" name="image_display" id="image_display" value="">
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.css">
<style>
#banner-create-preview-wrap .cropper-view-box, #banner-create-preview-wrap .cropper-face { border-radius: 0; }
#banner-create-preview-wrap .cropper-container { height: 280px !important; }
#banner-create-cropper-container img { max-width: none; }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.js"></script>
<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('banner-create-image');
        var wrap = document.getElementById('banner-create-preview-wrap');
        var previewImg = document.getElementById('banner-create-preview-img');
        var hiddenInput = document.getElementById('image_display');
        var zoomInBtn = document.getElementById('banner-create-zoom-in');
        var zoomOutBtn = document.getElementById('banner-create-zoom-out');
        var resetBtn = document.getElementById('banner-create-reset');

        if (!fileInput || !wrap || !previewImg || typeof Cropper === 'undefined') return;

        function captureAndStore() {
            var cropper = wrap.cropperInstance;
            if (!cropper) return;
            var data = cropper.getData();
            var imgData = cropper.getImageData();
            if (!imgData || !imgData.naturalWidth) return;
            var natW = imgData.naturalWidth, natH = imgData.naturalHeight;
            var payload = {
                crop: {
                    x: Math.round((data.x / natW) * 10000) / 100,
                    y: Math.round((data.y / natH) * 10000) / 100,
                    w: Math.round((data.width / natW) * 10000) / 100,
                    h: Math.round((data.height / natH) * 10000) / 100
                }
            };
            hiddenInput.value = JSON.stringify(payload);
        }

        function initCropperOnCreate() {
            if (wrap.cropperInstance) {
                wrap.cropperInstance.destroy();
                wrap.cropperInstance = null;
            }
            if (!previewImg.src || !previewImg.complete) return;
            wrap.cropperInstance = new Cropper(previewImg, {
                viewMode: 1,
                dragMode: 'move',
                aspectRatio: 1920 / 500,
                autoCropArea: 1,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxResizable: true,
                cropBoxMovable: true,
                toggleDragModeOnDblclick: false
            });
            wrap.cropperInstance.cropper.addEventListener('cropend', captureAndStore);
            captureAndStore();
        }

        var requiredWidth = 1280, requiredHeight = 400;
        var sizeErrorEl = document.getElementById('banner-create-size-error');

        fileInput.addEventListener('change', function() {
            var file = this.files[0];
            if (sizeErrorEl) { sizeErrorEl.style.display = 'none'; sizeErrorEl.textContent = ''; }
            if (!file || !file.type.match('image.*')) return;
            if (wrap.cropperInstance) {
                wrap.cropperInstance.destroy();
                wrap.cropperInstance = null;
            }
            wrap.style.display = 'block';
            var reader = new FileReader();
            reader.onload = function(e) {
                var dataUrl = e.target.result;
                var done = function() {
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
                    setTimeout(function() {
                        initCropperOnCreate();
                    }, 50);
                };
                previewImg.onload = done;
                previewImg.src = dataUrl;
                if (previewImg.complete) done();
            };
            reader.readAsDataURL(file);
        });

        if (zoomInBtn) zoomInBtn.addEventListener('click', function() {
            var c = wrap.cropperInstance;
            if (c) { c.zoom(0.1); captureAndStore(); }
        });
        if (zoomOutBtn) zoomOutBtn.addEventListener('click', function() {
            var c = wrap.cropperInstance;
            if (c) { c.zoom(-0.1); captureAndStore(); }
        });
        if (resetBtn) resetBtn.addEventListener('click', function() {
            var c = wrap.cropperInstance;
            if (c) { c.reset(); captureAndStore(); }
        });

        var bannerForm = document.querySelector('form[action*="banners"]');
        if (bannerForm) bannerForm.addEventListener('submit', function() {
            captureAndStore();
        });
    });
})();
</script>
@endpush
@endsection
