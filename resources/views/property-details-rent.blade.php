@extends('layouts.home')

@section('title', $property->propertyName . ' | Direct Deal UAE')
@section('meta_description', Str::limit(strip_tags($property->description ?? ''), 155))
@section('meta_keywords', $property->propertyName . ', ' . ($property->address ?? '') . ', rent Dubai, property Dubai, ' . ($property->city ?? ''))

@push('meta')
<meta property="og:title" content="{{ $property->propertyName }}" />
<meta property="og:description" content="{{ Str::limit($property->description, 150) }}" />
<meta property="og:image" content="{{ asset($property->pictures->isNotEmpty() ? 'storage/' . $property->pictures->first()->path : 'images/default-property.jpg') }}" />
<meta property="og:url" content="{{ route('property.show', $property->slug ?? $property->id) }}" />
<meta property="og:type" content="website" />
<meta property="og:locale" content="en_US" />
@endpush

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "RealEstateListing",
    "name": {!! json_encode($property->propertyName) !!},
    "description": {!! json_encode(Str::limit(strip_tags($property->description ?? ''), 200)) !!},
    "url": {!! json_encode(route('property.show', $property->slug ?? $property->id)) !!},
    "address": { "@type": "PostalAddress", "addressLocality": {!! json_encode($property->city ?? 'Dubai') !!}, "streetAddress": {!! json_encode($property->address ?? '') !!} },
    "offers": { "@type": "Offer", "price": "{{ $property->price }}", "priceCurrency": "AED" }
}
</script>
@endpush

@section('content')
    <!-- Dynamic Breadcrumb -->
<!-- Dynamic Breadcrumb -->
<div class="bg-light">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fas fa-home"></i> </a></li>
          @foreach (Request::segments() as $segment)
            <li class="breadcrumb-item">
              <i class="fas fa-chevron-right"></i>
              @if ($loop->last)
                @if (is_numeric($segment))
                  <!-- Use property name if the segment is the ID -->
                  <span>{{ $property->propertyName }}</span>
                @else
                  <span>{{ ucfirst($segment) }}</span>
                @endif
              @else
                <a href="{{ url(implode('/', array_slice(Request::segments(), 0, $loop->index + 1))) }}">
                  {{ ucfirst($segment) }}
                </a>
              @endif
            </li>
          @endforeach
        </ol>
      </div>
    </div>
  </div>
