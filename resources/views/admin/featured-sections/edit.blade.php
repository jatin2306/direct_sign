@extends('admin.layouts.app')

@section('title', 'Edit Carousel')

@section('content')
@php
    $isDevelopers = $section->isDevelopersType();
    $isImageCarousel = $section->isImageCarouselType();
    $developers = old('developers', $section->developers->map(fn($d) => ['name' => $d->name, 'logo_text' => $d->logo_text, 'logo_dark' => $d->logo_dark, 'search_slug' => $d->search_slug])->toArray());
    if (empty($developers)) {
        $developers = [['name' => '', 'logo_text' => '', 'logo_dark' => '', 'search_slug' => '']];
    }
    $slides = old('slides', $section->images->map(fn($img) => ['heading' => $img->heading, 'second_heading' => $img->second_heading, 'heading_order' => $img->heading_order, 'cta_url' => $img->cta_url, 'background_color' => $img->background_color, 'existing_image' => $img->image_path])->toArray());
    if (empty($slides) && $isImageCarousel) {
        $slides = [['heading' => '', 'second_heading' => '', 'heading_order' => 1, 'cta_url' => '', 'background_color' => '', 'existing_image' => '']];
    }
@endphp
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Carousel</h4>
        <a href="{{ route('admin.featured-sections.index') }}" class="btn btn-secondary">Back to Carousels</a>
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

    <form action="{{ url('admin/featured-sections/' . $section->id) }}" method="POST" class="card shadow-sm" id="carousel-edit-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Section title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" value="{{ old('title', $section->title) }}" required>
                    @error('title') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="heading" class="form-label">Heading (optional)</label>
                    <input type="text" class="form-control {{ $errors->has('heading') ? 'is-invalid' : '' }}" id="heading" name="heading" value="{{ old('heading', $section->heading) }}">
                    @error('heading') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6" style="{{ ($isDevelopers || $isImageCarousel) ? 'display:none' : '' }}">
                    <label for="heading_placement" class="form-label">Heading placement</label>
                    <select class="form-select {{ $errors->has('heading_placement') ? 'is-invalid' : '' }}" id="heading_placement" name="heading_placement">
                        <option value="left" {{ old('heading_placement', $section->heading_placement) === 'left' ? 'selected' : '' }}>Left</option>
                        <option value="center" {{ old('heading_placement', $section->heading_placement) === 'center' ? 'selected' : '' }}>Center</option>
                        <option value="right" {{ old('heading_placement', $section->heading_placement) === 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                    @error('heading_placement') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="sort_order" class="form-label">Sort order</label>
                    <input type="number" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" id="sort_order" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" min="0">
                    @error('sort_order') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="is_active" class="form-label">Status</label>
                    @php $isActiveVal = old('is_active', $section->is_active); $isActiveVal = ($isActiveVal === true || $isActiveVal === 1 || $isActiveVal === '1'); @endphp
                    <select class="form-select {{ $errors->has('is_active') ? 'is-invalid' : '' }}" id="is_active" name="is_active">
                        <option value="1" {{ $isActiveVal ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$isActiveVal ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>

                @if($section->isPropertiesType())
                <div class="col-12">
                    <label for="property_search" class="form-label">Add property <span class="text-muted">(approved only)</span></label>
                    <input type="text" id="property_search" class="form-control mb-2" placeholder="Type to search properties..." autocomplete="off">
                    <select id="property_add" class="form-select">
                        <option value="">-- Select a property --</option>
                        @foreach($availableProperties as $prop)
                            <option value="{{ $prop->id }}" data-name="{{ e($prop->propertyName) }}" data-price="{{ number_format($prop->price) }}">{{ $prop->propertyName }} — {{ number_format($prop->price) }} AED</option>
                        @endforeach
                    </select>
                </div>
                @php $hasOldProperties = old('property_ids') && count((array) old('property_ids')) > 0; if ($hasOldProperties) { $orderedIds = array_map('intval', (array) old('property_ids')); $allPropsForOld = $availableProperties->keyBy('id')->merge($section->properties->keyBy('id')); } @endphp
                <div class="col-12">
                    <label class="form-label">Properties in this carousel <span class="text-danger">*</span></label>
                    <ul id="property_order_list" class="list-group list-group-numbered {{ $errors->has('property_ids') ? 'border border-danger' : '' }}" style="min-height: 60px;">
                        @if($hasOldProperties ?? false)
                            @foreach($orderedIds as $pid)
                                @php $p = $allPropsForOld->get($pid); @endphp
                                @if($p)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $p->id }}" data-name="{{ e($p->propertyName) }}" data-price="{{ number_format($p->price) }}">
                                        <span>{{ $p->propertyName }} — {{ number_format($p->price) }} AED</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-property">Remove</button>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            @foreach($section->properties as $p)
                                <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $p->id }}" data-name="{{ e($p->propertyName) }}" data-price="{{ number_format($p->price) }}">
                                    <span>{{ $p->propertyName }} — {{ number_format($p->price) }} AED</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-property">Remove</button>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <div id="property_ids_hidden_container"></div>
                    @error('property_ids') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                @elseif($isImageCarousel)
                <div class="col-12">
                    <label class="form-label">Heading placement</label>
                    <select class="form-select" name="heading_placement">
                        <option value="left" {{ old('heading_placement', $section->heading_placement) === 'left' ? 'selected' : '' }}>Left</option>
                        <option value="center" {{ old('heading_placement', $section->heading_placement) === 'center' ? 'selected' : '' }}>Center</option>
                        <option value="right" {{ old('heading_placement', $section->heading_placement) === 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Image slides <span class="text-danger">*</span></label>
                    <p class="text-muted small">Drag rows to set display order. Add as many slides as you need. Image: drag & drop or click to replace.</p>
                    <p class="text-muted small mb-2"><strong>Image size:</strong> Recommended 600×400 px. Use <strong>Bg color</strong> to fill empty space when the image is small.</p>
                    <div id="slides-list" class="slides-sortable">
                        @foreach($slides as $idx => $s)
                        <div class="slide-row border rounded p-3 mb-2 bg-light slide-row-draggable">
                            <input type="hidden" name="slides[{{ $idx }}][existing_image]" value="{{ $s['existing_image'] ?? '' }}">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-2">
                                    <label class="form-label small mb-0">Image</label>
                                    <div class="slide-image-dropzone border rounded p-2 text-center bg-white" style="min-height:80px; border-style:dashed;">
                                        <input type="file" class="d-none slide-image-input" name="slides[{{ $idx }}][image]" accept="image/*">
                                        <div class="slide-dropzone-inner">
                                            @if(!empty($s['existing_image']))
                                            <img src="{{ asset('storage/' . ($s['existing_image'] ?? '')) }}" alt="" class="slide-existing-img img-fluid rounded mb-1" style="max-height:50px;">
                                            @endif
                                            <i class="fas fa-cloud-upload-alt text-muted small"></i>
                                            <div class="small mt-1">Drag image or click</div>
                                        </div>
                                        <img class="slide-preview-img d-none img-fluid rounded" style="max-height:60px;" alt="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-0">Image heading</label>
                                    <input type="text" class="form-control form-control-sm" name="slides[{{ $idx }}][heading]" value="{{ $s['heading'] ?? '' }}" placeholder="First heading">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-0">Second image heading</label>
                                    <input type="text" class="form-control form-control-sm" name="slides[{{ $idx }}][second_heading]" value="{{ $s['second_heading'] ?? '' }}" placeholder="Second heading">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-0">Which heading first</label>
                                    <select class="form-select form-select-sm" name="slides[{{ $idx }}][heading_order]">
                                        <option value="1" {{ ($s['heading_order'] ?? 1) == 1 ? 'selected' : '' }}>Image heading first</option>
                                        <option value="2" {{ ($s['heading_order'] ?? 1) == 2 ? 'selected' : '' }}>Second heading first</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-0">CTA URL (on click)</label>
                                    <input type="url" class="form-control form-control-sm" name="slides[{{ $idx }}][cta_url]" value="{{ $s['cta_url'] ?? '' }}" placeholder="https://...">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small mb-0">Bg color (if image small)</label>
                                    <div class="d-flex align-items-center gap-1">
                                        @php $bgHex = !empty($s['background_color']) && preg_match('/^#([0-9A-Fa-f]{3}){1,2}$/', $s['background_color']) ? $s['background_color'] : '#ffffff'; @endphp
                                        <input type="color" class="form-control form-control-color slide-bg-color-picker" style="width:2.5rem;height:2rem;padding:2px;" value="{{ $bgHex }}" title="Pick color">
                                        <input type="text" class="form-control form-control-sm slide-bg-color-code" name="slides[{{ $idx }}][background_color]" value="{{ $s['background_color'] ?? '' }}" placeholder="#fff" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-slide">Remove</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-slide">+ Add slide</button>
                    @error('slides') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                @else
                <div class="col-12">
                    <label class="form-label">Developers in this carousel <span class="text-danger">*</span></label>
                    <div id="developers-list">
                        @foreach($developers as $idx => $d)
                        <div class="developer-row border rounded p-3 mb-2 bg-light">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="text" class="form-control form-control-sm" name="developers[{{ $idx }}][name]" value="{{ $d['name'] ?? '' }}" placeholder="Developer name" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" name="developers[{{ $idx }}][logo_text]" value="{{ $d['logo_text'] ?? '' }}" placeholder="Logo (e.g. EMAAR)">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" name="developers[{{ $idx }}][search_slug]" value="{{ $d['search_slug'] ?? '' }}" placeholder="Search slug">
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <div class="form-check">
                                        <input type="hidden" name="developers[{{ $idx }}][logo_dark]" value="0">
                                        <input type="checkbox" class="form-check-input" name="developers[{{ $idx }}][logo_dark]" value="1" {{ !empty($d['logo_dark']) ? 'checked' : '' }}>
                                        <label class="form-check-label small">Dark logo</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-developer">Remove</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-developer">+ Add developer</button>
                    @error('developers') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                @endif
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update Carousel</button>
        </div>
    </form>
</div>
@if($section->isPropertiesType())
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var list = document.getElementById('property_order_list');
    var addSelect = document.getElementById('property_add');
    var searchInput = document.getElementById('property_search');
    var container = document.getElementById('property_ids_hidden_container');

    function syncHiddenInputs() {
        if (!container) return;
        container.innerHTML = '';
        list.querySelectorAll('li[data-id]').forEach(function(li) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'property_ids[]';
            input.value = li.getAttribute('data-id');
            container.appendChild(input);
        });
    }
    function filterOptions() {
        var term = (searchInput && searchInput.value || '').toLowerCase();
        addSelect.querySelectorAll('option[value]').forEach(function(opt) {
            opt.hidden = term.length > 0 && (opt.textContent || '').toLowerCase().indexOf(term) < 0;
        });
    }
    addSelect.addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        if (!opt || !opt.value) return;
        if (list.querySelector('li[data-id="' + opt.value + '"]')) return;
        var li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.setAttribute('data-id', opt.value);
        li.setAttribute('data-name', opt.getAttribute('data-name') || '');
        li.setAttribute('data-price', opt.getAttribute('data-price') || '');
        li.innerHTML = '<span>' + (opt.getAttribute('data-name') || '') + ' — ' + (opt.getAttribute('data-price') || '') + ' AED</span><button type="button" class="btn btn-sm btn-outline-danger remove-property">Remove</button>';
        list.appendChild(li);
        opt.remove();
        addSelect.selectedIndex = 0;
        filterOptions();
        syncHiddenInputs();
    });
    list.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-property')) {
            var li = e.target.closest('li');
            if (li) {
                var id = li.getAttribute('data-id'), name = li.getAttribute('data-name'), price = li.getAttribute('data-price');
                li.remove();
                var opt = document.createElement('option');
                opt.value = id; opt.setAttribute('data-name', name); opt.setAttribute('data-price', price);
                opt.textContent = name + ' — ' + price + ' AED';
                addSelect.appendChild(opt);
                filterOptions();
                syncHiddenInputs();
            }
        }
    });
    if (typeof Sortable !== 'undefined') new Sortable(list, { animation: 150, onEnd: syncHiddenInputs });
    if (searchInput) { searchInput.addEventListener('input', filterOptions); searchInput.addEventListener('keyup', filterOptions); }
    syncHiddenInputs();
    document.getElementById('carousel-edit-form').addEventListener('submit', function() { syncHiddenInputs(); });
});
</script>
@endpush
@elseif($isImageCarousel)
@push('styles')
<style>
.slide-image-dropzone { cursor: pointer; transition: border-color 0.2s, background 0.2s; }
.slide-image-dropzone:hover, .slide-image-dropzone.drag-over { border-color: #26ae61 !important; background: #e9f7f0; }
.slide-dropzone-inner { pointer-events: none; }
.slides-sortable .slide-row-draggable { cursor: move; }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var slidesList = document.getElementById('slides-list');
    var addSlideBtn = document.getElementById('add-slide');
    function initSlideDropzone(slideRow) {
        var dropzone = slideRow.querySelector('.slide-image-dropzone');
        var fileInput = slideRow.querySelector('.slide-image-input');
        var previewImg = slideRow.querySelector('.slide-preview-img');
        var inner = slideRow.querySelector('.slide-dropzone-inner');
        if (!dropzone || !fileInput) return;
        dropzone.addEventListener('click', function(e) { if (!e.target.closest('input')) fileInput.click(); });
        dropzone.addEventListener('dragover', function(e) { e.preventDefault(); e.stopPropagation(); dropzone.classList.add('drag-over'); });
        dropzone.addEventListener('dragleave', function(e) { e.preventDefault(); dropzone.classList.remove('drag-over'); });
        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropzone.classList.remove('drag-over');
            var files = e.dataTransfer && e.dataTransfer.files;
            if (files && files.length && files[0].type.match('image.*')) {
                var dt = new DataTransfer();
                dt.items.add(files[0]);
                fileInput.files = dt.files;
                fileInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
        fileInput.addEventListener('change', function() {
            var file = this.files[0];
            if (previewImg) {
                if (!file || !file.type.match('image.*')) {
                    previewImg.classList.add('d-none');
                    previewImg.src = '';
                    if (inner) inner.classList.remove('d-none');
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(ev) {
                    previewImg.src = ev.target.result;
                    previewImg.classList.remove('d-none');
                    if (inner) inner.classList.add('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    }
    function reindexSlides() {
        var rows = slidesList.querySelectorAll('.slide-row');
        rows.forEach(function(row, i) {
            row.querySelectorAll('[name^="slides["]').forEach(function(el) {
                var name = el.getAttribute('name');
                if (name && name.match(/^slides\[\d+\]/)) {
                    el.setAttribute('name', name.replace(/^slides\[\d+\]/, 'slides[' + i + ']'));
                }
            });
        });
    }
    if (typeof Sortable !== 'undefined' && slidesList) {
        new Sortable(slidesList, {
            animation: 150,
            draggable: '.slide-row',
            onEnd: reindexSlides
        });
    }
    slidesList.querySelectorAll('.slide-row').forEach(initSlideDropzone);
    var slideIndex = document.querySelectorAll('.slide-row').length;
    addSlideBtn.addEventListener('click', function() {
        var row = document.createElement('div');
        row.className = 'slide-row border rounded p-3 mb-2 bg-light slide-row-draggable';
        row.innerHTML = '<input type="hidden" name="slides[' + slideIndex + '][existing_image]" value="">' +
            '<div class="row g-2 align-items-end">' +
            '<div class="col-md-2"><label class="form-label small mb-0">Image</label><div class="slide-image-dropzone border rounded p-2 text-center bg-white" style="min-height:80px; border-style:dashed;"><input type="file" class="d-none slide-image-input" name="slides[' + slideIndex + '][image]" accept="image/*"><div class="slide-dropzone-inner"><i class="fas fa-cloud-upload-alt text-muted small"></i><div class="small mt-1">Drag image or click</div></div><img class="slide-preview-img d-none img-fluid rounded" style="max-height:60px;" alt=""></div></div>' +
            '<div class="col-md-2"><label class="form-label small mb-0">Image heading</label><input type="text" class="form-control form-control-sm" name="slides[' + slideIndex + '][heading]" placeholder="First heading"></div>' +
            '<div class="col-md-2"><label class="form-label small mb-0">Second image heading</label><input type="text" class="form-control form-control-sm" name="slides[' + slideIndex + '][second_heading]" placeholder="Second heading"></div>' +
            '<div class="col-md-2"><label class="form-label small mb-0">Which heading first</label><select class="form-select form-select-sm" name="slides[' + slideIndex + '][heading_order]"><option value="1">Image heading first</option><option value="2">Second heading first</option></select></div>' +
            '<div class="col-md-2"><label class="form-label small mb-0">CTA URL (on click)</label><input type="url" class="form-control form-control-sm" name="slides[' + slideIndex + '][cta_url]" placeholder="https://..."></div>' +
            '<div class="col-md-2"><label class="form-label small mb-0">Bg color (if image small)</label><div class="d-flex align-items-center gap-1"><input type="color" class="form-control form-control-color slide-bg-color-picker" style="width:2.5rem;height:2rem;padding:2px;" value="#ffffff" title="Pick color"><input type="text" class="form-control form-control-sm slide-bg-color-code" name="slides[' + slideIndex + '][background_color]" value="" placeholder="#fff" maxlength="20"></div></div>' +
            '<div class="col-md-2"><button type="button" class="btn btn-sm btn-outline-danger remove-slide">Remove</button></div></div>';
        slidesList.appendChild(row);
        initSlideDropzone(row);
        row.querySelector('.remove-slide').addEventListener('click', function() { row.remove(); reindexSlides(); });
        slideIndex++;
    });
    slidesList.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-slide')) {
            e.target.closest('.slide-row').remove();
            reindexSlides();
        }
    });
    function syncBgColorToCode(slideRow) {
        var p = slideRow.querySelector('.slide-bg-color-picker');
        var c = slideRow.querySelector('.slide-bg-color-code');
        if (p && c) c.value = p.value;
    }
    slidesList.addEventListener('input', function(e) {
        var row = e.target.closest('.slide-row');
        if (!row) return;
        if (e.target.classList.contains('slide-bg-color-picker')) {
            var c = row.querySelector('.slide-bg-color-code');
            if (c) c.value = e.target.value;
        }
        if (e.target.classList.contains('slide-bg-color-code')) {
            var val = e.target.value;
            if (/^#[0-9A-Fa-f]{3}$|^#[0-9A-Fa-f]{6}$/.test(val)) {
                var p = row.querySelector('.slide-bg-color-picker');
                if (p) p.value = val.length === 4 ? val.replace(/#([0-9A-Fa-f])([0-9A-Fa-f])([0-9A-Fa-f])/,'#$1$1$2$2$3$3') : val;
            }
        }
    });
    document.getElementById('carousel-edit-form').addEventListener('submit', function() {
        slidesList.querySelectorAll('.slide-row').forEach(syncBgColorToCode);
        reindexSlides();
    });
});
</script>
@endpush
@else
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var developersList = document.getElementById('developers-list');
    var addDeveloperBtn = document.getElementById('add-developer');
    var devIndex = document.querySelectorAll('.developer-row').length;
    addDeveloperBtn.addEventListener('click', function() {
        var row = document.createElement('div');
        row.className = 'developer-row border rounded p-3 mb-2 bg-light';
        row.innerHTML = '<div class="row g-2">' +
            '<div class="col-md-4"><input type="text" class="form-control form-control-sm" name="developers[' + devIndex + '][name]" placeholder="Developer name" required></div>' +
            '<div class="col-md-2"><input type="text" class="form-control form-control-sm" name="developers[' + devIndex + '][logo_text]" placeholder="Logo"></div>' +
            '<div class="col-md-2"><input type="text" class="form-control form-control-sm" name="developers[' + devIndex + '][search_slug]" placeholder="Search slug"></div>' +
            '<div class="col-md-2 d-flex align-items-center"><div class="form-check"><input type="hidden" name="developers[' + devIndex + '][logo_dark]" value="0"><input type="checkbox" class="form-check-input" name="developers[' + devIndex + '][logo_dark]" value="1"><label class="form-check-label small">Dark logo</label></div></div>' +
            '<div class="col-md-2"><button type="button" class="btn btn-sm btn-outline-danger remove-developer">Remove</button></div></div>';
        developersList.appendChild(row);
        row.querySelector('.remove-developer').addEventListener('click', function() { row.remove(); });
        devIndex++;
    });
    developersList.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-developer')) e.target.closest('.developer-row').remove();
    });
});
</script>
@endpush
@endif
@endsection
