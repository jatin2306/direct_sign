@extends('admin.layouts.app')

@section('title', 'Edit Property')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div id="edit-page-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Edit Property</h4>
                    <a href="{{ route('admin.property-list') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to list
                    </a>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('admin.properties.update', $property->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Property Name *</label>
                                <input type="text" class="form-control" name="propertyName" value="{{ old('propertyName', $property->propertyName) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label>Property Type *</label>
                                <select class="form-control" name="propertyType" required>
                                    <option value="1" {{ $property->propertyType == '1' ? 'selected' : '' }}>Sell</option>
                                    <option value="2" {{ $property->propertyType == '2' ? 'selected' : '' }}>Rent</option>
                                    <option value="3" {{ $property->propertyType == '3' ? 'selected' : '' }}>Off Plan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Category *</label>
                                <select class="form-control" name="property_category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $property->property_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="user_id" value="{{ $property->user_id }}">

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Child Type *</label>
                                <select class="form-control" name="child_type_id" required>
                                    @foreach ($childTypes as $childType)
                                        <option value="{{ $childType->id }}" {{ $property->child_type_id == $childType->id ? 'selected' : '' }}>{{ $childType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label>Price *</label>
                                <input type="number" class="form-control" name="price" value="{{ old('price', $property->price) }}" required>
                            </div>   

                            <!-- <div class="col-md-4">
                                <label>Any Upgrades</label>
                                <textarea name="any_upgrades" class="form-control">{{ old('any_upgrades', $property->any_upgrades) }}</textarea>
                            </div> -->

                        </div>


                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Bedrooms</label>
                                <input type="number" class="form-control" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}">
                            </div>
                            <div class="col-md-3">
                                <label>Bathrooms</label>
                                <input type="number" class="form-control" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}">
                            </div>
                            <div class="col-md-3">
                                <label>Built Area (sqft)</label>
                                <input type="number" class="form-control" name="builtArea" value="{{ old('builtArea', $property->builtArea) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Plot Area (sqft)</label>
                                <input type="number" class="form-control" name="plotArea" value="{{ old('plotArea', $property->plotArea) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Furnished</label>
                                <select name="furnished" class="form-control">
                                    <option value="yes" {{ $property->furnished == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ $property->furnished == 'no' ? 'selected' : '' }}>No</option>
                                    <option value="semi" {{ $property->furnished == 'semi' ? 'selected' : '' }}>Semi</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $property->status == '1' ? 'selected' : '' }}>Vacant</option>
                                    <option value="2" {{ $property->status == '2' ? 'selected' : '' }}>Vacant on Transfer</option>
                                    <option value="3" {{ $property->status == '3' ? 'selected' : '' }}>Rented</option>
                                    <option value="4" {{ $property->status == '4' ? 'selected' : '' }}>Off Plan/Under Construction</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Parking</label>
                                <select name="parking" class="form-control">
                                    <option value="">Select</option>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}" {{ $property->parking == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-4" style="padding: 20px; border-radius: 8px;">
    <h5 class="mb-3">Description</h5>
    <!-- <textarea
        name="description"
        class="form-control"
        rows="5"
        placeholder="Enter property description..."
        required>{{ old('description', $property->description) }}</textarea> -->
        <textarea name="any_upgrades" class="form-control" rows="20" style="min-height: 220px;">{{ old('any_upgrades', $property->any_upgrades) }}</textarea>
</div>

                        <div class="mb-3">
                        <h5 class="mb-3">Amenities</h5>
                            <div class="row">
                                @foreach ($amenities as $amenity)
                                    <div class="col-md-3">
                                        <label>
                                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                                {{ in_array($amenity->id, $property->amenities ?? []) ? 'checked' : '' }}>
                                            {{ $amenity->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        


                        <div class="card mb-4">
    <div class="card-header"><h5 class="mb-0">Regulatory Information</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Reference</label>
                <input type="text" name="reference" class="form-control"
                       value="{{ old('reference', $property->reference ?? '') }}">
            </div>
           
            <div class="col-md-4 mb-3">
                <label>Broker License</label>
                <input type="text" name="broker_license" class="form-control"
                       value="{{ old('broker_license', $property->broker_license ?? '') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Regulatory Image (DLD Permit Image)</label>
                <input type="file" name="regulatory_image" class="form-control">
                @if($property->regulatory_image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $property->regulatory_image) }}"
                            alt="Regulatory Document"
                            style="max-width: 120px; border-radius: 6px;">
                    </div>
                @endif
            </div>

        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Zone Name</label>
                <input type="text" name="zone_name" class="form-control"
                       value="{{ old('zone_name', $property->zone_name ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>DLD Permit Number</label>
                <input type="text" name="dld_permit_number" class="form-control"
                       value="{{ old('dld_permit_number', $property->dld_permit_number ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Agent License</label>
                <input type="text" name="agent_license" class="form-control"
                       value="{{ old('agent_license', $property->agent_license ?? '') }}">
            </div>
        </div>
        
    </div>
