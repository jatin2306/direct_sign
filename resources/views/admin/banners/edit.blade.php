@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Banner</h4>
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

    <form action="{{ url('admin/banners/' . $banner->id) }}" method="POST" enctype="multipart/form-data" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="heading" class="form-label">Heading</label>
                    <input type="text" class="form-control {{ $errors->has('heading') ? 'is-invalid' : '' }}" id="heading" name="heading" value="{{ e(old('heading', $banner->heading ?? '')) }}">
                    @error('heading') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="sub_heading" class="form-label">Sub heading</label>
                    <input type="text" class="form-control {{ $errors->has('sub_heading') ? 'is-invalid' : '' }}" id="sub_heading" name="sub_heading" value="{{ e(old('sub_heading', $banner->sub_heading ?? '')) }}">
                    @error('sub_heading') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="cta_text" class="form-label">Button / CTA text</label>
                    <input type="text" class="form-control {{ $errors->has('cta_text') ? 'is-invalid' : '' }}" id="cta_text" name="cta_text" value="{{ e(old('cta_text', $banner->cta_text ?? '')) }}">
                    @error('cta_text') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="cta_url" class="form-label">Button / CTA URL</label>
                    <input type="url" class="form-control {{ $errors->has('cta_url') ? 'is-invalid' : '' }}" id="cta_url" name="cta_url" value="{{ e(old('cta_url', $banner->cta_url ?? '')) }}">
                    @error('cta_url') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="text_placement" class="form-label">Text placement</label>
                    <select class="form-select {{ $errors->has('text_placement') ? 'is-invalid' : '' }}" id="text_placement" name="text_placement">
                        <option value="left" {{ old('text_placement', $banner->text_placement ?? 'left') === 'left' ? 'selected' : '' }}>Left</option>
                        <option value="center" {{ old('text_placement', $banner->text_placement ?? 'left') === 'center' ? 'selected' : '' }}>Center</option>
                        <option value="right" {{ old('text_placement', $banner->text_placement ?? 'left') === 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                    @error('text_placement') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image" name="image" accept="image/*">
                    @error('image') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                    <small class="text-muted">Leave empty to keep current. Max 5MB.</small>
                </div>
                <div class="col-12" id="banner-preview-wrap" style="display: {{ $banner->image ? 'block' : 'none' }};">
                    <label class="form-label">Preview &amp; adjust</label>
                    <p class="text-muted small">Crop by dragging the corners, zoom with buttons, drag image to position left/right.</p>
                    <div class="border rounded bg-dark position-relative" style="height: 280px; width: 100%;">
                        <img id="banner-preview-img" src="{{ $banner->image ? $banner->image_url : '' }}" alt="" style="max-width: 100%; max-height: 280px;">
                    </div>
                    <div class="mt-2 d-flex flex-wrap gap-2 align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="banner-zoom-out" title="Zoom out">− Zoom out</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="banner-zoom-in" title="Zoom in">+ Zoom in</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="banner-reset" title="Reset">Reset</button>
                    </div>
                    <input type="hidden" name="image_display" id="image_display" value="{{ $banner->image_display ? json_encode($banner->image_display) : '' }}">
                </div>
                <div class="col-md-4">
                    <label for="sort_order" class="form-label">Sort order</label>
                    <input type="number" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" id="sort_order" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0">
                    @error('sort_order') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        @php
                            $isActive = old('is_active');
                            if ($isActive === null) {
                                $isActive = $banner->is_active ?? false;
                            } else {
                                $isActive = filter_var($isActive, FILTER_VALIDATE_BOOLEAN);
                            }
                        @endphp
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ $isActive ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update Banner</button>
        </div>
    </form>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.css">
<style>
#banner-preview-wrap .cropper-view-box, #banner-preview-wrap .cropper-face { border-radius: 0; }
#banner-preview-wrap .cropper-container { height: 280px !important; }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var fileInput = document.getElementById('image');
    var wrap = document.getElementById('banner-preview-wrap');
    var previewImg = document.getElementById('banner-preview-img');
    var hiddenInput = document.getElementById('image_display');
    var zoomInBtn = document.getElementById('banner-zoom-in');
    var zoomOutBtn = document.getElementById('banner-zoom-out');
    var resetBtn = document.getElementById('banner-reset');
    var cropper = null;
    var initialDisplay = null;
    try {
        var raw = hiddenInput.value;
        if (raw) initialDisplay = JSON.parse(raw);
    } catch (e) {}

    function captureAndStore() {
        if (!cropper) return;
        var data = cropper.getData();
        var imgData = cropper.getImageData();
        if (!imgData.naturalWidth) return;
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

    function initCropper(imgSrc) {
        if (cropper) { cropper.destroy(); cropper = null; }
        previewImg.src = imgSrc || previewImg.src;
        if (!previewImg.src) return;
        wrap.style.display = 'block';
        previewImg.onload = function() {
            cropper = new Cropper(previewImg, {
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
            if (initialDisplay && initialDisplay.crop && imgSrc === undefined) {
                var c = initialDisplay.crop;
                var imgData = cropper.getImageData();
                if (imgData.naturalWidth) {
                    cropper.setData({
                        x: (c.x / 100) * imgData.naturalWidth,
                        y: (c.y / 100) * imgData.naturalHeight,
                        width: (c.w / 100) * imgData.naturalWidth,
                        height: (c.h / 100) * imgData.naturalHeight
                    });
                }
                initialDisplay = null;
            }
            captureAndStore();
            cropper.cropper.addEventListener('cropend', captureAndStore);
        };
    }

    if (previewImg.src && previewImg.src.indexOf('http') === 0) {
        initCropper();
    }

    fileInput.addEventListener('change', function() {
        var file = this.files[0];
        if (!file || !file.type.match('image.*')) return;
        initialDisplay = null;
        var url = URL.createObjectURL(file);
        initCropper(url);
        previewImg.onload = function() { URL.revokeObjectURL(url); };
    });

    if (zoomInBtn) zoomInBtn.addEventListener('click', function() { if (cropper) cropper.zoom(0.1); captureAndStore(); });
    if (zoomOutBtn) zoomOutBtn.addEventListener('click', function() { if (cropper) cropper.zoom(-0.1); captureAndStore(); });
    if (resetBtn) resetBtn.addEventListener('click', function() { if (cropper) cropper.reset(); captureAndStore(); });

    document.querySelector('form').addEventListener('submit', function() {
        captureAndStore();
    });
});
</script>
@endpush
@endsection
