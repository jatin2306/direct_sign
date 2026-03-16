@extends('layouts.home')

@section('content')
    <!--=================================
    breadcrumb -->
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
                                    <span>{{ ucfirst($segment) }}</span>
                                @else
                                    <a
                                        href="{{ url(implode('/', array_slice(Request::segments(), 0, $loop->index + 1))) }}">
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
    <!--=================================
      breadcrumb -->

    <!--=================================
      My profile -->
    <section style="padding-top: 10px; padding-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="profile-sidebar">
                        <div class="d-sm-flex align-items-center position-relative">


                            <div class="ms-auto my-4 mt-sm-0">
                                <a class="btn btn-primary btn-md" href="{{ route('add.listing') }}"> <i
                                        class="fa fa-plus-circle"></i>Add Property </a>
                            </div>

                        </div>
                        <div class="profile-nav">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard') }}"><i class="far fa-user"></i> Edit
                                        Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('properties.my') }}"><i class="far fa-bell"></i>My
                                        properties</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('properties.saved') }}"><i class="fas fa-home"></i> Saved
                                        Properties</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="{{ route('user.transactions') }}"><i class="far fa-edit"></i>
                                    Transactions</a>
                              </li>
                                <li class="nav-item">
                                    <!-- Hidden Logout Form -->
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <!-- Logout Link -->
                                    <a class="nav-link" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class='fas fa-sign-out-alt'></i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                <div class="col-lg-9">
                  <h2>My properties</h2>

                  @if ($properties->count() > 0)

                  @foreach ($properties as $property)
                      <div class="property-item property-col-list mt-4">
                          <div class="row g-0">
                              <div class="col-lg-4 col-md-5">
                                  <div class="property-image bg-overlay-gradient-04">

                                      <img class="img-fluid"
                                          src="{{ $property->pictures->first() ? asset('storage/' . $property->pictures->first()->path) : asset('images/placeholder.jpg') }}"
                                          class="card-img-top" alt="Property Image">

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

                              <div class="col-lg-8 col-md-7" data-href="{{ route('property.show', $property->slug ?? $property->id) }}"
                                  style="cursor: pointer;">
                                  <div class="property-details">
                                      <div class="property-details-inner">
                                          <div class="property-details-inner-box">
                                              <div class="property-details-inner-box-left">
                                                  <h5 class="property-title"><a class="me-2" 
                                                          href="{{ route('property.show', $property->slug ?? $property->id) }}">{{ $property->propertyName }}
                                                      </a><span class="badge {{ $property->verified ? 'bg-success' : 'bg-warning text-dark' }}">
                                                        {{ $property->verified ? 'Verified' : 'Pending Verification' }}
                                                    </span></h5>
                                                  <span class="property-address"><i
                                                          class="fas fa-map-marker-alt fa-xs"></i>{{ $property->address }}</span>
                                                  <span class="property-agent-date"><i
                                                          class="far fa-clock fa-md"></i>{{ $property->created_at->diffForHumans() }}</span>
                                              </div>
                                              <div class="property-price">{{ number_format($property->price) }} AED
                                              </div>
                                          </div>
                                          <ul class="property-info list-unstyled d-flex">
                                              <li class="flex-fill property-bed">
                                                <i class="fas fa-bed"></i>Bed<span>{{ $property->bedrooms !== null && $property->bedrooms !== '' ? $property->bedrooms . ($property->bedrooms > 5 ? '+' : '') : '—' }}</span>
                                              </li>
                                              <li class="flex-fill property-bath">
                                                      <i class="fas fa-bath"></i>Bath<span>{{ $property->bathrooms !== null && $property->bathrooms !== '' ? $property->bathrooms . ($property->bathrooms > 5 ? '+' : '') : '—' }}</span>
                                              </li>
                                              <li class="flex-fill property-m-sqft"><i
                                                      class="far fa-square"></i>sqft<span>{{ $property->builtArea ?? '—' }}</span>
                                              </li>
                                          </ul>
                                          <p class="mb-0 mt-3">For those of you who are serious about having more, doing
                                              more, giving more and being with some understanding.</p>
                                      </div>
                                      <div class="property-btn property-btn-mobile d-flex justify-content-end flex-wrap gap-2">
                                            <a class="btn btn-primary btn-call" href="tel:+919990968968">
                                                <i class="fas fa-phone fa-flip-horizontal me-1"></i>Call
                                            </a>
                                            <a class="btn btn-primary btn-email" href="mailto:info@directdeal.ae">
                                                <i class="fas fa-envelope me-1"></i>Email
                                            </a>
                                            <a class="btn btn-primary btn-whatsapp" href="https://wa.me/919990968968" target="_blank">
                                                <i class="fab fa-whatsapp me-1" aria-hidden="true"></i>Whatsapp
                                            </a>
                                            <a class="btn btn-primary btn-fav {{ auth()->check() && $property->isFavoritedBy(auth()->user()) ? 'is-favorited' : '' }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Favourite" href="#"
                                                onclick="event.preventDefault(); document.getElementById('favorite-form-{{ $property->id }}').submit();">
                                                <i class="{{ auth()->check() && $property->isFavoritedBy(auth()->user()) ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                                            </a>
                                            <form id="favorite-form-{{ $property->id }}"
                                                action="{{ route('toggleFavorite', $property->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  @endforeach

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

                  @else
                        <!-- Empty State Message -->
                        <div class="text-center mt-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No Listings" style="width: 120px; opacity: 0.8;">
                        <h4 class="mt-3 text-muted">No listings found</h4>
                        <p>Looks like you haven’t added any properties yet.</p>
                        <a href="{{ route('add.listing') }}" class="btn btn-primary mt-2">
                            <i class="fa fa-plus-circle"></i> Add Property
                        </a>
                        </div>
                    @endif
                    
              </div>
            </div>

            </div>
        </div>
    </section>
    <!--=================================
      My profile -->

    <style>
    /* My Properties – mobile layout and touch-friendly CTAs */
    @media (max-width: 767px) {
        .property-item.property-col-list .row { margin-left: 0; margin-right: 0; }
        .property-item.property-col-list .col-lg-4,
        .property-item.property-col-list .col-md-5 { max-width: 100%; flex: 0 0 100%; }
        .property-item .property-details { min-width: 0; overflow: hidden; border-left: none; }
        .property-details-inner-box { flex-wrap: wrap; width: 100%; }
        .property-details-inner-box-left { max-width: 100%; min-width: 0; }
        .property-details-inner .property-title { font-size: 1rem; line-height: 1.35; }
        .property-details-inner .property-title a { display: inline; word-break: break-word; }
        .property-details-inner .property-title .badge { font-size: 0.7rem; margin-top: 2px; }
        .property-details-inner-box .property-price {
            width: 100%; flex-basis: 100%; text-align: left !important; margin-top: 6px;
            font-size: 1.15rem; min-width: 0 !important;
        }
        .property-details .property-info { flex-wrap: nowrap; min-width: 0; padding-left: 0; }
        .property-details .property-info li { flex: 1 1 0; font-size: 12px; padding: 8px 4px 0 !important; min-width: 0; }
        .property-details .property-info li i { margin-right: 4px; }
        .property-details .property-details-inner { padding: 12px 14px; }
        .property-details .property-details-inner p { font-size: 0.9rem; margin-bottom: 10px; }
        /* CTA row: wrap, smaller buttons, touch-friendly */
        .property-btn-mobile {
            margin: 8px 0 0 !important; max-height: none !important;
            justify-content: flex-start !important; padding: 0 14px 12px;
            gap: 8px;
        }
        .property-btn-mobile .btn { flex: 1 1 auto; min-width: 0; max-width: none; padding: 10px 12px; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; }
        .property-btn-mobile .btn-fav { flex: 0 0 auto; min-width: 44px; }
        .property-btn-mobile .btn-fav.is-favorited i { color: #fff; }
        .property-item.property-col-list .property-image img { width: 100%; height: 200px; object-fit: cover; }
        .pagination { flex-wrap: wrap; justify-content: center; gap: 4px; }
        .pagination .page-link { padding: 8px 12px; min-width: 44px; text-align: center; }
    }
    </style>
@endsection
