@extends('admin.layouts.app')

@section('title', 'Property List')

@section('content')

<!-- Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h4 class="mb-0">All Properties (<span id="admin-property-count">{{ $totalProperty }}</span>)</h4>
</div>

<!-- Search bar – above the list (search-as-you-type, no button) -->
<div class="card shadow-sm border-0 mb-3">
  <div class="card-body py-3">
    <form id="admin-search-form" method="GET" action="{{ request()->url() }}" class="row g-2 align-items-end">
      @foreach(request()->except('search', 'page') as $key => $val)
        @if(is_array($val))
          @foreach($val as $v)
            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
          @endforeach
        @elseif($val !== null && $val !== '')
          <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endif
      @endforeach
      <div class="col flex-grow-1">
        <label class="form-label small mb-1">Search all fields</label>
        <input type="text" id="admin-search-input" name="search" class="form-control form-control-lg" placeholder="Type to search (e.g. Marwa, JVC, townhouse)..." value="{{ request('search', $search ?? '') }}" autocomplete="off">
      </div>
      <div class="col-auto">
        <a href="{{ request()->url() }}?{{ http_build_query(request()->except('search', 'page')) }}" class="btn btn-outline-secondary btn-lg" id="admin-clear-search" style="{{ request('search', $search ?? '') ? '' : 'display:none;' }}">
          <i class="fa fa-times me-1"></i> Clear search
        </a>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
(function() {
  var form = document.getElementById('admin-search-form');
  var input = document.getElementById('admin-search-input');
  var clearBtn = document.getElementById('admin-clear-search');
  var target = document.getElementById('admin-property-list-ajax-target');
  var countEl = document.getElementById('admin-property-count');
  var timer = null;
  var debounceMs = 400;

  if (!form || !input || !target) return;

  function buildUrl() {
    var url = form.action || window.location.pathname;
    var params = new URLSearchParams();
    params.set('search', input.value.trim());
    var hiddens = form.querySelectorAll('input[type="hidden"]');
    for (var i = 0; i < hiddens.length; i++) {
      if (hiddens[i].name && hiddens[i].name !== 'search') params.set(hiddens[i].name, hiddens[i].value);
    }
    var qs = params.toString();
    return qs ? url + (url.indexOf('?') >= 0 ? '&' : '?') + qs : url;
  }

  function doSearch() {
    var url = buildUrl();
    fetch(url, {
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
      .then(function(r) { return r.json(); })
      .then(function(data) {
        if (data.html !== undefined) target.innerHTML = data.html;
        if (countEl && data.total !== undefined) countEl.textContent = data.total;
        if (window.history && window.history.replaceState) history.replaceState(null, '', url);
      })
      .catch(function() { window.location.href = url; });
  }

  input.addEventListener('input', function() {
    clearBtn.style.display = input.value.trim() ? '' : 'none';
    if (timer) clearTimeout(timer);
    timer = setTimeout(doSearch, debounceMs);
  });

  input.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      if (timer) clearTimeout(timer);
      doSearch();
    }
  });
})();
</script>
@endpush

<!-- Filter Bar -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
      <input type="hidden" name="search" value="{{ request('search', $search ?? '') }}">
      <div class="col-md-2">
        <label class="form-label">Property Type</label>
        <select name="propertyType" class="form-select">
          <option value="">All</option>
          @foreach ($propertyTypes as $key => $label)
            <option value="{{ $key }}" {{ request('propertyType') == $key ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2">
        <label class="form-label">Category</label>
        <select name="property_category_id" class="form-select">
          <option value="">All</option>
          @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('property_category_id') == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2">
        <label class="form-label">Child Type</label>
        <select name="child_type_id" class="form-select">
          <option value="">All</option>
          @foreach ($childTypes as $type)
            <option value="{{ $type->id }}" {{ request('child_type_id') == $type->id ? 'selected' : '' }}>
              {{ $type->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2">
        <label class="form-label">Status</label>
       
        <select name="verified" class="form-select">
          <option value="">All</option>
          <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Verified</option>
          <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Not Verified</option>
      </select>

      </div>

      <div class="col-md-2">
        <label class="form-label">Location</label>
        <select name="location" class="form-select">
          <option value="">All</option>
          @foreach ($locations as $loc)
            <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2 text-end">
        <button class="btn btn-sm btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
      </div>
    </form>
  </div>
</div>

@if (session('success'))
  <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div id="admin-property-list-ajax-target">
  @include('admin.partials.property-list-content')
</div>

@endsection
