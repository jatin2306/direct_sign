@extends('layouts.home')

@section('title', 'Verified Properties in Dubai | Buy, Sell & Rent | Direct Deal UAE')
@section('meta_description', 'Buy, sell or rent verified Dubai properties with the lowest brokerage fees. 0% commission for owners and 0.2% for buyers on Direct Deal UAE.')
@section('meta_keywords', 'buy property Dubai, rent Dubai, sell property Dubai, verified listings UAE, RERA Dubai, lowest brokerage, apartments for sale Dubai, villas for rent')

@section('content')
<style>
.banner {
    padding: 150px 0;
    position: relative;
}
.property-search-field {
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
    padding: 20px;
    margin-top: 20px;
}

.property-search-field .form-group {
    margin-bottom: 0px;
}
.property-search-field .form-group:first-child {
   border-bottom-left-radius:12px;
}

.property-search-field .form-label {
    font-weight: 600;
    color: #26ae61; /* Your theme color */
}

.property-search-field .form-control {
    border-radius: 8px;
    border: 1px solid #e2e2e2;
    transition: 0.3s ease;
}

.property-search-field .btn-primary {
    background-color: #26ae61;
    border-color: #26ae61;
    border-radius: 8px;
    padding: 8px 20px;
    transition: 0.3s ease;
}

.property-search-field .btn-primary:hover {
    background-color: #02853a;
    border-color: #02853a;
}

.property-search-field .fa-search {
    font-size: 16px;
    margin-right: 5px;
}

.more-search {
    color: #26ae61;
    font-weight: 500;
    transition: color 0.3s;
}

.more-search:hover {
    color: #36194d;
    text-decoration: none;
}

.advanced-search .card {
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
}

.property-search-field .property-search-item {
    
    border-radius: 12px;
}

/* Enhanced Feature Section Styles */
.bg-light.p-4.py-5.text-center {
    background: #e9f7f0 !important;
    border-radius: 16px;
    box-shadow: 0 3px 3px #e9f7f0;
    transition: all 0.3s ease;
}

.bg-light.p-4.py-5.text-center:hover {
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.12);
    transform: translateY(-4px);
}

.bg-light.p-4.py-5.text-center i {
    font-size: 40px;
    color: #4a225b; /* Theme color */
    margin-bottom: 20px;
    transition: color 0.3s;
}

.bg-light.p-4.py-5.text-center h5 {
    font-weight: 600;
    color: #333;
}

.bg-light.p-4.py-5.text-center p {
    font-size: 14px;
    color: #555;
    line-height: 1.6;
}

/* Feature Property section CSS */

.property-link {
    border: none;
  padding: 12px 0;
  font-weight: 600;
  border-radius: 0 0 3px 3px;
  background-color: #e9f7f0; /* Theme primary */
  color: #26ad60;
  transition: all 0.3s ease;
  display: block;
  text-decoration: none;
}

/* Location Properties */
.location-item {
  position: relative;
  height: 100%;
  min-height: 240px;
  background-size: cover;
  background-position: center;
  border-radius: 12px;
  overflow: hidden;
  display: flex;
  align-items: flex-end;
  transition: all 0.4s ease;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

.location-item-big {
  min-height: 500px;
}

.location-item:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.location-item-info {
  width: calc(100% - 40px);
  padding: 20px 25px;
  background: linear-gradient(to top, rgba(0,0,0,0.6), rgba(0,0,0,0));
  color: #fff;
  border-radius: 0 0 12px 12px;
}

.location-item-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 5px;
}

.location-item-list {
  font-size: 0.95rem;
  opacity: 0.9;
}

@media (max-width: 767px) {
  .location-item-big {
    min-height: 300px;
  }

  .location-item {
    min-height: 200px;
  }

  .location-item-info {
    padding: 16px;
  }

  .location-item-title {
    font-size: 1.1rem;
  }

  .location-item-list {
    font-size: 0.875rem;
  }
}

.btn-outline-secondary:not(:disabled):not(.disabled):active,.btn-outline-secondary:focus {
    background: #fff !important;
    color: #ffffff;
    border-color: #fff !important;
}


</style>
    <!--=================================
        banner (dynamic, rotate every 5 sec) -->
    @if(isset($banners) && $banners->isNotEmpty())
    <section class="position-relative">
        <div class="relative">
            <div class="slider">
                <div class="slides" style="transform: translateX(0%);">
                    @foreach($banners as $banner)
                    @php
                        $placement = $banner->text_placement ?? 'left';
                        $bannerImgUrl = $banner->image_url ?? '';
                        $bannerDisplayStyle = $banner->image_display_style ?? '';
                    @endphp
                    <div class="slidee overlay" data-banner-bg="{{ $bannerImgUrl }}" data-banner-style="{{ e($bannerDisplayStyle) }}" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5));">
                        <div class="content content--{{ $placement }}">
                            @if($banner->sub_heading)<p>{{ $banner->sub_heading }}</p>@endif
                            @if($banner->heading)<h3>{{ $banner->heading }}</h3>@endif
                            @if($banner->cta_text && $banner->cta_url)
                                <a href="{{ $banner->cta_url }}" class="btn" style="position: relative; top: 30px;">{{ $banner->cta_text }}</a>
                            @elseif($banner->cta_text)
                                <a href="{{ route('add.listing') }}" class="btn" style="position: relative; top: 30px;">{{ $banner->cta_text }}</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($banners->count() > 1)
                <button type="button" class="banner-arrow banner-prev" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
                <button type="button" class="banner-arrow banner-next" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>
                @endif
            </div>
            @if($banners->count() > 1)
            <div class="dots">
                @foreach($banners as $i => $b)
                <div class="dot {{ $i === 0 ? 'active' : '' }}"></div>
                @endforeach
            </div>
            @endif
        </div>
    </section>
    @endif
    

    <style>

.slider {
      position: relative;
      width: 100%;
      height: 30dvh;
      overflow: hidden;
      min-height:300px;
    }

    .slides {
      display: flex;
      transition: transform 0.6s ease-in-out;
      height: 100%;
    }

    .slidee {
      min-width: 100%;
      height: 100%;
      background-size: cover;
      background-position: 70% center;
      position: relative;
      display: flex;
      align-items: center;
    /* border-radius: 20px; */
      /* padding: 40px; */
    }
.slidee .img {
    padding: 30px 80px 0 0;
}
    /* Banner arrows: visible on hover only, hidden at first/last slide */
    .banner-arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 2;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: none;
      background: rgba(255, 255, 255, 0.9);
      color: #333;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
      opacity: 0;
      transition: opacity 0.25s ease, background 0.2s ease;
      pointer-events: none;
    }
    .slider:hover .banner-arrow { opacity: 1; pointer-events: auto; }
    .banner-arrow:hover { background: #fff; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2); }
    .banner-arrow.banner-arrow--hidden { display: none !important; }
    .banner-prev { left: 16px; }
    .banner-next { right: 16px; }

    /* Dots */
    .dots {
      position: absolute;
      bottom: -25px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 8px;
    }

    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #777;
      cursor: pointer;
    }

    .dot.active {
      background: #28a745;
    }
    .relative{
        position: relative;
    }

    .slider {
      position: relative;
      width: 100%;
      height: 30dvh;
      overflow: hidden;
      min-height:400px;
    }

    .slides {
      display: flex;
      transition: transform 0.6s ease-in-out;
      height: 100%;
    }

    .content {
      padding: 20px;
      color: #fff;
      /* max-width: 500px; */
    }
    .content--left { margin-left: 100px; margin-right: auto; text-align: left; }
    .content--center { margin-left: auto; margin-right: auto; text-align: center; }
    .content--right { margin-left: auto; margin-right: 100px; text-align: right; }

    .content h3 {
      font-size: 35px;
      font-weight: 700;
      margin-bottom: 15px;
      color: #fff;
    }

    .content p {
        font-size: 16px;
        margin-bottom: 0;
        color: #26AE61;
    }

    .content .btn {
        display: inline-block;
        background: #26AE61;
        color: #fff;
        padding: 12px 20px;
        border-radius: 6px;
        font-weight: 400;
        text-decoration: none;
        font-size: 14px;
    }
