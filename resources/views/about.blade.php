@extends('layouts.home')

@section('title', 'About Direct Deal UAE | RERA Licensed Real Estate Brokerage Dubai')
@section('meta_description', 'Learn about Direct Deal UAE – a RERA-licensed real estate brokerage offering verified listings, transparent pricing and the lowest brokerage fees in Dubai.')

@section('content')

<!--=================================
breadcrumb -->
<div class="bg-light">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}"> <i class="fas fa-home"></i> </a>
          </li>
          <li class="breadcrumb-item">
            <i class="fas fa-chevron-right"></i> <span>About Us</span>
          </li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--=================================
breadcrumb -->

<!--=================================
About Direct Deal UAE -->
<section class="space-ptb bg-holder">
  <div class="container">

    <!-- HERO -->
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10">
        <div class="text-center">
          <h1 class="text-primary mb-4">
            About Direct Deal UAE
          </h1>

          <p class="lead fw-normal mb-3">
            <strong>Direct Deal UAE</strong> is a RERA-licensed, technology-driven real estate brokerage
            built to offer the <strong>lowest brokerage fees in Dubai</strong> through verified,
            transparent, and regulated property transactions.
          </p>

          <p class="px-sm-5">
            We help property owners, buyers, landlords, and tenants transact directly
            with confidence — supported by professional brokerage services,
            strict verification, and full regulatory compliance.
          </p>
        </div>
      </div>
    </div>

    <!-- VERIFIED PLATFORM -->
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <p>
          Unlike traditional real estate portals, every listing on
          <strong>DirectDealUAE.com</strong> is <strong>100% verified</strong> before going live.
          Ownership documents, identities, property details, and photos are reviewed to ensure
          only genuine properties and qualified users are allowed on the platform.
        </p>
      </div>
    </div>

    <!-- MISSION -->
    <div class="row justify-content-center mt-5">
      <div class="col-lg-8">
        <div class="p-4 bg-light rounded shadow-sm text-center">
          <h3 class="text-primary mb-3">Our Mission</h3>
          <p class="mb-0 fw-normal">
            To make buying, selling, and renting property in Dubai more transparent,
            affordable, and regulated by offering ultra-low brokerage fees,
            verified listings, and professional RERA-compliant brokerage support.
          </p>
        </div>
      </div>
    </div>

    <!-- DIFFERENT -->
    <div class="row mt-5">
      <div class="col-12 text-center mb-4">
        <h2>What Makes Direct Deal UAE Different</h2>
      </div>

      <div class="col-lg-4 col-sm-6 mb-4">
        <div class="feature-info h-100">
          <div class="feature-info-icon">
            <i class="flaticon-like"></i>
          </div>
          <div class="feature-info-content">
            <h6 class="feature-info-title">0% Commission for Sellers & Landlords</h6>
            <p>Property owners list and transact without paying brokerage fees.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 mb-4">
        <div class="feature-info h-100">
          <div class="feature-info-icon">
            <i class="flaticon-agent"></i>
          </div>
          <div class="feature-info-content">
            <h6 class="feature-info-title">Lowest Brokerage Fees in Dubai</h6>
            <p>
              Buyers pay only <strong>0.2% brokerage</strong>,
              tenants pay only <strong>0.5% brokerage</strong> —
              compared to the market standard of 2%–5%.
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 mb-4">
        <div class="feature-info h-100">
          <div class="feature-info-icon">
            <i class="flaticon-like-1"></i>
          </div>
          <div class="feature-info-content">
            <h6 class="feature-info-title">100% Verified Listings & Users</h6>
            <p>No fake ads, duplicate listings, or unqualified leads.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 mb-4">
        <div class="feature-info h-100">
          <div class="feature-info-icon">
            <i class="flaticon-house-1"></i>
          </div>
          <div class="feature-info-content">
            <h6 class="feature-info-title">Direct Transactions with Licensed Brokerage Support</h6>
            <p>We facilitate negotiations, contracts, and transactions as a RERA-licensed broker.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 mb-4">
        <div class="feature-info h-100">
          <div class="feature-info-icon">
            <i class="flaticon-house-key-1"></i>
          </div>
          <div class="feature-info-content">
            <h6 class="feature-info-title">End-to-End Transaction Support</h6>
            <p>From verification and contracts to Ejari and transfer coordination.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 mb-4">
        <div class="feature-info h-100">
            <div class="feature-info-icon">
                <i class="flaticon-like"></i>
            </div>
            <div class="feature-info-content">
                <h6 class="feature-info-title">
                    100% Verified Properties in Dubai
                </h6>
                <p class="mb-0">
                    Every property is manually reviewed for ownership,
                    accuracy, and authenticity before being listed.
                </p>
            </div>
        </div>
      </div>

    </div>

    <!-- TRUST -->
    <div class="row justify-content-center mt-5">
      <div class="col-lg-10 text-center">
        <h3 class="text-primary mb-3">Built for Trust & Compliance</h3>
        <p>
          Dubai’s real estate market faces challenges with fake listings and inflated commissions.
          Direct Deal UAE addresses this by operating as a regulated brokerage
          with verified users, transparent fees, and documented transaction flows.
        </p>
      </div>
    </div>

    <!-- WHO WE SERVE -->
    <div class="row justify-content-center mt-4">
      <div class="col-lg-8">
        <ul class="list-unstyled text-center">
          <li>✔ Property owners selling or renting</li>
          <li>✔ Buyers seeking verified properties</li>
          <li>✔ Tenants looking for low brokerage fees</li>
          <li>✔ Investors seeking regulated opportunities</li>
          <li>✔ Developers marketing off-plan projects</li>
        </ul>
      </div>
    </div>

    <!-- BRAND CLOSE -->
    <div class="row justify-content-center mt-5">
      <div class="col-lg-10 text-center">
        <p class="fw-semibold">
          Direct Deal UAE operates as a <strong>RERA-licensed real estate brokerage</strong>
          supported by technology — built to make Dubai real estate transparent,
          affordable, and compliant.
        </p>
        <h5 class="text-primary mt-2">
          Be Direct. Be Intelligent. Just Direct Deals.
        </h5>
        <p class="small mt-2 fw-bold">
          Direct Deal | RERA-Licensed Brokerage | ORN 43954
        </p>
      </div>
    </div>

  </div>
</section>
<!--=================================
About Direct Deal UAE -->

@endsection