</div>

    @if(session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!-- Success/Error Message Notification -->
    @if (session('success'))
        <div class="alert alert-success fixed-top" style="z-index: 9999; width: 100%;" id="successMessage">
            <div class="d-flex justify-content-between align-items-center">
                <span>{{ session('success') }}</span>
                <button type="button" class="close" aria-label="Close" id="closeSuccessMessage">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger fixed-top" style="z-index: 9999; width: 100%;" id="errorMessage">
            <div class="d-flex justify-content-between align-items-center">
                <span>{{ session('error') }}</span>
                <button type="button" class="close" aria-label="Close" id="closeErrorMessage">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="wrapper">
        <!--=================================
          Property Detail -->
        <section style="margin-top: 10px;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="property-detail-title">
                            <h1 class="h3 mb-0">{{ $property->propertyName }}</h1>
                            <span class="d-block mb-4"><i
                                    class="fas fa-map-marker-alt fa-xs pe-2"></i>{{ $property->address }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="price-meta">
                          @php
                          $propertyUrl = route('property.show', $property->slug ?? $property->id);
                          @endphp
                            <ul class="property-detail-meta list-unstyled mt-1 mb-5 mb-lg-3">
                                <li><a href="#"> <i
                                            class="fas fa-star text-warning pe-2"></i>{{ number_format($property->average_rating, 1) }}/5
                                    </a></li>
                                <li class="share-box">
                                    <a href="#"> <i class="fas fa-share-alt"></i> </a>
                                    <ul class="list-unstyled share-box-social">
                                        <li> <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($propertyUrl) }}" 
                                          target="_blank"><i class="fab fa-facebook-f"></i></a> </li>
                                        <li> <a href="https://twitter.com/intent/tweet?url={{ urlencode($propertyUrl) }}&text=Check out this amazing property!"
                                          target="_blank"><i class="fab fa-twitter"></i></a> </li>
                                        <li> <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($propertyUrl) }}" 
                                          target="_blank"><i class="fab fa-linkedin"></i></a> </li>
                                        <li> <a href="#" onclick="navigator.clipboard.writeText('{{ $propertyUrl }}'); alert('Link copied! Share it on Instagram.')"><i class="fab fa-instagram"></i></a> </li>
                                        <li> <a href="https://wa.me/?text=Check out this property: {{ urlencode($propertyUrl) }}" 
                                          target="_blank"><i class="fab fa-whatsapp"></i></a> </li>
                                    </ul>
                                </li>
                                <style>
                                  /* Hover effect */
                                  li a:hover {
                                      background-color: #f0f0f0;
                                      color: #26ae61; /* Or your preferred hover color */
                                  }
                              
                                  li a:hover i {
                                      color: #26ae61 !important;
                                  }
                              </style>
                                @php $isFavorited = auth()->check() && $property->isFavoritedBy(auth()->user()); @endphp
                                <li style="display: inline-block;">
                                  <a href="#" 
                                     onclick="event.preventDefault(); document.getElementById('favorite-form-{{ $property->id }}').submit();" 
                                     style="display: block; align-items: center; color: inherit; text-decoration: none;">
                                      <i class="fas fa-heart{{ $isFavorited ? ' text-success' : '' }}"></i>
                                  </a>
                                  <form id="favorite-form-{{ $property->id }}" action="{{ route('toggleFavorite', $property->id) }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>
                              </li>
                              
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                      <style>
                          /* Main gallery container */
                          .main-gallery {
                              display: flex;
                              gap: 10px;
                              max-width: 100%;
                          }
              
                          /* Featured Image Container */
                          .featured-image {
                              position: relative;
                              flex: 2;
                              overflow: hidden;
                          }
              
                          .featured-image img {
                              width: 100%;
                              max-height: 500px;
                              object-fit: cover;
                              display: block;
                              border-radius: 5px;
                          }
              
                          /* Image Count Overlay */
                          .image-count-bottom-right {
                              position: absolute;
                              bottom: 15px;
                              right: 15px;
                              background-color: rgba(0, 0, 0, 0.7);
                              color: #fff;
                              padding: 5px 10px;
                              border-radius: 5px;
                              font-size: 14px;
                              font-weight: bold;
                              z-index: 10;
                              pointer-events: none;
                          }
              
                          /* Side images */
                          .side-images {
                              display: flex;
                              flex-direction: column;
                              gap: 10px;
                              flex: 1;
                              height: 100%;
                          }
              
                          .side-images img {
                              width: 100%;
                              height: 100%;
                              max-height: 245px;
                              object-fit: cover;
                              border-radius: 5px;
                          }
              
                          /* Hidden images */
                          .hidden-images {
                              display: none;
                          }
              
                          /* Ensure proper spacing with bottom content */
                          .property-detail-gallery {
                              margin-bottom: 10px;
                          }
              
                      </style>
                      <div class="property-detail-gallery overflow-hidden">
                          <!-- Tabs -->
                          <ul class="nav nav-tabs nav-tabs-02 mb-4" id="pills-tab" role="tablist">
                              <li class="nav-item">
                                  <a class="nav-link shadow active" id="photo-tab" data-bs-toggle="pill" href="#photo" role="tab" aria-controls="photo" aria-selected="true">Photo</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link shadow" id="map-tab" data-bs-toggle="pill" href="#map" role="tab" aria-controls="map" aria-selected="false">Map</a>
                              </li>
                          </ul>
              
                          <!-- Tab Content -->
                          <div class="tab-content" id="pills-tabContent">
                              <!-- Photo Tab -->
                              <div class="tab-pane fade show active" id="photo" role="tabpanel" aria-labelledby="photo-tab">
                                  <div class="main-gallery">
                                      @if ($property->pictures->isNotEmpty())
                                          <div class="featured-image">
                                              <a href="{{ asset('storage/' . $property->pictures->first()->path) }}" data-lg-size="1024-768">
                                                  <img class="img-fluid" src="{{ asset('storage/' . $property->pictures->first()->path) }}" alt="Property Picture" />
                                              </a>
                                              <div class="image-count-bottom-right">
                                                  {{ $property->pictures->count() }} Photos
                                              </div>
                                          </div>
                                          <div class="side-images">
                                              @foreach ($property->pictures->slice(1, 2) as $picture)
                                                  <a href="{{ asset('storage/' . $picture->path) }}" data-lg-size="1024-768">
                                                      <img class="img-fluid" src="{{ asset('storage/' . $picture->path) }}" alt="Property Picture" />
                                                  </a>
                                              @endforeach
                                          </div>
                                          <div class="hidden-images">
                                              @foreach ($property->pictures->slice(3) as $picture)
                                                  <a href="{{ asset('storage/' . $picture->path) }}" data-lg-size="1024-768">
                                                      <img class="img-fluid" src="{{ asset('storage/' . $picture->path) }}" alt="Property Picture" />
                                                  </a>
                                              @endforeach
                                          </div>
                                      @else
                                      <img src="{{ asset('images/default-property.jpg') }}" alt="Default Property Image" class="img-fluid">

                                      @endif
                                  </div>
                              </div>
                              <!-- Map Tab -->
                              <div class="tab-pane fade" id="map" role="tabpanel" aria-labelledby="map-tab">
                                <iframe 
                                    width="600" 
                                    height="450" 
                                    style="border:0;" 
                                    loading="lazy" 
                                    allowfullscreen 
                                    referrerpolicy="no-referrer-when-downgrade" 
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD7PU198Ir_uLOzaOK6hete5Rm5gDmWawI&q={{ $property->latitude ?? 0 }},{{ $property->longitude ?? 0 }}&zoom=15">
                                </iframe>
                            </div>
                            
                          </div>
                      </div>
                  </div>
              </div>
                      
                      
                <div class="row">
                  <!-- Left Column: Property Info -->
                  <div class="property-info col-lg-8 mb-4" style="padding: 0px;">
                      <div class="container-fluid">
                        <!-- Developer Card -->
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px; padding: 20px;">
                          <div class="d-flex align-items-center justify-content-between">
                              <!-- Price Section -->
                              <div>
                                  <h3 class="text-dark fw-bold"><span>AED {{ number_format($property->price, 0) }}</span>
                                  </h3>
                                  
                              </div>

                              <!-- Details Section -->
                              <div class="d-flex align-items-center">
                                  <div class="text-center me-3">
                                    <i class="fas fa-bed"></i>
                                      <p class="m-0">{{ $property->bedrooms == 0 ? 'Studio' : $property->bedrooms . ($property->bedrooms > 5 ? '+' : '') . ' Bedrooms' }}</p>
                                  </div>
                                  <div class="text-center me-3">
                                    <i class="fas fa-bath"></i>
                                      <p class="m-0">{{ $property->bathrooms }}{{ $property->bathrooms > 5 ? '+' : '' }} Bathrooms</p>
                                  </div>
                                  <div class="text-center">
                                    <i class="fas fa-square"></i>
                                      <p class="m-0">{{ $property->builtArea }} sqft</p>
                                  </div>
                              </div>
                          </div>
                        </div>

              
                          <!-- Property Details Section -->
                          <div class="card border-0 shadow-sm mb-4" style="padding: 20px; border-radius: 8px;">
                              <h5 class="mb-3">Property Details</h5>
                              <div class="row">
                                  <!-- Left Column -->
                                  <div class="col-sm-6">
                                      <ul class="list-unstyled">
                                          <li><b>Property Name:</b> {{ $property->propertyName }}</li>
                                          <li><b>Price:</b> <span>AED {{ number_format($property->price, 0) }} per/month</span></li>
                                          <li><b>Property Size:</b> {{ $property->plotArea }} Sq Ft</li>
                                          <li><b>Bedrooms:</b> {{ $property->bedrooms == 0 ? 'Studio' : $property->bedrooms . ($property->bedrooms > 5 ? '+' : '') }}</li>
                                          <li><b>Bathrooms:</b> {{ $property->bathrooms }}{{ $property->bathrooms > 5 ? '+' : '' }}</li>
                                      </ul>
                                  </div>
                                  <!-- Right Column -->
                                  <div class="col-sm-6">
                                      <ul class="list-unstyled">
                                          <li><b>Parking:</b> {{ $property->parking }}</li>
                                          <li><b>Built Area:</b> {{ $property->builtArea }} SqFt</li>
                                          <li><b>Listed:</b> {{ $property->created_at->diffForHumans() }}</li>
                                          <li><b>Property Type:</b> {{ $property->category->name }}</li>
                                          <li><b>Property Status:</b> For {{ $propertyTypes[$property->propertyType] }}</li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
              
                          <!-- Description Section -->