.content .freecard{display: block; font-size: 11px; line-height: 2;font-weight: bold;}

    /* Dots */
    .dots {
      position: absolute;
      bottom: -25px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 8px;
    }

    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #777;
      cursor: pointer;
    }


    .relative{
        position: relative;
    }

    /* Responsive */
    @media (max-width: 768px) {

.clientMob{display: block;}

      .slider { min-height: 220px; }
      .content h3 { font-size: 18px; }
      .content p { font-size: 12px; line-height: 16px; }
      .content .btn { padding: 8px 12px; font-size: 12px; }
      h1 { font-size: 25px; }
      h2 { font-size: 15px; }
      .content { margin-left: 0; }
      .content--right { margin-right: 0; }
      .banner-arrow { display: none !important; }
      .content { max-width: 250px; z-index: 1;}
      .slidee { height: 200px; position: relative; }
.slidee .img{  padding: 20px 00px 0 0;}
.slidee:before {
    content: "";
    background: #00000045;
    height: 100%;
    width: 100%;
    position: absolute;
}
 .model-img img {
        max-height: auto !important;
        height: auto !important;
    }
    }


</style>

<script>
(function() {
  const sliderTrack1 = document.querySelector('.slides');
  const slideItems1 = document.querySelectorAll('.slidee');
  const buttonPrev1 = document.querySelector('.banner-prev');
  const buttonNext1 = document.querySelector('.banner-next');
  const navigationDots1 = document.querySelectorAll('.dot');

  if (!slideItems1.length) return;

  // Set banner background images from data attribute (avoids Blade in style for linter)
  document.querySelectorAll('.slidee[data-banner-bg]').forEach(function(el) {
    var url = el.getAttribute('data-banner-bg');
    if (url) {
      el.style.backgroundImage = 'linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(\'' + url.replace(/'/g, '\\\'') + '\')';
    }
    var style = el.getAttribute('data-banner-style');
    if (style) {
      style.split(';').forEach(function(part) {
        var m = part.trim().match(/^\s*([\w-]+)\s*:\s*(.+)$/);
        if (m) el.style.setProperty(m[1].trim(), m[2].trim());
      });
    }
  });

  let currentIndex1 = 0;
  let dragStartX1 = 0;
  let dragEndX1 = 0;
  let autoSlideTimer;

  function updateBannerArrows() {
    if (buttonPrev1) {
      if (currentIndex1 <= 0) {
        buttonPrev1.classList.add('banner-arrow--hidden');
      } else {
        buttonPrev1.classList.remove('banner-arrow--hidden');
      }
    }
    if (buttonNext1) {
      if (currentIndex1 >= slideItems1.length - 1) {
        buttonNext1.classList.add('banner-arrow--hidden');
      } else {
        buttonNext1.classList.remove('banner-arrow--hidden');
      }
    }
  }

  function showSlideAt1(indexToShow1) {
    if (slideItems1.length === 0) return;
    if (indexToShow1 < 0) {
      currentIndex1 = slideItems1.length - 1;
    } else if (indexToShow1 >= slideItems1.length) {
      currentIndex1 = 0;
    } else {
      currentIndex1 = indexToShow1;
    }
    if (sliderTrack1) sliderTrack1.style.transform = 'translateX(-' + currentIndex1 * 100 + '%)';
    navigationDots1.forEach(function(dot1, i1) {
      dot1.classList.toggle('active', i1 === currentIndex1);
    });
    updateBannerArrows();
  }

  if (buttonPrev1) buttonPrev1.addEventListener('click', function() { showSlideAt1(currentIndex1 - 1); });
  if (buttonNext1) buttonNext1.addEventListener('click', function() { showSlideAt1(currentIndex1 + 1); });
  updateBannerArrows();
  navigationDots1.forEach(function(dot1, i1) {
    dot1.addEventListener('click', function() { showSlideAt1(i1); });
  });

  // Auto-rotate every 5 seconds (only if more than one slide)
  if (slideItems1.length > 1) {
    function startAutoSlide() {
      autoSlideTimer = setInterval(function() {
        showSlideAt1(currentIndex1 + 1);
      }, 5000);
    }
    startAutoSlide();
    // Pause on hover (optional)
    if (sliderTrack1) {
      sliderTrack1.addEventListener('mouseenter', function() { clearInterval(autoSlideTimer); });
      sliderTrack1.addEventListener('mouseleave', startAutoSlide);
    }
  }

  // Drag / Swipe
  if (sliderTrack1) {
    sliderTrack1.addEventListener('touchstart', function(e) { dragStartX1 = e.touches[0].clientX; });
    sliderTrack1.addEventListener('touchend', function(e) {
      dragEndX1 = e.changedTouches[0].clientX;
      var d = dragEndX1 - dragStartX1;
      if (Math.abs(d) > 50) showSlideAt1(d > 0 ? currentIndex1 - 1 : currentIndex1 + 1);
    });
    sliderTrack1.addEventListener('mousedown', function(e) { dragStartX1 = e.clientX; });
    sliderTrack1.addEventListener('mouseup', function(e) {
      dragEndX1 = e.clientX;
      var d = dragEndX1 - dragStartX1;
      if (Math.abs(d) > 50) showSlideAt1(d > 0 ? currentIndex1 - 1 : currentIndex1 + 1);
    });
  }
})();
</script>

    <!--=================================
          banner -->

    <!--=================================
        property Type -->

<style>
.property-search-ui {
    margin-top: 35px;
    position: relative;
    z-index: 10;
}

.search-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.search-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

/* BUY / RENT */
.search-tabs {
    display: flex;
    background: #f3f3f3;
    border-radius: 8px;
    overflow: hidden;
}

.search-tabs input {
    display: none;
}

.search-tabs label {
    padding: 10px 18px;
    cursor: pointer;
    font-weight: 600;
    color: #555;
}

.search-tabs input:checked + label {
    background: #26AE61;
    color: #fff;
}

/* SMART SEARCH */
.search-input {
    flex: 1;
    position: relative;
    background: #f7f7f7;
    border-radius: 8px;
    padding-left: 36px;
}

.search-input i {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #26AE61;
}

.search-input input {
    width: 100%;
    height: 44px;
    border: none;
    background: transparent;
    outline: none;
    padding-right: 10px;
}

