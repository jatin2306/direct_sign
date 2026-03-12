@extends('admin.layouts.app')

@section('title', 'Add Carousel')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add Carousel</h4>
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

    <form action="{{ route('admin.featured-sections.store') }}" method="POST" class="card shadow-sm" id="carousel-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" id="section_type" value="{{ old('type', 'properties') }}">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <label for="type_select" class="form-label">Section type <span class="text-danger">*</span></label>
                    <select class="form-select" id="type_select" required>
                        <option value="properties" {{ old('type', 'properties') === 'properties' ? 'selected' : '' }}>Property carousel</option>
                        <option value="image_carousel" {{ old('type') === 'image_carousel' ? 'selected' : '' }}>Image carousel</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="title" class="form-label">Section title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Luxury Villas or Projects by developers in the UAE" required>
                    @error('title') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 form-group-heading">
                    <label for="heading" class="form-label">Heading (optional)</label>
                    <input type="text" class="form-control {{ $errors->has('heading') ? 'is-invalid' : '' }}" id="heading" name="heading" value="{{ old('heading') }}" placeholder="e.g. Best Picks This Month">
                    @error('heading') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 form-group-placement">
                    <label for="heading_placement" class="form-label">Heading placement</label>
                    <select class="form-select {{ $errors->has('heading_placement') ? 'is-invalid' : '' }}" id="heading_placement" name="heading_placement">
                        <option value="left" {{ old('heading_placement', 'left') === 'left' ? 'selected' : '' }}>Left</option>
                        <option value="center" {{ old('heading_placement') === 'center' ? 'selected' : '' }}>Center</option>
                        <option value="right" {{ old('heading_placement') === 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                    @error('heading_placement') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="sort_order" class="form-label">Sort order</label>
                    <input type="number" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    @error('sort_order') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="is_active" class="form-label">Status</label>
                    <select class="form-select {{ $errors->has('is_active') ? 'is-invalid' : '' }}" id="is_active" name="is_active">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active (show on homepage)</option>
                        <option value="0" {{ old('is_active') === '0' || old('is_active') === 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Property carousel fields --}}
                <div id="properties-fields" class="carousel-type-fields col-12">
                    <div class="col-12">
                        <label for="property_search" class="form-label">Add property <span class="text-muted">(approved only)</span></label>
                        <input type="text" id="property_search" class="form-control mb-2" placeholder="Type to search properties..." autocomplete="off">
                        <select id="property_add" class="form-select">
                            <option value="">-- Select a property (use search above to filter) --</option>
                            @foreach($availableProperties as $prop)
                                <option value="{{ $prop->id }}" data-name="{{ e($prop->propertyName) }}" data-price="{{ number_format($prop->price) }}">{{ $prop->propertyName }} — {{ number_format($prop->price) }} AED</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Only approved (verified) properties. Order in the list below = display order in the carousel.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Properties in this carousel <span class="text-danger">*</span> <small class="text-muted">(drag to set display order)</small></label>
                        <ul id="property_order_list" class="list-group list-group-numbered {{ $errors->has('property_ids') ? 'border border-danger' : '' }}" style="min-height: 60px;">
                            @foreach(old('property_ids', []) as $pid)
                                @php $p = $availableProperties->firstWhere('id', (int)$pid); @endphp
                                @if($p)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $p->id }}" data-name="{{ e($p->propertyName) }}" data-price="{{ number_format($p->price) }}">
                                        <span>{{ $p->propertyName }} — {{ number_format($p->price) }} AED</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-property">Remove</button>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div id="property_ids_hidden_container"></div>
                        @error('property_ids') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Image carousel fields --}}
                <div id="image-carousel-fields" class="carousel-type-fields col-12" style="display: none;">
                    <div class="col-12">
                        <label for="image_heading_placement" class="form-label">Heading placement</label>
                        <select class="form-select" id="image_heading_placement" name="heading_placement">
                            <option value="left" {{ old('heading_placement', 'left') === 'left' ? 'selected' : '' }}>Left</option>
                            <option value="center" {{ old('heading_placement') === 'center' ? 'selected' : '' }}>Center</option>
                            <option value="right" {{ old('heading_placement') === 'right' ? 'selected' : '' }}>Right</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Image slides <span class="text-danger">*</span></label>
                        <p class="text-muted small">Add as many slides as you need. Drag rows to set display order (like property carousel). Each slide: image (drag & drop or click), headings, and CTA URL.</p>
                        <p class="text-muted small mb-2"><strong>Image size:</strong> Recommended <strong>600 × 400 px</strong>. When the image is small, use <strong>Background color</strong> to fill the empty space (e.g. #ffffff or hex code).</p>
                        <div id="slides-list" class="slides-sortable">
                            @php $oldSlides = old('slides', [['heading'=>'','second_heading'=>'','heading_order'=>'1','cta_url'=>'','background_color'=>'']]); @endphp
                            @foreach($oldSlides as $idx => $s)
                            <div class="slide-row border rounded p-3 mb-2 bg-light slide-row-draggable">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-2">
                                        <label class="form-label small mb-0">Image</label>
                                        <div class="slide-image-dropzone border rounded p-2 text-center bg-white" style="min-height:80px; border-style:dashed;">
                                            <input type="file" class="d-none slide-image-input" name="slides[{{ $idx }}][image]" accept="image/*">
                                            <div class="slide-dropzone-inner">
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
                                            <input type="color" class="form-control form-control-color slide-bg-color-picker" style="width:2.5rem;height:2rem;padding:2px;" value="{{ $s['background_color'] ?? '#ffffff' }}" title="Pick color">
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
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Create Carousel</button>
        </div>
    </form>
</div>
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
    var typeSelect = document.getElementById('type_select');
    var sectionTypeHidden = document.getElementById('section_type');
    var propertiesFields = document.getElementById('properties-fields');
    var imageCarouselFields = document.getElementById('image-carousel-fields');
    var list = document.getElementById('property_order_list');
    var addSelect = document.getElementById('property_add');
    var searchInput = document.getElementById('property_search');
    var container = document.getElementById('property_ids_hidden_container');
    var slidesList = document.getElementById('slides-list');
    var addSlideBtn = document.getElementById('add-slide');
    var headingPlacementProp = document.querySelector('.form-group-placement select[name="heading_placement"]');
    var headingPlacementImage = document.getElementById('image_heading_placement');

    function setType(type) {
        sectionTypeHidden.value = type;
        if (type === 'image_carousel') {
            propertiesFields.style.display = 'none';
            imageCarouselFields.style.display = 'block';
            document.querySelectorAll('.form-group-heading').forEach(function(el) { el.style.display = 'none'; });
            document.querySelectorAll('.form-group-placement').forEach(function(el) { el.style.display = 'none'; });
            if (headingPlacementProp) headingPlacementProp.disabled = true;
            if (headingPlacementImage) headingPlacementImage.disabled = false;
            list.querySelectorAll('li').forEach(function(li) { li.remove(); });
            addSelect.querySelectorAll('option[value]').forEach(function(o) { o.removeAttribute('disabled'); });
        } else {
            propertiesFields.style.display = 'block';
            imageCarouselFields.style.display = 'none';
            document.querySelectorAll('.form-group-heading').forEach(function(el) { el.style.display = ''; });
            document.querySelectorAll('.form-group-placement').forEach(function(el) { el.style.display = ''; });
            if (headingPlacementProp) headingPlacementProp.disabled = false;
            if (headingPlacementImage) headingPlacementImage.disabled = true;
        }
    }
    typeSelect.addEventListener('change', function() { setType(this.value); });
    setType(typeSelect.value);

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
        row.innerHTML = '<div class="row g-2 align-items-end">' +
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

    function syncHiddenInputs() {
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
            var text = (opt.textContent || '').toLowerCase();
            opt.hidden = term.length > 0 && text.indexOf(term) < 0;
        });
    }
    if (searchInput) { searchInput.addEventListener('input', filterOptions); searchInput.addEventListener('keyup', filterOptions); }
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
    syncHiddenInputs();

    document.getElementById('carousel-form').addEventListener('submit', function() {
        if (sectionTypeHidden.value === 'image_carousel') {
            slidesList.querySelectorAll('.slide-row').forEach(syncBgColorToCode);
            reindexSlides();
        }
        if (sectionTypeHidden.value === 'properties') syncHiddenInputs();
    });
});
</script>
@endpush
@endsection
