@extends('layouts.home')

@section('title', 'Dubai Properties for Sale & Rent | Verified Listings | Direct Deal UAE')
@section('meta_description', 'Browse verified properties for sale and rent in Dubai including apartments, villas and investment opportunities with transparent brokerage fees.')

@section('content')

<!-- Listing section: one top line (Properties + Filter + Sort by), then sidebar + listings -->
<section class="space-ptb" style="padding: 20px 0 24px 0;">
    <div class="container">
        <!-- One line at top: Properties (breadcrumb) + Filter label on left, Sort by on right -->
        <div class="row listing-top-bar align-items-center mb-3">
            <div class="col-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <ol class="breadcrumb mb-0 py-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
                            @foreach (Request::segments() as $segment)
                            <li class="breadcrumb-item">
                                <i class="fas fa-chevron-right"></i>
                                @if ($loop->last)
                                <span>{{ ucfirst($segment) }}</span>
                                @else
                                <a href="{{ url(implode('/', array_slice(Request::segments(), 0, $loop->index + 1))) }}">{{ ucfirst($segment) }}</a>
                                @endif
                            </li>
                            @endforeach
                        </ol>
                  
                    </div>
                    <form class="d-flex align-items-center" method="GET" action="{{ route('property.index') }}">
                        @foreach (request()->only(['propertyType', 'property_category_id', 'child_type_id', 'status', 'bedrooms', 'bathrooms', 'location', 'priceMin', 'priceMax', 'areaMin', 'areaMax']) as $key => $val)
                            @if ($val !== null && $val !== '')
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
              
                        <select class="form-select form-select-sm" id="sort" name="sort" onchange="this.form.submit()" style="min-width: 160px;">
                            <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Sort By</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Old to New</option>
                            <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>New to Old</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
