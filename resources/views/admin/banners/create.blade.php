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

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm" id="banner-form">
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
                    @error('image') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                    <small class="text-muted d-block mt-1">Recommended <strong>1280 × 400 px</strong>. Larger images can be cropped in the preview. JPEG, PNG, GIF, WebP. Max 5MB.</small>
                </div>
                <div class="col-12" id="banner-create-crop-wrap" style="display: none;">
                    <label class="form-label">Crop preview <span class="text-muted">(fixed 1280×400 – drag image to position)</span></label>
                    <div class="banner-crop-box" id="banner-create-crop-box">
                        <div class="banner-crop-inner" id="banner-create-crop-inner">
                            <img id="banner-create-crop-img" src="" alt="">
                        </div>
                    </div>
                    <p id="banner-create-crop-hint" class="small text-muted mt-1 mb-0"></p>
                    <input type="hidden" name="crop_x" id="banner-create-crop-x" value="">
                    <input type="hidden" name="crop_y" id="banner-create-crop-y" value="">
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

.banner-crop-box {
    width: 640px;
    height: 200px;
    max-width: 100%;
    overflow: hidden;
    position: relative;
    background: #111;
    border: 2px solid #26ae61;
    border-radius: 8px;
    cursor: grab;
    user-select: none;
}
.banner-crop-box:active { cursor: grabbing; }
.banner-crop-inner {
    position: absolute;
    left: 0;
    top: 0;
    pointer-events: none;
}
.banner-crop-inner img {
    display: block;
    pointer-events: none;
}
</style>
@endpush
@push('scripts')
<script>
(function() {
    var BANNER_W = 1280, BANNER_H = 400;
    var PREVIEW_W = 640, PREVIEW_H = 200;
    var SCALE = PREVIEW_W / BANNER_W;

    var fileInput = document.getElementById('banner-create-image');
    var cropWrap = document.getElementById('banner-create-crop-wrap');
    var cropBox = document.getElementById('banner-create-crop-box');
    var cropInner = document.getElementById('banner-create-crop-inner');
    var cropImg = document.getElementById('banner-create-crop-img');
    var cropHint = document.getElementById('banner-create-crop-hint');
    var inputCropX = document.getElementById('banner-create-crop-x');
    var inputCropY = document.getElementById('banner-create-crop-y');

    if (!fileInput || !cropWrap || !cropBox || !cropInner || !cropImg) return;

    var imgNaturalW = 0, imgNaturalH = 0;
    var offsetX = 0, offsetY = 0;
    var dragStartX, dragStartY, startOffsetX, startOffsetY;
    var isSmallImage = false;

    function setCropInputs(x, y) {
        if (inputCropX) inputCropX.value = Math.round(x);
        if (inputCropY) inputCropY.value = Math.round(y);
    }

    function clampOffsets() {
        var scaledW = imgNaturalW * SCALE, scaledH = imgNaturalH * SCALE;
        var maxX = Math.max(0, scaledW - PREVIEW_W);
        var maxY = Math.max(0, scaledH - PREVIEW_H);
        offsetX = Math.max(-maxX, Math.min(0, offsetX));
        offsetY = Math.max(-maxY, Math.min(0, offsetY));
        cropInner.style.left = offsetX + 'px';
        cropInner.style.top = offsetY + 'px';
        var cropX = Math.round(-offsetX / SCALE);
        var cropY = Math.round(-offsetY / SCALE);
        setCropInputs(cropX, cropY);
    }

    function setupDrag() {
        cropBox.onmousedown = function(e) {
            e.preventDefault();
            dragStartX = e.clientX;
            dragStartY = e.clientY;
            startOffsetX = offsetX;
            startOffsetY = offsetY;
            document.addEventListener('mousemove', onDrag);
            document.addEventListener('mouseup', onDragEnd);
        };
        cropBox.ontouchstart = function(e) {
            e.preventDefault();
            var t = e.touches[0];
            dragStartX = t.clientX;
            dragStartY = t.clientY;
            startOffsetX = offsetX;
            startOffsetY = offsetY;
            document.addEventListener('touchmove', onDragTouch, { passive: false });
            document.addEventListener('touchend', onDragEnd);
        };
    }
    function onDrag(e) {
        offsetX = startOffsetX + (e.clientX - dragStartX);
        offsetY = startOffsetY + (e.clientY - dragStartY);
        if (isSmallImage) { clampOffsetsSmall(); setCropInputsFromOffset(); } else clampOffsets();
    }
    function onDragTouch(e) {
        e.preventDefault();
        var t = e.touches[0];
        offsetX = startOffsetX + (t.clientX - dragStartX);
        offsetY = startOffsetY + (t.clientY - dragStartY);
        if (isSmallImage) { clampOffsetsSmall(); setCropInputsFromOffset(); } else clampOffsets();
    }
    function onDragEnd() {
        document.removeEventListener('mousemove', onDrag);
        document.removeEventListener('mouseup', onDragEnd);
        document.removeEventListener('touchmove', onDragTouch);
        document.removeEventListener('touchend', onDragEnd);
    }

    function showCropPreview(src, naturalW, naturalH) {
        imgNaturalW = naturalW;
        imgNaturalH = naturalH;
        cropImg.src = src;

        isSmallImage = (naturalW < BANNER_W || naturalH < BANNER_H);
        if (naturalW === BANNER_W && naturalH === BANNER_H) {
            cropImg.style.width = (naturalW * SCALE) + 'px';
            cropImg.style.height = (naturalH * SCALE) + 'px';
            offsetX = 0;
            offsetY = 0;
            setCropInputs(0, 0);
            cropInner.style.left = '0px';
            cropInner.style.top = '0px';
            cropBox.style.cursor = 'default';
            cropBox.onmousedown = null;
            cropBox.ontouchstart = null;
            if (cropHint) cropHint.textContent = 'Image is exactly 1280×400 px. It will be saved as-is.';
        } else if (naturalW >= BANNER_W && naturalH >= BANNER_H) {
            cropImg.style.width = (naturalW * SCALE) + 'px';
            cropImg.style.height = (naturalH * SCALE) + 'px';
            offsetX = -((naturalW * SCALE) - PREVIEW_W) / 2;
            offsetY = -((naturalH * SCALE) - PREVIEW_H) / 2;
            clampOffsets();
            setupDrag();
            if (cropHint) cropHint.textContent = 'Drag the image to choose the area to keep. The green box is fixed (1280×400). Excess will be cropped on save.';
        } else {
            var scaleFit = Math.min(BANNER_W / naturalW, BANNER_H / naturalH);
            var scaledW = naturalW * scaleFit, scaledH = naturalH * scaleFit;
            cropImg.style.width = (scaledW * SCALE) + 'px';
            cropImg.style.height = (scaledH * SCALE) + 'px';
            offsetX = (PREVIEW_W - scaledW * SCALE) / 2;
            offsetY = (PREVIEW_H - scaledH * SCALE) / 2;
            clampOffsetsSmall();
            setupDrag();
            setCropInputsFromOffset();
            if (cropHint) cropHint.textContent = 'Image is smaller than 1280×400. Drag to position it; it will be placed on a 1280×400 banner on save.';
        }
        cropWrap.style.display = 'block';
    }

    function setCropInputsFromOffset() {
        var scaleFit = Math.min(BANNER_W / imgNaturalW, BANNER_H / imgNaturalH);
        var scaledW = imgNaturalW * scaleFit, scaledH = imgNaturalH * scaleFit;
        var posX = Math.round(offsetX / SCALE);
        var posY = Math.round(offsetY / SCALE);
        setCropInputs(posX, posY);
    }

    function clampOffsetsSmall() {
        var scaleFit = Math.min(BANNER_W / imgNaturalW, BANNER_H / imgNaturalH);
        var scaledPreviewW = imgNaturalW * scaleFit * SCALE, scaledPreviewH = imgNaturalH * scaleFit * SCALE;
        var maxX = Math.max(0, PREVIEW_W - scaledPreviewW);
        var maxY = Math.max(0, PREVIEW_H - scaledPreviewH);
        offsetX = Math.max(0, Math.min(maxX, offsetX));
        offsetY = Math.max(0, Math.min(maxY, offsetY));
        cropInner.style.left = offsetX + 'px';
        cropInner.style.top = offsetY + 'px';
    }

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
        if (!file || !file.type.match('image.*')) {
            cropWrap.style.display = 'none';
            cropImg.src = '';
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = new Image();
            img.onload = function() {
                showCropPreview(e.target.result, img.naturalWidth, img.naturalHeight);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endpush
@endsection