/* PILLS */
.search-pill select {
    height: 44px;
    border-radius: 8px;
    border: none;
    background: #f7f7f7;
    padding: 0 14px;
    font-weight: 500;
    cursor: pointer;
}

/* SEARCH BUTTON */
.search-action {
    margin-top: 16px;
    text-align: center;
}

.search-action button {
    background: #26AE61;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px 28px;
    font-weight: 600;
}

.search-action button i {
    margin-right: 6px;
}
    .seaarch-pill-outer{
        display: flex;
        gap: 10px;
    }
    .dropdown-outer{
        display: flex;
        gap: 10px;
    }

/* MOBILE */
@media (max-width: 768px) {
    .search-row {
        flex-direction: column;
    }
    .dropdown-outer{
        width: 100%;
        justify-content: space-between;
    }
    .search-input {
        width: 100%;
    }

    .search-pill {
        width: calc(50vw - 40px);
    }

    .search-pill select {
        width: 100%;
    }

    .custom-dropdown.bed{
        min-width: 140px;
    }
    .custom-dropdown.cat{
        width: 100%;
    }
    .search-pill input{
        width: 100% !important;
    }
}

.sub-tabs {
    background: #eef6f1;
}

.sub-tabs input:checked + label {
    background: #4A225B;
    color: #fff;
}

.search-pill input {
    height: 44px;
    border-radius: 8px;
    border: none;
    background: #f7f7f7;
    padding: 0 12px;
    width: 120px;
}

/* ===== DROPDOWN OPEN UI (Property Type / Beds) ===== */

.select-pill select {
    font-weight: 500;
    color: #333;
}

/* Chrome / Edge / Safari */
.select-pill select:focus {
    outline: none;
}

/* Dropdown menu styling */
.select-pill select option {
    padding: 12px 14px;
    font-size: 14px;
    background: #ffffff;
    color: #333;
}

/* Hover / active option */
.select-pill select option:hover,
.select-pill select option:checked {
    background: #26ae61;
    color: #fff;
}

/* Firefox specific */
@-moz-document url-prefix() {
    .select-pill select {
        background-color: #f7f7f7;
    }
}

/* Optional: smoother look */
.select-pill {
    transition: box-shadow 0.2s ease;
}

.select-pill:has(select:focus) {
    box-shadow: 0 0 0 2px rgba(38,174,97,0.15);
}

/* ===== CUSTOM DROPDOWN UI ===== */

.custom-dropdown {
    position: relative;
    min-width: 160px;
    font-size: 14px;
}

.dropdown-toggle {
    width: 100%;
    height: 44px;
    border-radius: 10px;
    border: none;
    background: #f7f7f7;
    padding: 0 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    font-weight: 500;
}

.dropdown-toggle i {
    font-size: 12px;
    color: #26ae61;
}

/* Dropdown card */
.dropdown-menu {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    width: 100%;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    padding: 6px 0;
    display: none;
    max-height: 220px;
    overflow-y: auto;
    z-index: 9999;
}

/* Item */
.dropdown-item {
    padding: 10px 14px;
    cursor: pointer;
    font-weight: 500;
    color: #777;
}

/* Hover */
.dropdown-item:hover {
    background: #f5f5f5;
}

/* Active (Any) */
.dropdown-item.active {
    background: #e9f7f0;
    color: #26ae61;
    font-weight: 600;
}

/* Open state */
.custom-dropdown.open .dropdown-menu {
    display: block;
}

.search-toggle-wrapper {
    display: flex;
    gap: 8px;
}

.toggle-btn {
    height: 44px;
    padding: 0 18px;
    border-radius: 10px;
    border: 1px solid #26ae61;
    background: #fff;
    color: #26ae61;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: 0.25s ease;
}

/* Hover only when NOT selected – so active state is always visible after click */
.toggle-btn:hover {
    background: #e9f7f0;
    color: #26ae61;
}

.toggle-btn.active,
.toggle-btn.active:hover,
.toggle-btn.active:focus {
    background: #26ae61 !important;
    color: #fff !important;
    border-color: #26ae61;
}



</style>


<section class="property-search-ui">
    <div class="container">
        <div class="search-card">

<form method="GET" action="{{ route('property.index') }}">

    <div class="search-row">

        <!-- BUY / RENT / OFF PLAN (plain buttons, same as Rent) -->
<div class="search-toggle-wrapper">

    @php
        $homePropertyType = request('propertyType', '1');
        $homePropertyType = in_array($homePropertyType, ['1','2','3']) ? $homePropertyType : '1';
    @endphp

    <!-- BUY BUTTON -->
    <button type="button"
            class="toggle-btn {{ $homePropertyType == '1' ? 'active' : '' }}"
            id="buyToggle"
            data-property-type="1">
        Buy
    </button>

    <!-- RENT BUTTON -->
    <button type="button"
            class="toggle-btn {{ $homePropertyType == '2' ? 'active' : '' }}"
            id="rentToggle"
            data-property-type="2">
        Rent
    </button>

    <!-- OFF PLAN BUTTON -->
    <button type="button"
            class="toggle-btn {{ $homePropertyType == '3' ? 'active' : '' }}"
            id="offPlanToggle"
            data-property-type="3">
        Off Plan
    </button>

    <!-- Hidden inputs -->
    <input type="hidden" name="status" id="status" value="">
    <input type="hidden" name="propertyType" id="propertyType" value="{{ $homePropertyType }}">
    <input type="hidden" name="buy_type" id="buy_type" value="{{ request('buy_type') }}">
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===========================
       BUY / RENT TOGGLE
    ============================ */

    const buyBtn = document.getElementById('buyToggle');
    const rentBtn = document.getElementById('rentToggle');
    const offPlanBtn = document.getElementById('offPlanToggle');
    const propertyTypeInput = document.getElementById('propertyType');

    function setActiveListingType(activeBtn) {
        [buyBtn, rentBtn, offPlanBtn].forEach(function(btn) {
            if (btn) btn.classList.remove('active');
        });
        if (activeBtn) activeBtn.classList.add('active');
    }

    if (buyBtn && propertyTypeInput) {
        buyBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            propertyTypeInput.value = '1';
            setActiveListingType(buyBtn);
        });
        if (rentBtn) {
            rentBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                propertyTypeInput.value = '2';
                setActiveListingType(rentBtn);
            });
        }
        if (offPlanBtn) {
            offPlanBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                propertyTypeInput.value = '3';
                setActiveListingType(offPlanBtn);
            });
        }
    }

    /* ===========================
       CUSTOM DROPDOWNS (Property Type / Beds)
    ============================ */

    document.querySelectorAll('.custom-dropdown').forEach(dropdown => {

        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
        const label = dropdown.querySelector('.dropdown-label');

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();

            document.querySelectorAll('.custom-dropdown')
                .forEach(d => d.classList.remove('open'));

            dropdown.classList.toggle('open');
        });

        menu.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function () {

                menu.querySelectorAll('.dropdown-item')
                    .forEach(i => i.classList.remove('active'));

                this.classList.add('active');

                hiddenInput.value = this.dataset.value;
                label.textContent = this.textContent;

                dropdown.classList.remove('open');
            });
        });
    });

    document.addEventListener('click', function () {
        document.querySelectorAll('.custom-dropdown')
            .forEach(d => d.classList.remove('open'));
    });


});
</script>







        <!-- SMART SEARCH -->
        <div class="search-input home">
            <i class="fas fa-search"></i>
            <input type="text"
                id="smart-search"
                name="location"
                placeholder="City, area or building"
                autocomplete="off"
                value="{{ request('location', '') }}">
        </div>

        <div class="seaarch-pill-outer">
            <!-- BUDGET MIN (0 to any) -->
            <div class="search-pill">
                <input type="number" name="priceMin" placeholder="Min AED" min="0" step="1"
                       value="{{ request('priceMin') }}">
            </div>

            <!-- BUDGET MAX (any value, leave empty for no max) -->
            <div class="search-pill">
                <input type="number" name="priceMax" placeholder="Max AED" min="0" step="1"
                       value="{{ request('priceMax') }}">
            </div>
        </div>    

        <div class="dropdown-outer">
            <!-- PROPERTY TYPE -->
            <div class="custom-dropdown cat" data-name="property_category_id">
                <button type="button" class="dropdown-toggle">
                    <span class="dropdown-label">Property Category</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
    
                <input type="hidden" name="property_category_id" value="{{ request('property_category_id') }}">
    
                <div class="dropdown-menu">
                    <div class="dropdown-item active" data-value="">Any</div>
                    <div class="dropdown-item" data-value="1">Residential</div>
                    <div class="dropdown-item" data-value="2">Commercial</div>
                    <div class="dropdown-item" data-value="3">Industrial</div>
                    <div class="dropdown-item" data-value="4">Land</div>
                </div>
            </div>
    
    
            <!-- BEDS -->
            <div class="custom-dropdown bed" data-name="bedrooms">
                <button type="button" class="dropdown-toggle">
                    <span class="dropdown-label">Beds</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
    
                <input type="hidden" name="bedrooms" value="{{ request('bedrooms') }}">
    
                <div class="dropdown-menu">
                    <div class="dropdown-item active" data-value="">Any</div>
                    <div class="dropdown-item" data-value="0">Studio</div>
                    @for($i=1;$i<=5;$i++)
                        <div class="dropdown-item" data-value="{{ $i }}">{{ $i }} Beds</div>
                    @endfor
                    <div class="dropdown-item" data-value="6">5+</div>
                </div>
            </div>
            
        </div>

    </div>

    <!-- SEARCH BUTTON -->
    <div class="search-action">
        <button type="submit">
            <i class="fas fa-search"></i> Search Properties
        </button>
    </div>