<style>
    /* Apply directly to the .irs-single element */
    .irs-single {
        left: 0 !important;
        /* Adjust the value as needed */
    }

    /* For filter to appear in second line */
    .filter-list {
        display: flex;
        flex-wrap: wrap;
        /* Allow items to wrap to a new line */
        justify-content: flex-start;
        /* Align items to the left */
        align-items: flex-start;
        /* Ensure items align at the top */
        gap: 10px;
        /* Add spacing between items */
        margin: 0;
        /* Remove any default margin */
        padding: 0;
        /* Remove padding if necessary */
        position: relative;
        /* Allow positioning of reset button inside */
        padding-right: 120px;
        /* Make space for the reset button on the right */
    }

    .filter-list .list-inline-item {
        flex: 0 1 auto;
        /* Allow items to grow but not shrink */
        min-width: 120px;
        /* Set a minimum width for each filter item */
        margin-bottom: 10px;
        /* Add margin at the bottom for spacing */
    }

    .filter-clear {
        position: absolute;
        /* Keep reset button fixed inside the list */
        right: 0;
        /* Align it to the right side of the parent container */
        top: 0;
        /* Align it to the top of the list */
        margin-top: 10px;
        /* Add some spacing from the top */
        margin-right: 20px;
        /* Adjust right margin for spacing */
    }

    @media (max-width: 768px) {
        .filter-list .list-inline-item {
            min-width: 100%;
            /* Allow each filter item to take up full width on small screens */
        }

        .filter-clear {
            top: 10px;
            /* Adjust top margin for mobile screens */
            right: 10px;
            /* Ensure reset button stays in place on smaller screens */
        }
    }

    /* Price filter: one line – min input, dash, max input */
    .price-filter-block {
        margin-top: 0.5rem;
        background: linear-gradient(135deg, #f8fbf9 0%, #f0f7f3 100%);
        border: 1px solid #e2ede6;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 1px 3px rgba(38, 174, 97, 0.06);
    }
    .price-filter-heading {
        font-size: 13px;
        font-weight: 700;
        color: #1a2e22;
        margin: 0 0 12px 0;
        letter-spacing: 0.02em;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .price-filter-heading .price-filter-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #26ae61;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    .price-filter-inline {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .price-filter-inline .price-filter-input-wrap {
        flex: 1;
        min-width: 60px;
    }
    .price-filter-inline .price-filter-sep {
        color: #5a6c7d;
        font-weight: 600;
        font-size: 16px;
        flex-shrink: 0;
    }
    .price-filter-input,
    .price-filter-block .form-control.price-filter-input {
        border-radius: 10px;
        border: 1px solid #d0e0d6;
        padding: 10px 12px;
        font-size: 14px;
        width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        background: #fff;
    }
    .price-filter-input:hover {
        border-color: #26ae61;
        background: #fff;
    }
    .price-filter-input:focus {
        border-color: #26ae61;
        box-shadow: 0 0 0 3px rgba(38, 174, 97, 0.18);
        outline: none;
        background: #fff;
    }
    .price-filter-block .form-control.price-filter-input::placeholder {
        color: #8fa89a;
        font-size: 13px;
    }

    #filterSubmitBtn:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }
</style>
<section class="space-ptb" style="padding: 20px 0 24px 0;">
    <div class="container">
        <style>
            /* Highlight only when a selection is made */
            .select2-container--default .select2-selection--single.filled {
                background-color: rgba(38, 174, 97, 0.1) !important;
                /* Light yellow */
                border: 1px solid #26ae61 !important;
                /* Orange border */
            }

            .property-filter {
                padding: 4px;
            }

            /* Top bar: Properties + Filter + Sort by in one line */
            .listing-top-bar {
                padding: 12px 0;
                border-bottom: 1px solid #e2ede6;
            }
            .listing-top-bar .breadcrumb {
                background: transparent;
                padding: 0;
            }
        </style>
        <style>
            .small-btn {
                font-size: 14px;
                /* Smaller text */
                padding: 6px 10px !important;
                /* Reduce padding */
            }

            /* Fix disappearing button after click */
            .small-btn:focus,
            .small-btn:active {
                background-color: #ffffff !important;
                /* Keep background white */
                color: #198754 !important;
                /* Keep text green */
                border-color: #198754 !important;
                /* Keep border green */
                box-shadow: none !important;
                /* Remove outline */
            }
        </style>
        <style>
            .small-btn {
                font-size: 14px;
                /* Smaller text */
                padding: 6px 10px !important;
                /* Reduce padding */
            }
        </style>
        <div class="row">
            <div class="col-lg-3 mb-lg-0">
                <!-- Sidebar Container -->
                <div class="sidebar-container">
                    <div class="sidebar">

                        <!-- Advanced Filter (Visible on Mobile & Desktop) -->
                        <div class="widget">
                            <div class="widget-title widget-collapse">
                                <h6>Advanced Filter</h6>
                                <a class="ms-auto d-lg-none collapse-toggle" href="#filter-property" role="button"
                                    data-toggle="collapse" data-target="#filter-property" data-bs-toggle="collapse" data-bs-target="#filter-property"
                                    aria-expanded="false" aria-controls="filter-property">
                                    <i class="fas fa-chevron-down"></i>
                                </a>
                            </div>
                            <div class="collapse d-lg-block" id="filter-property">
                                <form method="GET" action="{{ route('property.index') }}" class="mt-3">
                                    <!-- Property Type (reflects homepage selection: Buy / Rent / Off Plan) -->
                                    @php $reqPropertyType = request('propertyType'); $reqPropertyType = $reqPropertyType !== null ? (string) $reqPropertyType : ''; @endphp
                                    <div class="mb-2 select-border">
                                        <select name="propertyType" id="propertyType" class="form-control basic-select">
                                            <option value="">Select Property Type</option>
                                            @foreach ($propertyTypes as $key => $type)
                                            <option value="{{ $key }}" {{ $reqPropertyType !== '' && $reqPropertyType === (string)$key ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-2 select-border">
                                        <select name="property_category_id" id="category" class="form-control basic-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('property_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Bedrooms -->
                                    <div class="mb-2 select-border">
                                        <select name="bedrooms" id="bedrooms" class="form-control basic-select">
                                            <option value="">Select Bedrooms</option>
                                            <option value="0" {{ request('bedrooms') === '0' ? 'selected' : '' }}>
                                                Studio Apartment
                                            </option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ $i > 1 ? 'Bedrooms' : 'Bedroom' }}
                                                </option>
                                                @endfor

                                        </select>
                                    </div>

                                    <!-- Bathrooms -->
                                    <div class="mb-2 select-border">
                                        <select name="bathrooms" id="bathrooms" class="form-control basic-select">
                                            <option value="">Select Bathrooms</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ $i > 1 ? 'Bathrooms' : 'Bathroom' }}
                                                </option>
                                                @endfor
                                        </select>
                                    </div>

                                    <!-- Location -->
                                    @php
                                    $currentLocation = request('location');
                                    $currentLocation = $currentLocation !== null && $currentLocation !== '' ? trim((string) $currentLocation) : '';
                                    if (strtolower($currentLocation) === 'not specified') {
                                    $currentLocation = '';
                                    }
                                    @endphp
                                    <div class="mb-2 select-border">
                                        <select name="location" id="location" class="form-control basic-select" data-placeholder="Select Location">
                                            <option value="">Select Location</option>
                                            @foreach ($locations as $loc)
                                            <option value="{{ $loc }}" {{ $currentLocation !== '' && $currentLocation == $loc ? 'selected' : '' }}>
                                                {{ $loc }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $('#location').select2({
                                                placeholder: "Select Location",
                                                allowClear: true
                                            });
                                        });
                                    </script>
                                    <style>
                                        .select2-container--default .select2-selection--single .select2-selection__placeholder {
                                            color: #3a4957 !important;

                                        }
                                    </style>

                                    <!-- Price: Min & Max in one line (formatted with commas, auto-expand) -->
                                    @php
                                    $reqPriceMin = request('priceMin');
                                    $reqPriceMax = request('priceMax');
                                    $reqAreaMin = request('areaMin');
                                    $reqAreaMax = request('areaMax');
                                    $fmt = function($v) {
                                        if ($v === null || $v === '') return '';
                                        $n = (int) preg_replace('/[^0-9]/', '', (string) $v);
                                        if ($n === 0) return '0';
                                        $s = (string) $n;
                                        if (strlen($s) <= 3) return $s;
                                        $last3 = substr($s, -3);
                                        $rest = substr($s, 0, -3);
                                        $len = strlen($rest);
                                        $r = '';
                                        for ($i = 0; $i < $len; $i++) {
                                            if ($i > 0 && ($len - $i) % 2 === 0) $r .= ',';
                                            $r .= $rest[$i];
                                        }
                                        return $r . ',' . $last3;
                                    };
                                    @endphp
                                    <div class="mb-3 mt-3 price-filter-block">
                                        <h6 class="price-filter-heading">
                                            <span class="price-filter-icon"><i class="fas fa-coins"></i></span>
                                            Price Range (AED)
                                        </h6>
                                        <div class="price-filter-inline">
                                            <div class="price-filter-input-wrap">
                                                <input type="text" inputmode="numeric" name="priceMin" id="filterPriceMin" class="form-control price-filter-input formatted-number"
                                                    placeholder="No min."
                                                    value="{{ $reqPriceMin !== null && $reqPriceMin !== '' ? $fmt($reqPriceMin) : '' }}">
                                            </div>
                                            <span class="price-filter-sep">–</span>
                                            <div class="price-filter-input-wrap">
                                                <input type="text" inputmode="numeric" name="priceMax" id="filterPriceMax" class="form-control price-filter-input formatted-number"
                                                    placeholder="No max."
                                                    value="{{ $reqPriceMax !== null && $reqPriceMax !== '' ? $fmt($reqPriceMax) : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Area: Min & Max in one line (sqft, same formatting) -->
                                    <div class="mb-3 mt-3 price-filter-block">
                                        <h6 class="price-filter-heading">
                                            <span class="price-filter-icon"><i class="fas fa-ruler-combined"></i></span>
                                            Area Range (Sq Ft)
                                        </h6>
                                        <div class="price-filter-inline">
                                            <div class="price-filter-input-wrap">
                                                <input type="text" inputmode="numeric" name="areaMin" id="filterAreaMin" class="form-control price-filter-input formatted-number"
                                                    placeholder="No min."
                                                    value="{{ $reqAreaMin !== null && $reqAreaMin !== '' ? $fmt($reqAreaMin) : '' }}">
                                            </div>
                                            <span class="price-filter-sep">–</span>
                                            <div class="price-filter-input-wrap">
                                                <input type="text" inputmode="numeric" name="areaMax" id="filterAreaMax" class="form-control price-filter-input formatted-number"
                                                    placeholder="No max."
                                                    value="{{ $reqAreaMax !== null && $reqAreaMax !== '' ? $fmt($reqAreaMax) : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit & Reset -->
                                    <div class="d-grid mb-2">
                                        <button class="btn btn-primary align-items-center" type="submit" id="filterSubmitBtn" disabled>
                                            <i class="fas fa-filter me-1"></i><span>Filter</span>
                                        </button>
                                    </div>
                                    <div class="d-grid mb-2">
                                        <a href="{{ route('property.index') }}" class="btn btn-secondary align-items-center">
                                            <i class="fas fa-redo-alt me-1"></i><span>Reset</span>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            (function() {
                                function stripCommas(s) {
                                    return (s == null ? '' : String(s)).replace(/,/g, '');
                                }
                                function formatIndianNumber(val) {
                                    var s = String(val).replace(/\D/g, '');
                                    if (!s) return '';
                                    if (s.length <= 3) return s;
                                    var last3 = s.slice(-3);
                                    var rest = s.slice(0, -3);
                                    rest = rest.replace(/(\d)(?=(\d{2})+$)/g, '$1,');
                                    return rest + ',' + last3;
                                }
                                function setupFormattedNumberInput(id) {
                                    var input = document.getElementById(id);
                                    if (!input) return;
                                    input.addEventListener('input', function() {
                                        var start = this.selectionStart;
                                        var prevLen = this.value.length;
                                        var raw = stripCommas(this.value);
                                        this.value = formatIndianNumber(raw);
                                        var newLen = this.value.length;
                                        var newStart = Math.max(0, start + (this.value.length - prevLen));
                                        this.setSelectionRange(newStart, newStart);
                                    });
                                }
                                function getFormSnapshot(form) {
                                    var fd = new FormData(form);
                                    var o = {};
                                    fd.forEach(function(v, k) {
                                        if (k === 'priceMin' || k === 'priceMax' || k === 'areaMin' || k === 'areaMax') {
                                            v = stripCommas(v);
                                        }
                                        o[k] = v;
                                    });
                                    return JSON.stringify(o);
                                }
                                document.addEventListener('DOMContentLoaded', function() {
                                    setupFormattedNumberInput('filterPriceMin');
                                    setupFormattedNumberInput('filterPriceMax');
                                    setupFormattedNumberInput('filterAreaMin');
                                    setupFormattedNumberInput('filterAreaMax');

                                    var form = document.querySelector('#filter-property form');
                                    if (!form) return;

                                    form.addEventListener('submit', function() {
                                        ['filterPriceMin', 'filterPriceMax', 'filterAreaMin', 'filterAreaMax'].forEach(function(id) {
                                            var el = document.getElementById(id);
                                            if (el && el.value) el.value = stripCommas(el.value);
                                        });
                                    });

                                    var filterBtn = document.getElementById('filterSubmitBtn');
                                    var initialSnapshot = getFormSnapshot(form);

                                    function checkFilterDirty() {
                                        if (!filterBtn) return;
                                        var current = getFormSnapshot(form);
                                        filterBtn.disabled = (current === initialSnapshot);
                                    }

                                    form.querySelectorAll('select, input').forEach(function(el) {
                                        el.addEventListener('change', checkFilterDirty);
                                        el.addEventListener('input', checkFilterDirty);
                                    });

                                    $(form).on('change', 'select, input', checkFilterDirty);
                                    if (form.querySelector('#location')) {
                                        $(form).on('change', '#location', checkFilterDirty);
                                    }

                                    setTimeout(function() {
                                        initialSnapshot = getFormSnapshot(form);
                                        checkFilterDirty();
                                    }, 200);

                                    checkFilterDirty();
                                });
                            })();
                        </script>

                        <!-- Desktop-Only Widgets -->
                        <div class="d-none d-lg-block">

                            <!-- Status of Property -->
                            <div class="widget">
                                <div class="widget-title widget-collapse">
                                    <h6>Status of Property</h6>
                                    <a class="ms-auto collapse-toggle" href="#status-property" role="button"
                                        data-toggle="collapse" data-target="#status-property" data-bs-toggle="collapse" data-bs-target="#status-property">
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                </div>
                                <div class="collapse show" id="status-property">
                                    <ul class="list-unstyled mb-0 pt-3">
                                        @foreach ($statuses as $key => $status)
                                        @if(($statusCounts[$key] ?? 0) > 0)
                                        <li>
                                            <a href="{{ route('property.index', array_merge(request()->query(), ['status' => $key, 'page' => 1])) }}">
                                                {{ $status }} <span class="ms-auto">({{ $statusCounts[$key] ?? 0 }})</span>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Type of Property -->
                            <div class="widget">
                                <div class="widget-title widget-collapse">
                                    <h6>Type of Property</h6>
                                    <a class="ms-auto collapse-toggle" href="#type-property" role="button"
                                        data-toggle="collapse" data-target="#type-property" data-bs-toggle="collapse" data-bs-target="#type-property">
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                </div>
                                <div class="collapse show" id="type-property">
                                    <ul class="list-unstyled mb-0 pt-3">
                                        @foreach ($propertyTypes as $key => $type)
                                        @if(($propertyTypeCounts[$type] ?? 0) > 0)
                                        <li>
                                            <a href="{{ route('property.index', array_merge(request()->query(), ['propertyType' => $key, 'page' => 1])) }}">
                                                {{ $type }} <span class="ms-auto">({{ $propertyTypeCounts[$type] ?? 0 }})</span>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>


                            <!-- Property Category -->
                            <div class="widget">
                                <div class="widget-title widget-collapse">
                                    <h6>Property Category</h6>
                                    <a class="ms-auto collapse-toggle" href="#category-property" role="button"
                                        data-toggle="collapse" data-target="#category-property" data-bs-toggle="collapse" data-bs-target="#category-property">
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                </div>
                                <div class="collapse show" id="category-property">
                                    <ul class="list-unstyled mb-0 pt-3">
                                        @foreach ($categories as $category)
                                        @if($category->properties_count > 0)
                                        <li>
                                            <a href="{{ route('property.index', array_merge(request()->query(), ['property_category_id' => $category->id, 'page' => 1])) }}">
                                                {{ $category->name }} <span class="ms-auto">({{ $category->properties_count }})</span>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Child Property Type -->
                            <div class="widget">
                                <div class="widget-title widget-collapse">
                                    <h6>Property Type</h6>
                                    <a class="ms-auto collapse-toggle" href="#childType-property" role="button"
                                        data-toggle="collapse" data-target="#childType-property" data-bs-toggle="collapse" data-bs-target="#childType-property">
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                </div>
                                <div class="collapse show" id="childType-property">
                                    <ul class="list-unstyled mb-0 pt-3">
                                        @foreach ($childTypes as $childType)
                                        @if($childType->properties_count > 0)
                                        <li>
                                            <a href="{{ route('property.index', array_merge(request()->query(), ['child_type_id' => $childType->id, 'page' => 1])) }}">
                                                {{ $childType->name }} <span class="ms-auto">({{ $childType->properties_count }})</span>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-9">

                @if ($properties->isEmpty())
                <!--=================================
                          No Properties Found -->
                <section class="py-5 bg-light text-center">
                    <div class="container">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-4">
                                <img class="img-fluid mb-4" src="{{ asset('images/no-found.png') }}"
                                    alt="No Properties Found" style="max-width: 200px;">
                            </div>
                            <div class="col-md-6">
                                <h3 class="mb-3 text-primary">No Properties Found</h3>
                                <p class="text-muted">We couldn't find any listings matching your search criteria.
                                </p>
                                <ul class="list-unstyled small text-muted text-start d-inline-block">
                                    <li>✔ Update search filters for better results.</li>
                                    <li>✔ Double-check your search terms and spelling.</li>
                                    <li>✔ Try using alternative keywords (e.g., "house" instead of "villa").</li>
                                </ul>
                                <div class="mt-4 d-flex justify-content-center gap-3">
                                    <a href="{{ route('property.index') }}"
                                        class="btn btn-primary btn-sm px-4 py-2">
                                        <i class="fas fa-sync-alt"></i>Reset Filters
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--=================================
    No Properties Found -->




                @if (!empty($suggestedProperties) && $suggestedProperties->isNotEmpty())
                <div class="suggested-properties mt-5">
                    <h4 class="mb-4">Suggested Properties</h4>
                    @foreach ($suggestedProperties as $property)
                    <div class="property-item property-col-list mt-4" data-href="{{ route('property.show', $property->slug ?? $property->id) }}">


                        <div class="row g-0">
                            <div class="col-lg-4 col-md-5" style="cursor: pointer;">
                                <div class="property-image bg-overlay-gradient-04">
                                    <img class="img-fluid"
                                        src="{{ $property->pictures->first() ? asset('storage/' . $property->pictures->first()->path) : asset('images/placeholder.jpg') }}"
                                        class="card-img-top" alt="{{ $property->propertyName }}">

                                    <div class="property-lable">
                                        <span
                                            class="badge badge-md bg-primary">{{ $property->childTypeRelation ? $property->childTypeRelation->name : 'No Child Type' }}</span>
                                        <span
                                            class="badge badge-md bg-info">{{ $propertyTypes[$property->propertyType] ?? 'Unknown' }}</span>
                                    </div>
                                    <span class="property-trending" title="trending"><i
                                            class="fas fa-bolt"></i></span>

                                    <div class="property-agent-popup">
                                        <a href="#"><i class="fas fa-camera"></i>
                                            {{ $property->pictures->count() }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-7"
                                style="cursor: pointer;">
                                <div class="property-details">
                                    <div class="property-details-inner">
                                        <div class="property-details-inner-box">
                                            <div class="property-details-inner-box-left">
                                                <h5 class="property-title"><a
                                                        href="{{ route('property.show', $property->slug ?? $property->id) }}">{{ $property->propertyName }}</a>
                                                </h5>
                                                <span class="property-address"><i
                                                        class="fas fa-map-marker-alt fa-xs"></i>{{ $property->address }}</span>
                                                <span class="property-agent-date"><i
                                                        class="far fa-clock fa-md"></i>{{ $property->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="property-price">
                                                {{ number_format($property->price) }} AED
                                            </div>
                                        </div>
                                        <ul class="property-info list-unstyled d-flex">
                                            <li class="flex-fill property-bed">
                                                <i class="fas fa-bed"></i>
                                                Bed
                                                <span>
                                                    {{ $property->bedrooms == 0 ? 'Studio' : $property->bedrooms . ($property->bedrooms > 5 ? '+' : '') }}
                                                </span>
                                            </li>

                                            <li class="flex-fill property-bath">
                                                <i
                                                    class="fas fa-bath"></i>Bath<span>{{ $property->bathrooms }}{{ $property->bathrooms > 5 ? '+' : '' }}</span>
                                            </li>
                                            <li class="flex-fill property-m-sqft">
                                                <i
                                                    class="far fa-square"></i>sqft<span>{{ $property->builtArea }}</span>
                                            </li>
                                        </ul>
                                        <p class="mb-0 mt-3">For those of you who are serious about having
                                            more, doing more, giving more and being with some understanding.
                                        </p>
                                    </div>

                                    <div class="container px-3">
                                        <div class="row g-2 justify-content-center justify-content-md-end">
                                            <div class="col-6 col-sm-3">
                                                <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" href="tel:+971581144230">
                                                    <i class="fas fa-phone fa-flip-horizontal me-2"></i> Call
                                                </a>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" href="mailto:info@directdeal.ae">
                                                    <i class="fas fa-envelope me-2"></i> Email
                                                </a>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" href="https://wa.me/971581144230" target="_blank">
                                                    <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                                </a>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" data-bs-toggle="tooltip" title="Favourite" href="#"
                                                    onclick="event.preventDefault(); document.getElementById('favorite-form-{{ $property->id }}').submit();">
                                                    @php $isFav = auth()->check() && $property->isFavoritedBy(auth()->user()); @endphp
                                                    <i class="{{ $isFav ? 'fas fa-heart text-success' : 'far fa-heart' }}"></i> Favorite
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                    <form id="favorite-form-{{ $property->id }}" action="{{ route('toggleFavorite', $property->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
                @endif
                @else
                @foreach ($properties as $property)
                <div class="property-item property-col-list mt-1" data-href="{{ route('property.show', $property->slug ?? $property->id) }}">

                    <div class="row g-0">
                        <div class="col-lg-4 col-md-5" style="cursor: pointer;">
                            <div class="property-image bg-overlay-gradient-04">

                                <img class="img-fluid"
                                    src="{{ $property->pictures->first() ? asset('storage/' . $property->pictures->first()->path) : asset('images/placeholder.jpg') }}"
                                    class="card-img-top" alt="{{ $property->propertyName }}">

                                <div class="property-lable">
                                    <span
                                        class="badge badge-md bg-primary">{{ $property->childTypeRelation ? $property->childTypeRelation->name : 'No Child Type' }}</span>
                                    <span
                                        class="badge badge-md bg-info">{{ $propertyTypes[$property->propertyType] ?? 'Unknown' }}
                                    </span>
                                </div>
                                <span class="property-trending" title="trending"><i
                                        class="fas fa-bolt"></i></span>

                                <div class="property-agent-popup">
                                    <a href="#"><i class="fas fa-camera"></i>
                                        {{ $property->pictures->count() }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-7"
                            data-href="{{ route('property.show', $property->slug ?? $property->id) }}" style="cursor: pointer;">
                            <div class="property-details">
                                <div class="property-details-inner">
                                    <div class="property-details-inner-box d-flex justify-content-between align-items-start flex-wrap">
                                        <div class="property-details-inner-box-left" style="max-width: 75%;">
                                            <h5 class="property-title">
                                                <a href="{{ route('property.show', $property->slug ?? $property->id) }}">{{ $property->propertyName }}</a>
                                            </h5>
                                            <span class="property-address d-block text-truncate">
                                                <i class="fas fa-map-marker-alt fa-xs"></i> {{ $property->address }}
                                            </span>
                                            <span class="property-agent-date d-block">
                                                <i class="far fa-clock fa-md"></i> {{ $property->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <div class="property-price text-end" style="white-space: nowrap; min-width: 120px;">
                                            {{ number_format($property->price) }} AED
                                        </div>
                                    </div>

                                    <ul class="property-info list-unstyled d-flex">
                                        <li class="flex-fill property-bed">
                                            <i class="fas fa-bed"></i>
                                            @if($property->bedrooms == 0)
                                            Studio
                                            @else
                                            Bed<span>{{ $property->bedrooms }}{{ $property->bedrooms > 5 ? '+' : '' }}</span>
                                            @endif
                                        </li>

                                        <li class="flex-fill property-bath">
                                            <i
                                                class="fas fa-bath"></i>Bath<span>{{ $property->bathrooms }}{{ $property->bathrooms > 5 ? '+' : '' }}</span>
                                        </li>
                                        <li class="flex-fill property-m-sqft"><i
                                                class="far fa-square"></i>sqft<span>{{ $property->builtArea }}</span>
                                        </li>
                                    </ul>
                                    <p class="mb-0 mt-3">For those of you who are serious about having more,
                                        doing
                                        more, giving more and being with some understanding.</p>
                                </div>

                                <div class="container px-3">
                                    <div class="row g-2 justify-content-center justify-content-md-end">
                                        <div class="col-6 col-sm-3">
                                            <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" href="tel:+971581144230">
                                                <i class="fas fa-phone fa-flip-horizontal me-2"></i> Call
                                            </a>
                                        </div>


                                        @php
                                        $subject = rawurlencode('Interested in ' . $property->propertyName . ' - ' . number_format($property->price, 0) . ' AED');

                                        $bodyText = "I'm interested to buy this property: {$property->propertyName}\n" . route('property.show', $property->slug ?? $property->id);

                                        $body = rawurlencode($bodyText);

                                        $mailto = "mailto:info@directdeal.ae?subject={$subject}&body={$body}";
                                        @endphp

                                        <div class="col-6 col-sm-3">
                                            <!-- <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" href="mailto:info@directdeal.ae"> -->
                                            <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" href="{{ $mailto }}">
                                                <i class="fas fa-envelope me-2"></i> Email
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" href="https://wa.me/971581144230" target="_blank">
                                                <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <a class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center px-3 py-2" data-bs-toggle="tooltip" title="Favourite" href="#"
                                                onclick="event.preventDefault(); document.getElementById('favorite-form-{{ $property->id }}').submit();">
                                                @php $isFav = auth()->check() && $property->isFavoritedBy(auth()->user()); @endphp
                                                <i class="{{ $isFav ? 'fas fa-heart text-success' : 'far fa-heart' }}"></i> Favorite
                                            </a>
                                        </div>
                                    </div>
                                </div>


                                <form id="favorite-form-{{ $property->id }}" action="{{ route('toggleFavorite', $property->id) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>



                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                <div class="row">
                    <div class="col-12">
                        <ul class="pagination mt-3">
                            @if ($properties->onFirstPage())
                            <li class="page-item disabled me-auto">
                                <span class="page-link b-radius-none">Prev</span>
                            </li>
                            @else
                            <li class="page-item me-auto">
                                <a class="page-link b-radius-none"
                                    href="{{ $properties->previousPageUrl() }}">Prev</a>
                            </li>
                            @endif
                            @foreach ($properties->getUrlRange(1, $properties->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $properties->currentPage() ? 'active' : '' }}">
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            </li>
                            @endforeach
                            @if ($properties->hasMorePages())
                            <li class="page-item ms-auto">
                                <a class="page-link b-radius-none"
                                    href="{{ $properties->nextPageUrl() }}">Next</a>
                            </li>
                            @else
                            <li class="page-item disabled ms-auto">
                                <span class="page-link b-radius-none">Next</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=================================
                    Listing – grid view -->

@endsection

<script>
    // Sidebar collapse toggles (works with Bootstrap 4 and 5, plus fallback)
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".collapse-toggle").forEach(function(btn) {
            btn.addEventListener("click", function(e) {
                var targetId = this.getAttribute("href") || this.getAttribute("data-target") || this.getAttribute("data-bs-target");
                if (!targetId || targetId === "#") return;
                if (targetId.indexOf("#") === 0) targetId = targetId.slice(1);
                var target = document.getElementById(targetId);
                if (!target) return;
                e.preventDefault();
                if (typeof jQuery !== "undefined" && jQuery(target).collapse) {
                    jQuery(target).collapse("toggle");
                } else {
                    target.classList.toggle("show");
                }
                var expanded = target.classList.contains("show");
                this.setAttribute("aria-expanded", expanded);
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".property-item").forEach(function(item) {
            item.addEventListener("click", function(e) {
                // Prevent redirect if clicking on any button, link, or icon inside
                if (e.target.closest("a, button, .btn, form")) return;

                const href = this.getAttribute("data-href");
                if (href) {
                    window.location.href = href;
                }
            });
        });
    });
</script>