<div class="card border-0 shadow-sm mb-4" style="padding: 20px; border-radius: 8px;">
    <h5 class="mb-3">Description</h5>
    {!! nl2br(e($property->any_upgrades)) !!}
</div>
              
                          <!-- Amenities Section -->
                          <div class="card border-0 shadow-sm mb-4" style="padding: 20px; border-radius: 8px;">
                              <h5 class="mb-3">Amenities</h5>
                              <div class="row">
                                  <div class="col-sm-6">
                                      <ul class="list-unstyled">
                                          @foreach ($amenities as $index => $amenity)
                                              @if ($index < ceil(count($amenities) / 2))
                                                  <li>{{ $amenity }}</li>
                                              @endif
                                          @endforeach
                                      </ul>
                                  </div>
                                  <div class="col-sm-6">
                                      <ul class="list-unstyled">
                                          @foreach ($amenities as $index => $amenity)
                                              @if ($index >= ceil(count($amenities) / 2))
                                                  <li>{{ $amenity }}</li>
                                              @endif
                                          @endforeach
                                      </ul>
                                  </div>
                              </div>
                          </div>
              
                          <!-- Location Section -->
                          <div class="card border-0 shadow-sm mb-4" style="padding: 20px; border-radius: 8px;">
                              <h5 class="mb-3">Location</h5>
                              <ul class="list-unstyled">
                                  <li><b>Address:</b> {{ $property->address }}</li>
                              </ul>
                          </div>
              
                          <!-- Regulatory Information Section -->
                          <div class="card border-0 shadow-sm" style="padding: 20px; border-radius: 8px;">
                            <h5 class="mb-3">Regulatory Information</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled">
                                        <li><b>Reference:</b> {{ $property->reference ?? '-' }}</li>
                                    
                                        <li><b>Broker License:</b> {{ $property->broker_license ?? '-' }}</li>
                                        <li><b>Zone Name:</b> {{ $property->zone_name ?? '-' }}</li>
                                        <li><b>DLD Permit Number:</b> {{ $property->dld_permit_number ?? '-' }}</li>
                                        <li><b>Agent License:</b> {{ $property->agent_license ?? '-' }}</li>
                                    </ul>
                                </div>
                            <div class="col-sm-6 text-center">
                            @if($property->regulatory_image)
                                <img src="{{ asset('storage/' . $property->regulatory_image) }}" class="img-fluid" style="max-width: 30%;" alt="Regulatory Document">
                                <p>DLD Permit Number</p>
                            @else
                                <p>Image Not Available</p>
                            @endif
                        </div>
                        

                            </div>
                        </div>
                      </div>
                  </div>
              
                  <!-- Right Column: Sidebar -->
                  <div class="col-lg-4">
                      <div class="sticky-top">
                          <div class="sidebar">
                              <!-- Agent Contact Section -->
                              <div class="card bg-dark text-white mb-4" style="padding: 20px; border-radius: 8px;">
                                  <div class="d-flex align-items-center mb-4">
                                      <img class="img-fluid rounded-circle avatar avatar-lg me-3" src="{{ asset('images/placeholder.jpg') }}" alt="">
                                      <div>
                                          <h6 class="text-white">Direct Deal</h6>
                                          <span>Company Agent</span>
                                      </div>
                                  </div>
                                  <div class="d-flex flex-column align-items-center text-center mb-4">
                                    <h6 class="text-primary border p-2 mb-2">
                                        <a href="tel:+971581144230" class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-phone-volume text-white pe-2"></i>+971581144230
                                        </a>
                                    </h6>
                                    <span class="text-muted">Reach Us Anytime!</span>
                                </div>
                                
                                <div class="d-flex justify-content-center gap-3">
                                    <a class="btn btn-danger" href="mailto:info@directdeal.ae" style="max-width: 200px;">
                                        <i class="fas fa-envelope"></i> Email
                                    </a>
                                    <a class="btn btn-primary" href="https://wa.me/971581144230" style="max-width: 200px;">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                                
                              </div>
                              <div class="d-flex mb-4 justify-content-center">
                                <form action="{{ route('subscribe.priceDrop', $property->id) }}" method="POST" class="d-inline">
                                  @csrf
                                  <button type="submit" class="btn btn-danger btn-sm px-4 py-2">
                                      <i class="fas fa-envelope"></i> Notify Me When This Property Price Drops
                                  </button>
                              </form>
                              </div>
                              <!-- Recently Listed Properties 
                              <div class="widget mb-4">
                                  <h6>Recently Listed Properties</h6>
                                  @foreach ($similarProperties as $similar)
                                      <div class="recent-list-item mb-3">
                                          <img src="{{ $similar->pictures->isNotEmpty() ? asset('storage/' . $similar->pictures->first()->path) : asset('images/placeholder.jpg') }}" alt="{{ $similar->name }}" class="img-fluid">
                                          <div class="mt-2">
                                              <a class="address mb-2" href="{{ route('property.show', $similar->slug ?? $similar->id) }}">{{ $similar->propertyName }}</a>
                                              <span class="text-primary">${{ $similar->price }}</span>
                                          </div>
                                      </div>
                                  @endforeach
                              </div> -->
              
                              <!-- Review Section -->
                              <div class="widget">
                                  <h6>Leave a Review for {{ $property->propertyName }}</h6>
                                  <div class="d-flex">
                                      <img class="img-fluid rounded-circle avatar avatar-xl me-3" src="{{ asset('images/avatar/02.jpg') }}" alt="User Avatar">
                                      <div class="flex-grow-1">
                                          @if ($errors->any())
                                              <div class="alert alert-danger">
                                                  <ul>
                                                      @foreach ($errors->all() as $error)
                                                          <li>{{ $error }}</li>
                                                      @endforeach
                                                  </ul>
                                              </div>
                                          @endif
              
                                          @if ($review)
                                              <div class="alert alert-info">
                                                  <strong>Your Review:</strong>
                                                  <ul class="list-unstyled list-inline">
                                                      @for ($i = 1; $i <= 5; $i++)
                                                          <li class="list-inline-item m-0 @if ($i <= $review->rating) text-warning @else text-muted @endif">
                                                              <i class="fas fa-star"></i>
                                                          </li>
                                                      @endfor
                                                  </ul>
                                                  <p>{{ $review->review }}</p>
                                              </div>
                                          @else
                                              <form action="{{ route('reviews.store') }}" method="POST">
                                                  @csrf
                                                  <input type="hidden" name="property_id" value="{{ $property->id }}">
                                                  <div class="form-group mb-3">
                                                      <span class="mb-2 d-block">Rating:</span>
                                                      <ul class="list-unstyled list-inline" id="ratingStars">
                                                          <li class="list-inline-item" data-value="1"><i class="far fa-star"></i></li>
                                                          <li class="list-inline-item" data-value="2"><i class="far fa-star"></i></li>
                                                          <li class="list-inline-item" data-value="3"><i class="far fa-star"></i></li>
                                                          <li class="list-inline-item" data-value="4"><i class="far fa-star"></i></li>
                                                          <li class="list-inline-item" data-value="5"><i class="far fa-star"></i></li>
                                                      </ul>
                                                      <input type="hidden" id="ratingValue" name="rating" value="0">
                                                  </div>
                                                  <div class="mb-3">
                                                      <span class="mb-2 d-block">Review:</span>
                                                      <textarea name="review" id="review" class="form-control" rows="3"></textarea>
                                                  </div>
                                                  @if (auth()->check())
                                                      <button type="submit" class="btn btn-primary">Submit Review</button>
                                                  @else
                                                      <p class="text-warning">You need to <a href="{{ route('login') }}" class="text-primary">Login</a> to leave a review.</p>
                                                  @endif
                                              </form>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              

    </div>
    </section>
 
    </div>

@endsection