</form>


        </div>
    </div>
</section>


<script>
document.querySelectorAll('.custom-dropdown').forEach(dropdown => {

    const toggle = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');
    const label = dropdown.querySelector('.dropdown-label');

    toggle.addEventListener('click', () => {
        document.querySelectorAll('.custom-dropdown').forEach(d => {
            if (d !== dropdown) d.classList.remove('open');
        });
        dropdown.classList.toggle('open');
    });

    menu.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', () => {

            menu.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('active'));
            item.classList.add('active');

            hiddenInput.value = item.dataset.value;
            label.textContent = item.textContent;

            dropdown.classList.remove('open');
        });
    });
});

/* Close on outside click */
document.addEventListener('click', e => {
    if (!e.target.closest('.custom-dropdown')) {
        document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
    }
});




document.querySelectorAll('.custom-dropdown').forEach(dropdown => {

    const toggle = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');
    const items = dropdown.querySelectorAll('.dropdown-item');
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');
    const label = dropdown.querySelector('.dropdown-label');

    // Open / close
    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            if (m !== menu) m.classList.remove('show');
        });
        menu.classList.toggle('show');
    });

    // Select item
    items.forEach(item => {
        item.addEventListener('click', () => {
            items.forEach(i => i.classList.remove('active'));
            item.classList.add('active');

            const value = item.dataset.value;
            const text = item.innerText;

            hiddenInput.value = value;
            label.innerText = text === 'Any' ? label.dataset.default : text;

            menu.classList.remove('show');
        });
    });

    // Restore selected value on reload
    if (hiddenInput.value !== "") {
        const selected = dropdown.querySelector(
            `.dropdown-item[data-value="${hiddenInput.value}"]`
        );
        if (selected) {
            selected.classList.add('active');
            label.innerText = selected.innerText;
        }
    }

});

