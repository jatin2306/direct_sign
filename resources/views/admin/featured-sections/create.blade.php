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

    <form action="{{ route('admin.featured-sections.store') }}" method="POST" class="card shadow-sm">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Section title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Luxury Villas" required>
                    @error('title') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="heading" class="form-label">Heading (optional)</label>
                    <input type="text" class="form-control {{ $errors->has('heading') ? 'is-invalid' : '' }}" id="heading" name="heading" value="{{ old('heading') }}" placeholder="e.g. Best Picks This Month">
                    @error('heading') <div class="invalid-feedback d-block text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
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
            <hr>
            <button type="submit" class="btn btn-primary">Create Carousel</button>
        </div>
    </form>
</div>
@push('styles')
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var list = document.getElementById('property_order_list');
    var addSelect = document.getElementById('property_add');
    var searchInput = document.getElementById('property_search');
    var container = document.getElementById('property_ids_hidden_container');

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
        var opts = addSelect.querySelectorAll('option[value]');
        opts.forEach(function(opt) {
            var text = (opt.textContent || '').toLowerCase();
            opt.hidden = term.length > 0 && text.indexOf(term) < 0;
        });
    }

    function removeOptionFromDropdown(id) {
        var opt = addSelect.querySelector('option[value="' + id + '"]');
        if (opt) opt.remove();
    }
    function addOptionBackToDropdown(id, name, price) {
        if (addSelect.querySelector('option[value="' + id + '"]')) return;
        var opt = document.createElement('option');
        opt.value = id;
        opt.setAttribute('data-name', name);
        opt.setAttribute('data-price', price);
        opt.textContent = name + ' — ' + price + ' AED';
        addSelect.appendChild(opt);
        filterOptions();
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterOptions);
        searchInput.addEventListener('keyup', filterOptions);
    }

    addSelect.addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        if (!opt || !opt.value) return;
        var id = opt.value, name = opt.getAttribute('data-name') || '', price = opt.getAttribute('data-price') || '';
        if (list.querySelector('li[data-id="' + id + '"]')) return;
        var li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.setAttribute('data-id', id);
        li.setAttribute('data-name', name);
        li.setAttribute('data-price', price);
        li.innerHTML = '<span>' + (name || '') + ' — ' + (price || '') + ' AED</span><button type="button" class="btn btn-sm btn-outline-danger remove-property">Remove</button>';
        list.appendChild(li);
        removeOptionFromDropdown(id);
        addSelect.selectedIndex = 0;
        filterOptions();
        syncHiddenInputs();
    });

    list.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-property')) {
            var li = e.target.closest('li');
            if (li) {
                addOptionBackToDropdown(li.getAttribute('data-id'), li.getAttribute('data-name') || '', li.getAttribute('data-price') || '');
                li.remove();
                syncHiddenInputs();
            }
        }
    });

    if (typeof Sortable !== 'undefined') {
        new Sortable(list, { animation: 150, onEnd: syncHiddenInputs });
    }
    list.querySelectorAll('li[data-id]').forEach(function(li) {
        removeOptionFromDropdown(li.getAttribute('data-id'));
    });
    filterOptions();
    syncHiddenInputs();

    document.querySelector('form').addEventListener('submit', function() {
        syncHiddenInputs();
    });
});
</script>
@endpush
@endsection
