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

    <form action="{{ url('admin/banners/' . $banner->id) }}" method="POST" enctype="multipart/form-data" class="card shadow-sm" id="banner-form">
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
                    <div id="banner-edit-dropzone" class="banner-dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}">
                        <input type="file" class="d-none {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image" name="image" accept="image/*">
                        <div class="banner-dropzone-inner">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                            <p class="mb-1 fw-medium">Drag and drop your image here</p>
                            <p class="mb-0 small text-muted">or <span class="text-primary">browse</span> to choose a file</p>
                        </div>
                    </div>
                    @error('image') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                    <small class="text-muted d-block mt-1">Leave empty to keep current. New image: 1280×400 recommended; larger images can be cropped below.</small>
                </div>
                <div class="col-12" id="banner-edit-current-wrap" data-initial-src="{{ !empty($banner->image) ? asset('storage/' . ltrim($banner->image, '/')) : '' }}">
                    <label class="form-label">Current image preview</label>
                    <div class="border rounded overflow-hidden bg-light text-center" style="max-height: 220px; min-height: 120px;">
                        @if(!empty($banner->image))
                            @php $currentImageUrl = asset('storage/' . ltrim($banner->image, '/')); @endphp
                            <img id="banner-edit-current-img" src="{{ $currentImageUrl }}" alt="Current banner" class="img-fluid" style="max-height: 200px; width: auto;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <p id="banner-edit-current-fallback" class="mb-0 py-4 text-muted" style="display: none;">Image could not be loaded. Upload a new image above to replace.</p>
                        @else
                            <p class="mb-0 py-4 text-muted">No image uploaded. Choose a file above to add one.</p>
                            <img id="banner-edit-current-img" src="" alt="" class="img-fluid d-none" style="max-height: 200px; width: auto;">
                        @endif
                    </div>
                </div>
                <div class="col-12" id="banner-edit-crop-wrap" style="display: none;">
                    <label class="form-label">Crop preview <span class="text-muted">(fixed 1280×400 – drag image to position)</span></label>
                    <div class="banner-crop-box" id="banner-edit-crop-box">
                        <div class="banner-crop-inner" id="banner-edit-crop-inner">
                            <img id="banner-edit-crop-img" src="" alt="">
                        </div>
                    </div>
                    <p id="banner-edit-crop-hint" class="small text-muted mt-1 mb-0"></p>
                    <input type="hidden" name="crop_x" id="banner-edit-crop-x" value="">
                    <input type="hidden" name="crop_y" id="banner-edit-crop-y" value="">
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

    var fileInput = document.getElementById('image');
    var currentWrap = document.getElementById('banner-edit-current-wrap');
    var currentImg = document.getElementById('banner-edit-current-img');
    var cropWrap = document.getElementById('banner-edit-crop-wrap');
    var cropBox = document.getElementById('banner-edit-crop-box');
    var cropInner = document.getElementById('banner-edit-crop-inner');
    var cropImg = document.getElementById('banner-edit-crop-img');
    var cropHint = document.getElementById('banner-edit-crop-hint');
    var inputCropX = document.getElementById('banner-edit-crop-x');
    var inputCropY = document.getElementById('banner-edit-crop-y');
    var initialSrc = (currentWrap && currentWrap.getAttribute('data-initial-src')) || (currentImg ? currentImg.getAttribute('src') || '' : '');

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

    function setCropInputsFromOffset() {
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
        if (currentWrap) currentWrap.style.display = 'none';
        cropWrap.style.display = 'block';
    }

    var dropzone = document.getElementById('banner-edit-dropzone');
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
            if (currentWrap) {
                currentWrap.style.display = 'block';
                if (currentImg) { currentImg.src = initialSrc || ''; currentImg.style.display = initialSrc ? '' : 'none'; }
            }
            if (inputCropX) inputCropX.value = '';
            if (inputCropY) inputCropY.value = '';
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