// Close on outside click
document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
});
</script>





    <section class="py-4 mt-4" style="background:#e9f7f0;">
        <div class="container text-center">
            <h1 class="fw-bold" style="color:#26AE61;">
                Buy, Sell & Rent Verified Properties in Dubai – Lowest Brokerage Fees
            </h1>
            <p class="mt-3 mb-4" style="color:#4A225B; font-size:18px;">
                Be Direct, Be Intelligent — Dubai’s most transparent, RERA-licensed real estate platform.
                No inflated commissions. No fake listings. Just verified, direct property deals.
            </p>
            <a href="{{ url('properties') }}" class="btn btn-primary me-2 focus-none">Search Verified Properties</a>
            <a href="{{ route('add.listing') }}" class="btn btn-white border border-success mt-4 mt-md-0" style="color:#26AE61;">
                List Your Property Free
            </a>
        </div>
    </section>


    <!--=================================
        Property Types -->

    <!--=================================
        feature -->

        <section class="py-5 bg-white">
            <div class="container">

                <h2 class="text-center mb-4" style="color:#26AE61;">100% Verified Listings – No Fake Ads, No Time Wasters</h2>
                <p class="text-center mb-5" style="color:#4A225B;">
                    Every property on Direct Deal UAE goes through strict verification:
                </p>

                <div class="row text-center">

                    <div class="col-md-3 mb-4">
                        <div class="p-4 shadow-sm rounded bg-light h-100">
                            <h6 class="fw-bold text-dark">Ownership Documents Checked</h6>
                            <p class="small text-muted">We ensure the property is legally owned by the advertiser.</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="p-4 shadow-sm rounded bg-light h-100">
                            <h6 class="fw-bold text-dark">Landlord Identity Verified</h6>
                            <p class="small text-muted">No fake agents. Only real owners and real landlords.</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="p-4 shadow-sm rounded bg-light h-100">
                            <h6 class="fw-bold text-dark">Property Details Validated</h6>
                            <p class="small text-muted">Photos, size, location, and specs are inspected for accuracy.</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="p-4 shadow-sm rounded bg-light h-100">
                            <h6 class="fw-bold text-dark">In-Person Review When Needed</h6>
                            <p class="small text-muted">We perform site visits when necessary to ensure authenticity.</p>
                        </div>
                    </div>

                </div>

                <p class="text-center mt-4" style="color:#26AE61; font-weight:600;">
                    No duplicates. No misleading ads. Only real, verified Dubai properties.
                </p>

            </div>
        </section>


    <section class="space-ptb d-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    
                    <div class="text-center">
                      <h2 class="mb-4">From Search to Sold – We’ve Got You Covered</h2>
                      <p class="px-sm-5 mb-4 lead fw-normal">Whether you're buying, selling, or renting, we guide you every step of the way with expert support, verified listings, and personalized service to make your property journey smooth and successful.</p>
                    </div>
                    
                </div>
                <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
                    <div class="bg-light p-4 py-5 text-center h-100">
                        <i class="flaticon-agent font-xlll text-primary mb-4"></i>
                        <h5 class="mb-3">{{ translate('A shopper reaches out') }}</h5>
                        <p class="mb-0">{{ translate('The price is something not necessarily defined as financial. It could be time.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
                    <div class="bg-light p-4 py-5 text-center h-100">
                        <i class="flaticon-like font-xlll text-primary mb-4"></i>
                        <h5 class="mb-3">{{ translate('We verify the lead') }}</h5>
                        <p class="mb-0">This is perhaps the single biggest obstacle that all of us must overcome.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4 mb-sm-0">
                    <div class="bg-light p-4 py-5 text-center h-100">
                        <i class="flaticon-room-key-1 font-xlll text-primary mb-4"></i>
                        <h5 class="mb-3">{{ translate('You connect live') }}</h5>
                        <p class="mb-0">{{ translate('One of the main areas that I work on with my clients is shedding these.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="bg-light p-4 py-5 text-center h-100">
                        <i class="flaticon-house-key-1 font-xlll text-primary mb-4"></i>
                        <h5 class="mb-3">{{ translate('Convert more deals') }}</h5>
                        <p class="mb-0">{{ translate('It is truly amazing the damage that we, as parents, can inflict on our children.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=================================
        feature -->

    @if(isset($featuredSections) && $featuredSections->isNotEmpty())
    <!--=================================
    Admin Featured Sections -->
    @foreach($featuredSections as $fs)
    @if($fs->properties->isNotEmpty())
    <section class="space-pb featured-section-block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mb-4">
                        <h2 class="mb-0">{{ $fs->title }}</h2>
                        @if($fs->heading)
                        <p class="mb-0 mt-2 text-muted {{ $fs->heading_placement === 'center' ? 'text-center' : ($fs->heading_placement === 'right' ? 'text-end' : '') }}">{{ $fs->heading }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 position-relative featured-section-swiper-wrap">
                    <div class="swiper featured-section-swiper">
                        <div class="swiper-wrapper">
            @foreach($fs->properties as $property)
                            <div class="swiper-slide">
                                <div class="property-item rounded-3 shadow-sm border border-light-subtle overflow-hidden h-100">
                                    <div class="property-image bg-overlay-gradient-04 position-relative">
                                        <img class="img-fluid rounded-top"
                                            style="height: 220px; width: 100%; object-fit: cover;"
                                            src="{{ $property->pictures->first() ? Storage::url($property->pictures->first()->path) : asset('images/placeholder.jpg') }}"
                                            alt="{{ $property->propertyName }}">
                                    </div>
                                    <div class="property-details p-3 bg-white">
                                        <h6 class="property-title mb-1 fw-semibold featured-card-title">
                                            <a href="{{ route('property.show', $property->slug ?? $property->id) }}" class="text-dark text-decoration-none">
                                                {{ $property->propertyName }}
                                            </a>
                                        </h6>
                                        <p class="property-address text-muted small mb-2 featured-card-address">
                                            <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                            <span>{{ $property->address }}</span>
                                        </p>
                                    </div>
                                    <div class="property-btn">
                                        <a class="property-link btn btn-primary w-100"
                                           href="{{ route('property.show', $property->slug ?? $property->id) }}">
                                           See Details
                                        </a>
                                    </div>
                                </div>
                            </div>
            @endforeach
                        </div>
                        <div class="swiper-pagination featured-section-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @endforeach
    @endif

    <!--=================================
Featured Properties-->
<section class="space-pb d-none">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-4">
                    <h2 class="mb-0">Featured Properties</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel owl-nav-top-left" data-nav-arrow="true" data-items="3" data-md-items="3"
                    data-sm-items="2" data-xs-items="1" data-xx-items="1" data-space="20">
                    @foreach ($featuredProperties as $property)
                        <div class="item">
                            <div class="property-item rounded-3 shadow-sm border border-light-subtle overflow-hidden">
                                <div class="property-image bg-overlay-gradient-04 position-relative">
                                    <img class="img-fluid rounded-top"
                                        style="height: 220px; width: 100%; object-fit: cover; object-position: center;"
                                        src="{{ $property->pictures->first() ? Storage::url($property->pictures->first()->path) : asset('images/placeholder.jpg') }}"
                                        alt="{{ $property->propertyName }}">
                                    
                                    <!-- Trending icon - now top-left -->
                                    <span class="property-trending position-absolute top-0 start-0 text-warning">
                                        <i class="fas fa-bolt"></i>
                                    </span>

                                    <!-- Badges - now top-right -->
                                    <div class="property-lable position-absolute top-0 end-0 m-2 text-end">
                                        <span class="badge bg-primary me-1">{{ $property->childTypeRelation->name ?? 'No Type' }}</span>
                                        <span class="badge bg-info">{{ $propertyTypes[$property->propertyType] ?? 'Unknown' }}</span>
                                    </div>

                                    <div class="property-agent-popup position-absolute bottom-0 end-0 m-2 bg-white text-dark px-2 py-1 rounded">
                                        <i class="fas fa-camera me-1"></i>{{ $property->pictures->count() }}
                                    </div>
                                </div>
                                <div class="property-details p-3 bg-white">
                                    <h6 class="property-title mb-1 fw-semibold">
                                        <a href="{{ route('property.show', $property->slug ?? $property->id) }}" class="text-dark">
                                            {{ $property->propertyName }}
                                        </a>
                                    </h6>
                                    <p class="property-address text-muted small mb-2">
                                        <i class="fas fa-map-marker-alt me-1 text-primary"></i> {{ $property->address }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center small mb-2 text-muted">
                                        <span><i class="far fa-clock me-1"></i>{{ $property->created_at->diffForHumans() }}</span>
                                        <span class="fw-bold text-dark">{{ number_format($property->price) }} AED 
                                            @if ($property->propertyType == 2)
                                                <small class="text-muted">/month</small>
                                            @endif
                                        </span>
                                    </div>
                                    <ul class="property-info list-unstyled d-flex justify-content-between text-center border-top pt-2 mt-2 mb-0 small">
                                        <li><i class="fas fa-bed text-primary me-1"></i>
                                            {{ $property->bedrooms == 0 ? 'Studio' : $property->bedrooms . ' Beds' }}
                                        </li>

                                        <li><i class="fas fa-bath text-primary me-1"></i>{{ $property->bathrooms }} Bath</li>
                                        <li><i class="far fa-square text-primary me-1"></i>{{ $property->builtArea }} m²</li>
                                    </ul>

                                </div>
                                <!-- Your original "See Details" part -->
                                <div class="property-btn">
                                  <a class="property-link btn btn-primary d-block text-center w-100" href="{{ route('property.show', $property->slug ?? $property->id) }}">See Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 text-center mt-4">
                <a class="btn btn-link fw-semibold text-primary" href="{{ url('properties') }}">
                    <i class="fas fa-plus me-1"></i>View All Listings
                </a>
            </div>
        </div>
    </div>
</section>
<!--=================================
Featured Properties-->



<!--- ===========================
Why Direct Deal -->


<section class="py-5 mb-5" style="background:#f7fdfb;">
    <div class="container">

        <h2 class="text-center mb-4" style="color:#26AE61;">Why Direct Deal UAE?</h2>

        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="p-4 shadow-sm bg-white rounded h-100">
                    <h5 class="fw-bold text-dark">0% Commission for Owners & Landlords</h5>
                    <p>No brokerage charged to sellers or landlords. Listing your property is completely free.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="p-4 shadow-sm bg-white rounded h-100">
                    <h5 class="fw-bold text-dark">Lowest Brokerage Fees in the UAE</h5>
                    <p>
                        Buyers pay only <strong>0.2% brokerage</strong> and tenants pay
                        <strong>0.5% brokerage</strong>.
                        Traditional brokers charge 2%–5%.
                    </p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="p-4 shadow-sm bg-white rounded h-100">
                    <h5 class="fw-bold text-dark">Verified Owners, Buyers & Tenants</h5>
                    <p>No fake leads or misleading ads. All users are identity-verified before connecting.</p>
                </div>
            </div>

        </div>

    </div>
</section>





    <!--=================================
        location -->
    <section class="space-pb d-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2>Find properties in Top Areas</h2>
                    </div>
                </div>
            </div>
            <div class="row">
    @php
        $locations = [
            ['name' => 'Dubai South', 'image' => 'images/location/dubaiSouth.png'],
            ['name' => 'Palm Jebel Ali', 'image' => 'images/location/palmJebelAli.png'],
            ['name' => 'Downtown Dubai', 'image' => 'images/location/downtownDubai.png'],
            ['name' => 'Business Bay', 'image' => 'images/location/businessBay.png'],
        ];
    @endphp

    @foreach($locations as $location)
        @php $locImageUrl = asset($location['image']); @endphp
        <div class="col-md-6 mb-4">
            <a href="{{ url('properties') }}?location={{ urlencode($location['name']) }}">
                <div class="location-item bg-overlay-gradient bg-holder" data-loc-bg="{{ $locImageUrl }}">
                    <div class="location-item-info">
                        <h5 class="location-item-title">{{ $location['name'] }}</h5>
                        <span class="location-item-list">{{ $propertyCounts[$location['name']] ?? 0 }} Properties</span>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

        </div>
    </section>
    <!--=================================
        location -->

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.location-item[data-loc-bg]').forEach(function(el) {
    var url = el.getAttribute('data-loc-bg');
    if (url) {
      el.style.backgroundImage = 'url(\'' + url.replace(/'/g, '\\\'') + '\')';
    }
  });
});
</script>

    <!--=================================
        about-->

    <!-- <section class="space-ptb bg-holder bg-overlay-black-70" style="background-image: url(images/bg/01.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center position-relative">
                    <div class="section-title">
                        <span class="text-primary fw-bold d-block mb-3">Buy or sell</span>
                        <h2 class="text-white">Looking to buy a new property or sell an existing one? Direct Deal provides
                            an excellent solution!</h2>
                    </div>
                    <a class="btn btn-primary mb-2 mb-sm-0" href="#">Submit Property</a>
                    <a class="btn btn-white mb-2 mb-sm-0" href="{{ url('properties') }}">Browse Properties</a>
                </div>
            </div>
        </div>
    </section> -->

    <!--=================================
        about-->


<!--===============================================
     HOW DIRECT DEAL WORKS – SALES (Enhanced)
================================================-->

<section class="py-5" style="background:#ffffff;">
    <div class="container">

        <h2 class="mb-4 text-center" style="color:#26AE61; font-weight:800; font-size:32px;">
            How Direct Deal Works – <span style="color:#4A225B;">Property Sales</span>
        </h2>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="p-4 rounded shadow-sm" style="background:#f7fdfb; border-left:6px solid #26AE61;">
                    <ol class="ps-3" style="font-size:18px; line-height:1.9; color:#333; list-style: none;">
                        
                        <li class="mb-4">
                            <strong style="color:#26AE61; font-size:20px;">
                                1. Owner Lists Property (Free)
                            </strong>
                            <br>
                            Upload photos & details — our team verifies ownership before going live.
                        </li>

                        <li class="mb-4">
                            <strong style="color:#26AE61; font-size:20px;">
                                2. Buyer Shows Interest
                            </strong>
                            <br>
                            Buyer contacts through Direct Deal → we verify ID & financial capability.
                        </li>

                        <li class="mb-4">
                            <strong style="color:#26AE61; font-size:20px;">
                                3. Direct Connection & Secure Offer Exchange
                            </strong>
                            <br>
                            Verified offers are shared safely. Direct Deal acts as a
                            <strong>RERA-licensed brokerage</strong>, facilitating negotiations,
                            contracts, and transaction completion.
                        </li>


                    </ol>
                </div>

                <div class="mt-4 text-center p-3 rounded" style="background:#ffffff;">
                    <p class="text-dark mb-1 fw-bold" style="font-size:16px;">
                        Buyers pay only <span style="color:#26AE61;">0.2% brokerage</span>
                        — compared to the market standard of 2%.
                    </p>
                    <p class="small text-muted">
                        This covers documentation, verification, contract A, B, F preparation and support until property transfer.
                    </p>
                </div>


            </div>
        </div>

    </div>
</section>


<!--=====================================================
     HOW DIRECT DEAL WORKS – RENTALS (Enhanced)
======================================================-->

<section class="py-5" style="background:#e9f7f0;">
    <div class="container">

        <h2 class="mb-4 text-center" style="color:#26AE61; font-weight:800; font-size:32px;">
            How Direct Deal Works – <span style="color:#4A225B;">Rentals</span>
        </h2>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="p-4 rounded shadow-sm" style="background:#ffffff; border-left:6px solid #4A225B;">
                    <ol class="ps-3" style="font-size:18px; line-height:1.9; color:#333; list-style: none;">

                        <li class="mb-4">
                            <strong style="color:#4A225B; font-size:20px;">
                                1. Landlord Lists Property Free
                            </strong>
                            <br>
                            Ownership, photos & unit details are fully verified before listing goes live.
                        </li>

                        <li class="mb-4">
                            <strong style="color:#4A225B; font-size:20px;">
                                2. Tenant Shows Interest
                            </strong>
                            <br>
                            We verify tenant identity and rental capability to avoid time-wasters.
                        </li>

                        <li class="mb-4">
                            <strong style="color:#4A225B; font-size:20px;">
                                3. Tenancy Agreement & Ejari Support
                            </strong>
                            <br>
                            Direct Deal prepares the tenancy contract and assists with the complete process.
                        </li>

                    </ol>
                </div>

                <div class="mt-4 text-center p-3 rounded" style="background:#ffffff;">
                    <p class="text-dark mb-1 fw-bold" style="font-size:16px;">
                        Tenants pay only <span style="color:#26AE61;">0.5% of annual rent</span>
                        — not 5% brokerage.
                    </p>
                    <p class="small text-muted">
                        This includes tenancy contract preparation, Ejari support, and transaction coordination.
                    </p>
                </div>

            </div>
        </div>

    </div>
</section>




    <!--=================================
        Feature -->
    <section class="space-ptb bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2>What You Pay</h2>
                    </div>
                </div>
                <div class="col-lg-6 d-none">
                    <div class="popup-video mb-4 text-lg-end">
                        <a class="popup-icon popup-youtube d-flex justify-content-lg-end"
                            href="https://www.youtube.com/watch?v=LgvseYYhqU0"> <span class="pe-3"> Play Video</span> <i
                                class="flaticon-play-button"></i> </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
                    <div class="feature-info feature-info-02">
                        <div class="feature-info-detail">
                            <div class="feature-info-icon">
                                <i class="flaticon-like"></i>
                            </div>
                            <div class="feature-info-content">
                                <h6 class="mb-3 feature-info-title">For Sellers & Landlords</h6>
                                <p><strong>0% Commission</strong><br>No listing fees. No hidden charges.</p>
                            </div>
                            <!-- <div class="feature-info-button">
                                <a class="btn btn-light d-grid" href="#">Read more</a>
                            </div> -->
                        </div>
                        <div class="feature-info-bg bg-holder bg-overlay-black-70"
                            style="background-image: url('images/property/grid/01.jpg');"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
                    <div class="feature-info feature-info-02">
                        <div class="feature-info-detail">
                            <div class="feature-info-icon">
                                <i class="flaticon-agent"></i>
                            </div>
                            <div class="feature-info-content">
                                <h6 class="mb-3 feature-info-title">For Buyers</h6>
                                <p><strong>0.2% Brokerage Fee</strong><br>
                                Includes negotiation support, contracts, and transfer coordination.</p>
                            </div>
                            <!-- <div class="feature-info-button">
                                <a class="btn btn-light d-grid" href="#">Read more</a>
                            </div> -->
                        </div>
                        <div class="feature-info-bg bg-holder bg-overlay-black-70"
                            style="background-image: url('images/property/grid/02.jpg');"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4 mb-sm-0">
                    <div class="feature-info feature-info-02">
                        <div class="feature-info-detail">
                            <div class="feature-info-icon">
                                <i class="flaticon-like-1"></i>
                            </div>
                            <div class="feature-info-content">
                                <h6 class="mb-3 feature-info-title">For Tenants</h6>
                                <p><strong>0.5% Brokerage Fee</strong><br>
                            </div>
                            <!-- <div class="feature-info-button">
                                <a class="btn btn-light d-grid" href="#">Read more</a>
                            </div> -->
                        </div>
                        <div class="feature-info-bg bg-holder bg-overlay-black-70"
                            style="background-image: url('images/property/grid/03.jpg');"></div>
                    </div>
                </div>
                <!-- <div class="col-lg-3 col-sm-6">
                    <div class="feature-info feature-info-02">
                        <div class="feature-info-detail">
                            <div class="feature-info-icon">
                                <i class="flaticon-house-1"></i>
                            </div>
                            <div class="feature-info-content">
                                <h6 class="mb-3 feature-info-title">Tons of options</h6>
                                <p>Discover a place you’ll love to live in. Choose from our vast inventory and choose your
                                    desired house.</p>
                            </div>
                            <div class="feature-info-button">
                                <a class="btn btn-light d-grid" href="#">Read more</a>
                            </div>
                        </div>
                        <div class="feature-info-bg bg-holder bg-overlay-black-70"
                            style="background-image: url('images/property/grid/04.jpg');"></div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <!--=================================
        Feature -->




    <!--=================================
        testimonial -->
    <section class="space-ptb">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title">
                        <h2>Testimonials</h2>
                    </div>
                    <div class="owl-carousel owl-nav-top-left" data-nav-arrow="true" data-items="1" data-md-items="1"
                        data-sm-items="1" data-xs-items="1" data-xx-items="1" data-space="0">
                        <div class="item">
                            <div class="testimonial-02">
                                <div class="testimonial-content">
                                    <p><i class="fas fa-quote-right quotes"></i>Had a great experience with Sharib from Direct Deals. He guided me through every step of my property investment — from identifying the right project to completing the purchase smoothly. Very professional, transparent, and knowledgeable. Highly recommend him and the Direct Deals team!</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar avatar avatar-lg me-3">
                                        <img class="img-fluid rounded-circle" src="images/avatar/01.jpg" alt="">
                                    </div>
                                    <div class="testimonial-name">
                                        <h6 class="text-primary mb-1">Vishnu</h6>
                                        <span>Dubai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-02">
                                <div class="testimonial-content">
                                    <p><i class="fas fa-quote-right quotes"></i>A 100% recommended firm in Dubai and Wonderful services by Direct Deal! All the agents are well-qualified and amazing in nature. They never get tired of answering queries—you can ask them any number of questions about the property. They offer several project options, both on-site and off-site. Not only do they connect you with the best developers, but they also provide you with the best deals.Thank you, Direct Deal, for your amazing services.</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar avatar avatar-lg me-3">
                                        <img class="img-fluid rounded-circle" src="images/avatar/02.jpg" alt="">
                                    </div>
                                    <div class="testimonial-name">
                                        <h6 class="text-primary mb-1">Manpreet Kaur</h6>
                                        <span>Dubai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-02">
                                <div class="testimonial-content">
                                    <p><i class="fas fa-quote-right quotes"></i>Absolutely loved the services of this firm. The agents are well qualified and experts in Dubai real estate market. They always gave professional advise in terms on the multiple options available for first time buyers. The company made the overall process smooth and I would strongly recommend their services to everyone, especially if you are a first time buyer.</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar avatar avatar-lg me-3">
                                        <img class="img-fluid rounded-circle" src="images/avatar/02.jpg" alt="">
                                    </div>
                                    <div class="testimonial-name">
                                        <h6 class="text-primary mb-1">Idrak Khan</h6>
                                        <span>Dubai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-02">
                                <div class="testimonial-content">
                                    <p><i class="fas fa-quote-right quotes"></i>“Mr. Sharib is an exceptional property broker in Dubai. With his engineering background and genuine advice, he helped me find the perfect property. Honest, loyal, and truly different from conventional brokers — highly recommended!”</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar avatar avatar-lg me-3">
                                        <img class="img-fluid rounded-circle" src="images/avatar/02.jpg" alt="">
                                    </div>
                                    <div class="testimonial-name">
                                        <h6 class="text-primary mb-1">engr.kanwal asif iqbal</h6>
                                        <span>Dubai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-02">
                                <div class="testimonial-content">
                                    <p><i class="fas fa-quote-right quotes"></i>Thanks to the Direct Deal! I could buy my first apartment in Dubai. Sales manager Shifa was very polite and helpful through the all process to choose and buy our dreamy house.
                                    Definitely will suggest this agency to my friends and colleagues!!</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar avatar avatar-lg me-3">
                                        <img class="img-fluid rounded-circle" src="images/avatar/02.jpg" alt="">
                                    </div>
                                    <div class="testimonial-name">
                                        <h6 class="text-primary mb-1">M.n.</h6>
                                        <span>Dubai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-5 mt-md-0">
                    <div class="section-title">
                        <h2>Frequently asked questions</h2>
                    </div>
                    <div class="accordion" id="accordion">
                        <div class="accordion-item border-0">
                            <div class="accordion-title" id="accordion-title-one">
                                <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-one"
                                    aria-expanded="true" aria-controls="accordion-one">01. Is listing really free for sale and rent?</a>
                            </div>
                            <div id="accordion-one" class="collapse show" aria-labelledby="accordion-title-one"
                                data-bs-parent="#accordion">
                                <div class="accordion-content">100% free for owners and landlords.</div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <div class="accordion-title" id="accordion-title-tow">
                                <a href="#" class="collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-two" aria-expanded="false"
                                    aria-controls="accordion-two">02. Why do tenants pay only 0.5%?</a>
                            </div>
                            <div id="accordion-two" class="collapse" aria-labelledby="accordion-title-tow"
                                data-bs-parent="#accordion">
                                <div class="accordion-content">This covers tenancy contract, Ejari, and documentation.</div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <div class="accordion-title" id="accordion-title-three">
                                <a href="#" class="collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-three" aria-expanded="false"
                                    aria-controls="accordion-three">03. Are listings verified?</a>
                            </div>
                            <div id="accordion-three" class="collapse" aria-labelledby="accordion-title-three"
                                data-bs-parent="#accordion">
                                <div class="accordion-content">No property goes live without full verification.</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex align-items-center">
                            <span class="d-block me-3 text-dark"><b>Call us</b></span>
                            <i class="fas fa-phone bg-primary p-3 rounded-circle text-white fa-flip-horizontal"></i>
                            <h6 class="ps-3 mb-0 text-primary"><a href="tel:+971581144230">+971581144230</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=================================
        testimonial -->

        <!--=================================
     SEO FOOTER TEXT (Added)
=================================-->
<section class="py-4" style="background:#f7fdfb;">
    <div class="container text-center">

        <p class="mb-0" style="color:#4A225B; font-size:14px;">
            DirectDealUAE.com – Dubai’s most transparent low-brokerage real estate platform with verified listings,
            verified users, and RERA-regulated property transactions.
        </p>

        <p class="small mt-2" style="color:#26AE61;">
            Low brokerage real estate Dubai | Cheapest broker in Dubai |
            0.2% brokerage Dubai | Verified property listings Dubai |
            RERA licensed real estate broker Dubai
        </p>

        <p class="small fw-bold mt-2" style="color:#333;">
            Direct Deal | RERA-Licensed Brokerage | ORN 43954
        </p>

    </div>
</section>


<!-- WhatsApp Floating Button -->
<a
  href="https://wa.me/971581144230?text=Hi%2C%20I%20just%20visited%20the%20DirectDealUAE%20website.%20Could%20you%20please%20share%20more%20details%3F"
  class="whatsapp-float"
  target="_blank"
  rel="noopener noreferrer"
>
  <img
    src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
    alt="WhatsApp Chat"
    class="whatsapp-icon"
  />
</a>

<style>
.whatsapp-float {
  position: fixed;
  bottom: 25px;
  left: 25px;
  width: 60px;
  height: 60px;
  background-color: #25d366;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  z-index: 9999;
  text-decoration: none;
}

.whatsapp-icon {
  width: 35px;
  height: 35px;
}
.whatsapp-float:hover {
  background-color: #1ebe5d;
}
.advance-dropdown-menu {
    position: absolute;
    top: 72px;
    left: 0;
    width: 260px;
    background: #fff;
    border-radius: 8px;
    z-index: 1000;
    display: none;
}

.advance-dropdown-menu.show {
    display: block;
}

.dropdown-label {
    font-size: 14px;
    color: #777;
    margin-bottom: 3px;
}

.advance-toggle {
    cursor: pointer;
}

.focus-none:focus {
    color: #fff;
}



.home .location-input-wrapper {
    position: relative;
}

.home .location-search-icon {
    position: absolute;
    top: 50%;
    left: 0px;
    transform: translateY(-50%);
    color: #999;
    font-size: 14px;
}

.home .location-input {
    padding-left: 20px; /* space for icon */
}

/* Dropdown */
.home .location-dropdown {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    width: 100%;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    z-index: 9999;
    max-height: 260px;
    overflow-y: auto;
    padding: 10px 0;
}

.home .location-title {
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    color: #333;
}

.home .location-option {
    padding: 10px 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.home .location-option:hover {
    background: #f5f5f5;
}

.home .location-option i {
    color: #26AE61;
    font-size: 14px;
}

.home .location-search-icon.fa-search:before {
    content: "\f002";
    color: #26ae61;
}
.property-search-field .form-control{border: none; cursor: pointer;}

input#location-input::placeholder {
    color: gray;
}
</style>
<script>



const input = document.getElementById('location-input');
const dropdown = document.getElementById('location-dropdown');
const items = dropdown.querySelectorAll('.location-option');

input.addEventListener('focus', () => {
    dropdown.classList.remove('d-none');
});

input.addEventListener('input', () => {
    const query = input.value.toLowerCase();

    let visibleCount = 0;

    items.forEach(item => {
        const text = item.dataset.value.toLowerCase();
        if (text.includes(query)) {
            item.style.display = 'flex';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    dropdown.classList.toggle('d-none', visibleCount === 0);
});

items.forEach(item => {
    item.addEventListener('click', () => {
        input.value = item.dataset.value;
        dropdown.classList.add('d-none');
    });
});

// Close on outside click
document.addEventListener('click', (e) => {
    if (!e.target.closest('.form-group')) {
        dropdown.classList.add('d-none');
    }
});


document.querySelector('.advance-toggle').addEventListener('click', function() {
    document.querySelector('.advance-dropdown-menu').classList.toggle('show');
});

// Close if clicking outside
document.addEventListener('click', function(e) {
    let dropdown = document.querySelector('.advance-dropdown-menu');
    let toggle = document.querySelector('.advance-toggle');
    if (!dropdown.contains(e.target) && !toggle.contains(e.target)) {
        dropdown.classList.remove('show');
    }
});
</script>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
.featured-section-block .featured-section-swiper-wrap { padding: 0; }
.featured-section-block .featured-section-swiper { padding: 0 0 48px; position: relative; }
/* Dots at bottom – green theme */
.featured-section-block .featured-section-pagination {
    position: absolute; bottom: 0; left: 0; width: 100%;
    text-align: center; padding-top: 16px;
}
.featured-section-block .featured-section-pagination .swiper-pagination-bullet {
    width: 10px; height: 10px; background: #dee2e6; opacity: 1;
    transition: background 0.2s, transform 0.2s;
}
.featured-section-block .featured-section-pagination .swiper-pagination-bullet-active {
    background: #26ae61; transform: scale(1.2);
}
/* Card title: 2-line ellipsis */
.featured-section-block .featured-card-title { min-height: 2.8em; }
.featured-section-block .featured-card-title a {
    display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; text-overflow: ellipsis; line-height: 1.4;
}
/* Location: single line ellipsis so card height stays consistent */
.featured-section-block .featured-card-address { min-height: 1.5em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.featured-section-block .featured-card-address span { display: inline; }
</style>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function() {
    function initFeaturedSwipers() {
        if (typeof Swiper === 'undefined') return;
        document.querySelectorAll('.featured-section-swiper').forEach(function(el) {
            if (el.swiper) return;
            new Swiper(el, {
                slidesPerView: 1.15,
                spaceBetween: 20,
                loop: true,
                autoplay: { delay: 3000, disableOnInteraction: false },
                pagination: {
                    el: el.querySelector('.swiper-pagination'),
                    clickable: true
                },
                breakpoints: {
                    576: { slidesPerView: 2.2 },
                    992: { slidesPerView: 3.3 }
                }
            });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFeaturedSwipers);
    } else {
        initFeaturedSwipers();
    }
    setTimeout(initFeaturedSwipers, 100);
})();
</script>
@endpush

@endsection
