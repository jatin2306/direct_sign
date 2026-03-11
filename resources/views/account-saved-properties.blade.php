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
                                    <a class="nav-link" href="{{ route('properties.my') }}"><i class="far fa-bell"></i>My
                                        properties</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('properties.saved') }}"><i class="fas fa-home"></i> Saved
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
                  <h2>Saved Properties</h2>
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
                                                <i class="fas fa-bed"></i>Bed<span>{{ $property->bedrooms }}{{ $property->bedrooms > 5 ? '+' : '' }}</span>
                                              </li>
                                              <li class="flex-fill property-bath">
                                                      <i class="fas fa-bath"></i>Bath<span>{{ $property->bathrooms }}{{ $property->bathrooms > 5 ? '+' : '' }}</span>      
                                              </li>
                                              <li class="flex-fill property-m-sqft"><i
                                                      class="far fa-square"></i>sqft<span>{{ $property->builtArea }}</span>
                                              </li>
                                          </ul>
                                          <p class="mb-0 mt-3">For those of you who are serious about having more, doing
                                              more, giving more and being with some understanding.</p>
                                      </div>
                                      <div class="property-btn d-flex justify-content-end"
                                            style="margin: 0px 2px 0px 10px; max-height: 40px;">
                                            <a class="btn btn-primary" href="tel:+919990968968"
                                                style="max-width: 200px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-phone fa-flip-horizontal"
                                                    style="margin-right: 8px;"></i>Call
                                            </a>
                                            <a class="btn btn-primary" href="mailto:info@directdeal.ae"
                                                style="max-width: 200px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-envelope" style="margin-right: 8px;"></i>Email
                                            </a>
                                            <a class="btn btn-primary" href="https://wa.me/919990968968" target="_blank"
                                                style="max-width: 200px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fab fa-whatsapp" aria-hidden="true"
                                                    style="margin-right: 8px;"></i>Whatsapp
                                            </a>
                                            <a class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Favourite" href="#"
                                                onclick="event.preventDefault(); document.getElementById('favorite-form-{{ $property->id }}').submit();"
                                                style="display: flex; align-items: center; text-decoration: none;">
                                                <i class="{{ auth()->check() && $property->isFavoritedBy(auth()->user()) ? 'fas fa-heart' : 'far fa-heart' }}"
                                                    style="color: {{ auth()->check() && $property->isFavoritedBy(auth()->user()) ? '#26ae61' : 'inherit' }}; margin-right: -10px;">
                                                </i>
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
                        <p>Looks like you haven’t saved any properties yet.</p>
                        <a href="{{ route('property.index') }}" class="btn btn-primary mt-2">
                            <i class="fa fa-home"></i> Browse Properties
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
@endsection