</div>


                        <!-- Google Maps + Image Preview Section -->
                        <div class="card mb-4" style="margin-top:20px;">
                            <div class="card-header">
                                <h5 class="mb-0">Location & Images</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Google Maps Location Autocomplete -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="locationInput" class="form-label">Address</label>
                                            <input id="locationInput" type="text" name="address" class="form-control" value="{{ old('address', $property->address) }}" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input type="text" id="latitude" name="latitude" class="form-control" value="{{ old('latitude', $property->latitude) }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="longitude" class="form-label">Longitude</label>
                                                <input type="text" id="longitude" name="longitude" class="form-control" value="{{ old('longitude', $property->longitude) }}">
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">City</label>
                                                <input type="text" name="city" class="form-control" value="{{ old('city', $property->city) }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Sub Area</label>
                                                <input type="text" name="sub_area" class="form-control" value="{{ old('sub_area', $property->sub_area) }}">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div id="map" style="height: 400px; width: 100%;"></div>
                                        </div>
                                    </div>
                                    <style>
                                        .preview-wrapper {
                                            position: relative;
                                            margin-right: 10px;
                                            margin-bottom: 10px;
                                        }
                                        .preview-wrapper img {
                                            width: 100px;
                                            height: 80px;
                                            object-fit: cover;
                                            border-radius: 8px;
                                        }
                                        .remove-preview {
                                            position: absolute;
                                            top: -8px;
                                            right: -8px;
                                            background: red;
                                            color: white;
                                            border: none;
                                            border-radius: 50%;
                                            width: 22px;
                                            height: 22px;
                                            font-size: 14px;
                                            line-height: 1;
                                            cursor: pointer;
                                        }
                                        .file-name {
                                            font-size: 12px;
                                            text-align: center;
                                            margin-top: 2px;
                                            max-width: 100px;
                                            overflow: hidden;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;
                                        }
                                    </style>

                                    <!-- Image Preview Section -->
                                    <div class="col-md-6">
                                        <label class="form-label">Upload Property Images</label>
                                        <input type="file" name="pictures[]" id="imageUpload" class="form-control" multiple>
                                        <div id="imagePreview" class="d-flex flex-wrap mt-3 gap-3"></div>

                                        <hr>
                                        <label class="form-label">Existing Property Images</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach ($property->pictures as $picture)
                                                <div class="position-relative me-2 mb-2" style="display: inline-block; width: 120px;">
                                                    <img src="{{ asset('storage/' . $picture->path) }}"
                                                        alt="Property Image"
                                                        style="width: 120px; height: 100px; object-fit: cover; border-radius: 8px;">

                                                    <button type="button"
                                                            class="delete-image-btn"
                                                            data-id="{{ $picture->id }}"
                                                            style="position: absolute; top: 5px; right: 5px; border: none; background: rgba(255, 0, 0, 0.7); color: white; border-radius: 50%; width: 24px; height: 24px; font-size: 14px;">
                                                        ×
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    

                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Property</button>
                            <a href="{{ route('admin.property-list') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

                    <form id="deleteImageForm" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@if($property->userListing)
<hr>

<div class="card mt-4 border-warning">
    <div class="card-header bg-warning text-dark">
        <strong>User Submitted Information (Read Only)</strong>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-4">
                <p><strong>Listing Type:</strong> {{ ucfirst($property->userListing->listing_type) }}</p>
                <p><strong>Property Status:</strong> {{ ucfirst(str_replace('_',' ', $property->userListing->property_status)) }}</p>
                <p><strong>Price:</strong> AED {{ number_format($property->userListing->price) }}</p>

                @if($property->userListing->rent_frequency)
                    <p><strong>Rent Frequency:</strong> {{ ucfirst($property->userListing->rent_frequency) }}</p>
                @endif
            </div>

            <div class="col-md-4">
                <p><strong>Emirates ID / Passport:</strong></p>
                <a href="{{ asset('storage/'.$property->userListing->emirates_id) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary">
                    View Document
                </a>

                @if($property->userListing->title_deed)
                    <p class="mt-2"><strong>Title Deed:</strong></p>
                    <a href="{{ asset('storage/'.$property->userListing->title_deed) }}"
                       target="_blank"
                       class="btn btn-sm btn-outline-primary">
                        View Document
                    </a>
                @endif

                @if($property->userListing->oqood)
                    <p class="mt-2"><strong>Oqood:</strong></p>
                    <a href="{{ asset('storage/'.$property->userListing->oqood) }}"
                       target="_blank"
                       class="btn btn-sm btn-outline-primary">
                        View Document
                    </a>
                @endif
            </div>

            <div class="col-md-4">
                <p><strong>User Uploaded Images:</strong></p>

                <div class="d-flex flex-wrap gap-2">
                    @foreach($property->userListing->images ?? [] as $img)
                        <a href="{{ asset('storage/'.$img) }}" target="_blank">
                            <img src="{{ asset('storage/'.$img) }}"
                                 width="80"
                                 class="rounded border">
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endif



@endsection

<!-- Google Maps Autocomplete Script -->
<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: { lat: parseFloat("{{ $property->latitude }}") || 25.2048, lng: parseFloat("{{ $property->longitude }}") || 55.2708 },
        });

        const input = document.getElementById("locationInput");
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo("bounds", map);

        const marker = new google.maps.Marker({
            map,
            draggable: true,
            position: { lat: parseFloat("{{ $property->latitude }}") || 25.2048, lng: parseFloat("{{ $property->longitude }}") || 55.2708 },
        });

        // Autocomplete listener
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) return;

            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);

            document.getElementById("latitude").value = place.geometry.location.lat();
            document.getElementById("longitude").value = place.geometry.location.lng();
        });

        // Marker drag listener
        marker.addListener("dragend", () => {
            const position = marker.getPosition();
            document.getElementById("latitude").value = position.lat();
            document.getElementById("longitude").value = position.lng();
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7PU198Ir_uLOzaOK6hete5Rm5gDmWawI&libraries=places&callback=initMap" async defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('edit-page-alert');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
</script>



