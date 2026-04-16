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

/* Mobile: CTA, sections, containers */
@media (max-width: 768px) {
  .banner { padding: 80px 0 60px; }
  .property-search-ui { margin-top: 20px; }
  .container { padding-left: 16px; padding-right: 16px; }
  section.py-4.mt-4 .container { padding-left: 16px; padding-right: 16px; }
  section.py-4.mt-4 h1 { font-size: 20px; line-height: 1.4; }
  section.py-4.mt-4 p { font-size: 15px; }
  section.py-4.mt-4 .btn { display: block; width: 100%; margin-bottom: 10px; text-align: center; }
  section.py-4.mt-4 .btn.me-2 { margin-right: 0 !important; }
  section.py-4.mt-4 .mt-md-0 { margin-top: 0; }
  .py-5.bg-white h2 { font-size: 20px; }
  .py-5.bg-white .col-md-3 { margin-bottom: 16px; }
  .py-5.bg-white .p-4 { padding: 1rem !important; }
  section.py-5.mb-5 .row .col-md-4 { margin-bottom: 16px; }
  section.py-5.mb-5 .p-4 { padding: 1rem !important; }
  section.py-5 h2.mb-4 { font-size: 22px; line-height: 1.3; }
  section.py-5 .p-4.rounded.shadow-sm { padding: 1rem !important; }
  section.py-5 .p-4.rounded.shadow-sm ol { font-size: 15px; padding-left: 1.25rem; }
  section.py-5 .p-4.rounded.shadow-sm li { margin-bottom: 1rem; }
  section.py-5 .p-4.rounded.shadow-sm strong { font-size: 16px; }
  .space-ptb.bg-light .col-lg-4 { margin-bottom: 1rem; }
  .space-ptb .section-title h2 { font-size: 20px; }
  .space-ptb .testimonial-content p { font-size: 14px; }
  .col-md-6.mt-5.mt-md-0 { margin-top: 1.5rem !important; }
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
    <section class="position-relative home-banner-section">
        <div class="relative">
         
            <div class="slider">
                <div class="slides" style="transform: translateX(0%);">
                    @foreach($banners as $banner)
                    @php
                        $placement = $banner->text_placement ?? 'left';
                        $bannerImgUrl = $banner->image_url ?? '';
                        $bannerDisplayStyle = $banner->image_display_style ?? '';
                    @endphp
                    <div class="slidee overlay" data-banner-style="{{ e($bannerDisplayStyle) }}">
                        <img class="banner-slide-img" src="{{ $bannerImgUrl }}" alt="">
                        <div class="content content--{{ $placement }}">
                            @if($banner->sub_heading)<p class="banner-subheading">{{ $banner->sub_heading }}</p>@endif
                            @if($banner->heading)<h3>{{ $banner->heading }}</h3>@endif
                            @if($banner->cta_text && $banner->cta_url)
                                <a href="{{ $banner->cta_url }}" class="btn banner-cta-btn">{{ $banner->cta_text }}</a>
                            @elseif($banner->cta_text)
                                <a href="{{ route('add.listing') }}" class="btn banner-cta-btn">{{ $banner->cta_text }}</a>
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

/* Banner: capped height – shorter slider on all screens */
    .home-banner-section .slider {
      position: relative;
      width: 100%;
      overflow: hidden;
      max-width: 100%;
      max-height: 380px;
    }

    .home-banner-section .slides {
      display: flex;
      transition: transform 0.6s ease-in-out;
    }

    .home-banner-section .slidee {
      min-width: 100%;
      width: 100%;
      flex-shrink: 0;
      position: relative;
      display: block;
      max-height: 380px;
      overflow: hidden;
    }

    .home-banner-section .slidee .banner-slide-img {
      width: 100%;
      height: 380px;
      max-height: 380px;
      object-fit: cover;
      object-position: center;
      display: block;
      vertical-align: top;
    }

    .home-banner-section .slidee .content {
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .home-banner-section .slidee.overlay::before {
      content: "";
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5));
      pointer-events: none;
    }

    .home-banner-section .slidee .content {
      z-index: 1;
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
    .home-banner-section:hover .banner-arrow { opacity: 1; pointer-events: auto; }
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

    .content {
      padding: 20px;
      color: #fff;
      max-width: 100%;
      box-sizing: border-box;
    }
    .content--left { margin-left: 100px; margin-right: auto; text-align: left; align-items: flex-start; }
    .content--center { margin-left: auto; margin-right: auto; text-align: center; align-items: center; }
    .content--right { margin-left: auto; margin-right: 100px; text-align: right; align-items: flex-end; }

    .content h3 {
      font-size: 35px;
      font-weight: 700;
      margin-bottom: 15px;
      color: #fff;
    }

    .content p {
        font-size: 16px;
        margin-bottom: 0;
        color: #ffffff;
    }

    .content .banner-subheading {
        display: inline-flex;
        align-items: center;
        margin-bottom: 12px;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(38, 174, 97, 0.2);
        border: 1px solid rgba(38, 174, 97, 0.45);
        color: #dcffe9;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .content .banner-cta-btn {
        display: inline-block;
        width: auto;
        max-width: 100%;
        background: #26AE61;
        color: #fff;
        padding: 13px 24px;
        margin-top: 18px;
        border-radius: 999px;
        font-weight: 600;
        text-decoration: none;
        font-size: 15px;
        letter-spacing: 0.2px;
        white-space: nowrap;
        flex-shrink: 0;
        box-shadow: 0 10px 24px rgba(38, 174, 97, 0.32);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .content .banner-cta-btn:hover {
        background: #1f9553;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(38, 174, 97, 0.38);
        text-decoration: none;
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

    /* Responsive: banner and general mobile */
    @media (max-width: 768px) {
      .clientMob { display: block; }
      /* Banner: cap height on mobile so it doesn’t dominate the screen */
      .home-banner-section .slider { max-height: 200px; }
      .home-banner-section .slidee { max-height: 200px; overflow: hidden; }
      .home-banner-section .slidee .banner-slide-img {
        max-height: 200px;
        width: 100%;
        height: 200px;
        object-fit: cover;
        object-position: center;
      }
      .home-banner-section .slidee .content { padding: 12px 16px; margin-left: 0 !important; margin-right: 0 !important; max-width: 100%; z-index: 1; }
      .home-banner-section .slidee .content--left,
      .home-banner-section .slidee .content--center,
      .home-banner-section .slidee .content--right { margin-left: 16px !important; margin-right: 16px !important; }
      .home-banner-section .slidee .content h3 { font-size: 16px; line-height: 1.3; margin-bottom: 6px; }
      .home-banner-section .slidee .content p { font-size: 11px; line-height: 1.4; }
      .home-banner-section .slidee .content .banner-subheading {
        margin-bottom: 8px;
        padding: 4px 9px;
        font-size: 10px;
      }
      .home-banner-section .slidee .content .banner-cta-btn {
        margin-top: 8px;
        padding: 9px 14px;
        font-size: 12px;
        min-height: 40px;
        min-width: 100px;
        max-width: 100%;
        width: auto;
        box-sizing: border-box;
        white-space: normal;
        word-break: break-word;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        line-height: 1.3;
      }
      .banner-arrow { display: none !important; }
      .slidee .img { padding: 20px 0 0 0; }
      .slidee::before {
        content: "";
        background: rgba(0,0,0,0.35);
        height: 100%;
        width: 100%;
        position: absolute;
      }
      .model-img img { max-height: auto !important; height: auto !important; }
      h1 { font-size: 22px; line-height: 1.35; }
      h2 { font-size: 18px; line-height: 1.35; }
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

  // Optional: apply image_display_style from admin (e.g. object-position) to img
  document.querySelectorAll('.slidee[data-banner-style]').forEach(function(el) {
    var style = el.getAttribute('data-banner-style');
    var img = el.querySelector('.banner-slide-img');
    if (style && img) {
      style.split(';').forEach(function(part) {
        var m = part.trim().match(/^\s*([\w-]+)\s*:\s*(.+)$/);
        if (m) img.style.setProperty(m[1].trim(), m[2].trim());
      });
    }
  });

  function setSliderHeight() {
    var slider = document.querySelector('.home-banner-section .slider');
    var slides = document.querySelector('.home-banner-section .slides');
    if (!slider || !slides) return;
    var index = Math.abs(parseInt(slides.style.transform.replace(/[^0-9-]/g, ''), 10) / 100) || 0;
    var slide = slideItems1[index];
    if (slide) {
      var h = slide.offsetHeight;
      slider.style.height = h + 'px';
    }
  }

  if (sliderTrack1 && slideItems1[0]) {
    var firstImg = slideItems1[0].querySelector('.banner-slide-img');
    if (firstImg) {
      firstImg.addEventListener('load', setSliderHeight);
      if (firstImg.complete) setSliderHeight();
      else setSliderHeight();
      setTimeout(setSliderHeight, 100);
    }
  }

  let currentIndex1 = 0;
  let dragStartX1 = 0;
  let dragEndX1 = 0;
  let autoSlideTimer;
  let isManualNavPause1 = false;

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
    setSliderHeight();
  }

  if (buttonPrev1) buttonPrev1.addEventListener('click', function() { showSlideAt1(currentIndex1 - 1); });
  if (buttonNext1) buttonNext1.addEventListener('click', function() { showSlideAt1(currentIndex1 + 1); });
  updateBannerArrows();
  navigationDots1.forEach(function(dot1, i1) {
    dot1.addEventListener('click', function() { showSlideAt1(i1); });
  });

  // Auto-rotate every 5 seconds (only if more than one slide)
  if (slideItems1.length > 1) {
    function stopAutoSlideAfterManualNav() {
      isManualNavPause1 = true;
      clearInterval(autoSlideTimer);
    }

    function startAutoSlide() {
      if (isManualNavPause1) return;
      clearInterval(autoSlideTimer);
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

    if (buttonPrev1) {
      buttonPrev1.addEventListener('click', stopAutoSlideAfterManualNav);
    }
    if (buttonNext1) {
      buttonNext1.addEventListener('click', stopAutoSlideAfterManualNav);
    }
    navigationDots1.forEach(function(dot1) {
      dot1.addEventListener('click', stopAutoSlideAfterManualNav);
    });
  }

  // Drag / Swipe
  if (sliderTrack1) {
    sliderTrack1.addEventListener('touchstart', function(e) { dragStartX1 = e.touches[0].clientX; });
    sliderTrack1.addEventListener('touchend', function(e) {
      dragEndX1 = e.changedTouches[0].clientX;
      var d = dragEndX1 - dragStartX1;
      if (Math.abs(d) > 50) {
        showSlideAt1(d > 0 ? currentIndex1 - 1 : currentIndex1 + 1);
        if (slideItems1.length > 1) {
          clearInterval(autoSlideTimer);
          autoSlideTimer = setInterval(function() {
            showSlideAt1(currentIndex1 + 1);
          }, 5000);
        }
      }
    });
    sliderTrack1.addEventListener('mousedown', function(e) { dragStartX1 = e.clientX; });
    sliderTrack1.addEventListener('mouseup', function(e) {
      dragEndX1 = e.clientX;
      var d = dragEndX1 - dragStartX1;
      if (Math.abs(d) > 50) {
        showSlideAt1(d > 0 ? currentIndex1 - 1 : currentIndex1 + 1);
        if (slideItems1.length > 1) {
          clearInterval(autoSlideTimer);
          autoSlideTimer = setInterval(function() {
            showSlideAt1(currentIndex1 + 1);
          }, 5000);
        }
      }
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
        gap: 12px;
    }
    .search-toggle-wrapper {
        width: 100%;
        flex-wrap: wrap;
        gap: 8px;
    }
    .toggle-btn {
        flex: 1;
        min-width: 0;
        padding: 10px 12px;
        font-size: 14px;
    }
    .dropdown-outer {
        width: 100%;
        flex-direction: column;
        gap: 10px;
    }
    .search-input {
        width: 100%;
    }
    .seaarch-pill-outer {
        width: 100%;
        flex-wrap: wrap;
        gap: 10px;
    }
    .search-pill {
        flex: 1 1 100%;
        min-width: 0;
    }
    .search-pill select,
    .search-pill input {
        width: 100% !important;
    }
    .custom-dropdown.bed,
    .custom-dropdown.cat {
        width: 100%;
        min-width: 0;
    }
    .search-card {
        padding: 16px;
    }
    .search-action button {
        width: 100%;
        padding: 12px 20px;
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

<form method="GET" action="{{ route('property.index') }}" id="home-property-search-form">

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
        <button type="submit" id="home-search-submit-btn">
            <i class="fas fa-search"></i> Search Properties
        </button>
    </div>

</form>


        </div>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const homeSearchForm = document.getElementById('home-property-search-form');
    const homeSearchSubmitBtn = document.getElementById('home-search-submit-btn');
    let isSearchSubmitting = false;

    if (!homeSearchForm || !homeSearchSubmitBtn) {
        return;
    }

    homeSearchForm.addEventListener('submit', function () {
        if (isSearchSubmitting) {
            return;
        }

        isSearchSubmitting = true;
        homeSearchSubmitBtn.disabled = true;
        homeSearchSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';

        if (window.AppLoader && typeof window.AppLoader.show === 'function') {
            window.AppLoader.show('Searching properties...');
        }
    });
});

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





    @if(!empty($homeCtaSection))
        <section class="py-4 mt-4" style="background:{{ $homeCtaSection->background_color }};">
            <div class="container text-center">
                <h1 class="fw-bold" style="color:{{ $homeCtaSection->title_color }};">
                    {{ $homeCtaSection->title }}
                </h1>
                @if(!empty($homeCtaSection->description))
                    <p class="mt-3 mb-4" style="color:{{ $homeCtaSection->description_color }}; font-size:18px;">
                        {!! nl2br(e($homeCtaSection->description)) !!}
                    </p>
                @endif
                @if(!empty($homeCtaSection->primary_button_text) && !empty($homeCtaSection->primary_button_url))
                    <a href="{{ $homeCtaSection->primary_button_url }}" class="btn btn-primary me-2 focus-none">
                        {{ $homeCtaSection->primary_button_text }}
                    </a>
                @endif
                @if(!empty($homeCtaSection->secondary_button_text) && !empty($homeCtaSection->secondary_button_url))
                    <a href="{{ $homeCtaSection->secondary_button_url }}" class="btn btn-white border border-success mt-md-0" style="color:{{ $homeCtaSection->secondary_button_color }};">
                        {{ $homeCtaSection->secondary_button_text }}
                    </a>
                @endif
            </div>
        </section>
    @endif


    <!--=================================
        Property Types -->

    <!--=================================
        feature -->

  @if(!empty($homeVerifiedSection))
        <section class="py-5 bg-white">
            <div class="container">
                <h2 class="text-center mb-4" style="color:{{ $homeVerifiedSection->heading_color }};">
                    {{ $homeVerifiedSection->heading }}
                </h2>
                @if(!empty($homeVerifiedSection->intro_text))
                    <p class="text-center mb-5" style="color:{{ $homeVerifiedSection->text_color }};">
                        {!! nl2br(e($homeVerifiedSection->intro_text)) !!}
                    </p>
                @endif

                @php
                    $verifiedCards = is_array($homeVerifiedSection->cards ?? null) ? $homeVerifiedSection->cards : [];
                    if (empty($verifiedCards)) {
                        $verifiedCards = collect([
                            ['title' => $homeVerifiedSection->item_1_title, 'description' => $homeVerifiedSection->item_1_description],
                            ['title' => $homeVerifiedSection->item_2_title, 'description' => $homeVerifiedSection->item_2_description],
                            ['title' => $homeVerifiedSection->item_3_title, 'description' => $homeVerifiedSection->item_3_description],
                            ['title' => $homeVerifiedSection->item_4_title, 'description' => $homeVerifiedSection->item_4_description],
                        ])->filter(function ($card) {
                            return ! empty($card['title']) || ! empty($card['description']);
                        })->values()->all();
                    }
                @endphp

                <div class="row text-center justify-content-center">
                    @foreach($verifiedCards as $card)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex">
                            <div class="p-4 shadow-sm rounded bg-light h-100">
                                <h6 class="fw-bold text-dark">{{ $card['title'] ?? '' }}</h6>
                                <p class="small text-muted">{{ $card['description'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(!empty($homeVerifiedSection->footer_text))
                    <p class="text-center mt-4" style="color:{{ $homeVerifiedSection->heading_color }}; font-weight:600;">
                        {!! nl2br(e($homeVerifiedSection->footer_text)) !!}
                    </p>
                @endif
            </div>
        </section>
    @endif


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
                                        <div class="featured-card-price mb-2">
                                            {{ number_format((float) $property->price) }} AED
                                        </div>
                                        <ul class="featured-card-meta list-unstyled d-flex text-center border-top pt-2 mt-2 mb-0 small">
                                            <li class="flex-fill">
                                                <i class="fas fa-bed featured-meta-icon" aria-hidden="true"></i>
                                                <span class="featured-meta-text">{{ $property->bedrooms !== null && $property->bedrooms !== '' ? $property->bedrooms . ' Bedrooms' : 'N/A' }}</span>
                                            </li>
                                            <li class="flex-fill">
                                                <i class="fas fa-bath featured-meta-icon" aria-hidden="true"></i>
                                                <span class="featured-meta-text">{{ $property->bathrooms !== null && $property->bathrooms !== '' ? $property->bathrooms . ' Bathrooms' : 'N/A' }}</span>
                                            </li>
                                            <li class="flex-fill">
                                                <i class="far fa-square featured-meta-icon" aria-hidden="true"></i>
                                                <span class="featured-meta-text">{{ $property->builtArea ? $property->builtArea . ' sqft' : 'N/A' }}</span>
                                            </li>
                                        </ul>
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
    Developers carousel (from Add Carousel → Section type: Developers carousel) -->
    @if(isset($developers) && $developers->isNotEmpty())
    <section class="space-pb developers-section-block">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-12">
                    <h2 class="mb-0 section-title">{{ isset($developersSection) && $developersSection->title ? $developersSection->title : 'Projects by developers in the UAE' }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 position-relative developers-swiper-wrap">
                    <div class="swiper developers-section-swiper">
                        <div class="swiper-wrapper">
                            @foreach($developers as $dev)
                            <div class="swiper-slide">
                                <a href="{{ url('properties') }}?location={{ urlencode($dev->name) }}" class="text-decoration-none text-dark">
                                    <div class="developer-card rounded-3 shadow-sm border border-light h-100">
                                        <div class="developer-card-logo {{ $dev->logo_dark ? 'developer-card-logo--dark' : '' }}">
                                            <span class="developer-logo-text">{{ $dev->logo_text }}</span>
                                        </div>
                                        <div class="developer-card-info">
                                            <div class="developer-name">{{ $dev->name }}</div>
                                            <div class="developer-projects text-muted">{{ $dev->projects }} projects</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination developers-section-pagination"></div>
                    </div>
                    <div class="swiper-button-prev developers-swiper-prev"></div>
                    <div class="swiper-button-next developers-swiper-next"></div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ url('properties') }}" class="btn developers-cta-btn">All developers in UAE</a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!--=================================
    Image carousel (matches developers carousel design: card with image top, text bottom) -->
    @if(isset($imageCarouselSection) && $imageCarouselSection->images->isNotEmpty())
    <section class="space-pb image-carousel-section-block">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-12">
                    <h2 class="mb-0 section-title image-carousel-heading image-carousel-heading--{{ $imageCarouselSection->heading_placement ?? 'left' }}">{{ $imageCarouselSection->title }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 position-relative image-carousel-swiper-wrap">
                    <div class="swiper image-carousel-swiper">
                        <div class="swiper-wrapper">
                            @foreach($imageCarouselSection->images as $slide)
                            <div class="swiper-slide">
                                @if(!empty($slide->cta_url))
                                    <a href="{{ $slide->cta_url }}" class="text-decoration-none text-dark d-block h-100" target="_blank" rel="noopener">
                                @endif
                                <div class="image-carousel-card rounded-3 shadow-sm border border-light h-100">
                                    <div class="image-carousel-card-image" style="background-color: {{ e($slide->background_color ?? '#ffffff') }};">
                                        <img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->heading ?? '' }}" class="image-carousel-card-img">
                                    </div>
                                    @if(!empty($slide->heading) || !empty($slide->second_heading))
                                    <div class="image-carousel-card-info">
                                        @if($slide->heading_order == 2 && !empty($slide->second_heading))
                                            <div class="image-carousel-card-secondary text-muted">{{ $slide->second_heading }}</div>
                                        @endif
                                        @if(!empty($slide->heading))
                                            <div class="image-carousel-card-title">{{ $slide->heading }}</div>
                                        @endif
                                        @if($slide->heading_order == 1 && !empty($slide->second_heading))
                                            <div class="image-carousel-card-secondary text-muted">{{ $slide->second_heading }}</div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                @if(!empty($slide->cta_url))
                                    </a>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination image-carousel-pagination"></div>
                    </div>
                    <div class="swiper-button-prev image-carousel-prev"></div>
                    <div class="swiper-button-next image-carousel-next"></div>
                </div>
            </div>
        </div>
    </section>
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


@if(!empty($homeWhySection))
<section class="py-5 mb-5" style="background:{{ $homeWhySection->background_color }};">
    <div class="container">
        <h2 class="text-center mb-4" style="color:{{ $homeWhySection->heading_color }};">{{ $homeWhySection->heading }}</h2>
        @php $whyCards = is_array($homeWhySection->cards ?? null) ? $homeWhySection->cards : []; @endphp
        <div class="row justify-content-center">
            @foreach($whyCards as $card)
                <div class="col-lg-4 col-md-6 mb-4 d-flex">
                    <div class="p-4 shadow-sm bg-white rounded h-100 w-100">
                        <h5 class="fw-bold text-dark">{{ $card['title'] ?? '' }}</h5>
                        <p>{{ $card['description'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif





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

@if(!empty($homeSalesSection))
<section class="py-5" style="background:{{ $homeSalesSection->section_background_color }};">
    <div class="container">
        <h2 class="mb-4 text-center" style="color:{{ $homeSalesSection->heading_color }}; font-weight:800; font-size:32px;">
            {{ $homeSalesSection->heading }}
            @if(!empty($homeSalesSection->heading_highlight))
                <span style="color:{{ $homeSalesSection->heading_highlight_color }};">{{ $homeSalesSection->heading_highlight }}</span>
            @endif
        </h2>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="p-4 rounded shadow-sm" style="background:{{ $homeSalesSection->box_background_color }}; border-left:6px solid {{ $homeSalesSection->box_border_color }};">
                    @php $salesSteps = is_array($homeSalesSection->steps ?? null) ? $homeSalesSection->steps : []; @endphp
                    <ol class="ps-3" style="font-size:18px; line-height:1.9; color:#333; list-style: none;">
                        @foreach($salesSteps as $index => $step)
                            <li class="mb-4">
                                <strong style="color:{{ $homeSalesSection->step_title_color }}; font-size:20px;">
                                    {{ $index + 1 }}. {{ $step['title'] ?? '' }}
                                </strong>
                                <br>
                                {{ $step['description'] ?? '' }}
                            </li>
                        @endforeach
                    </ol>
                </div>
                @if(!empty($homeSalesSection->bottom_note) || !empty($homeSalesSection->bottom_note_subtext) || !empty($homeSalesSection->bottom_note_prefix) || !empty($homeSalesSection->bottom_note_highlight) || !empty($homeSalesSection->bottom_note_suffix))
                    <div class="mt-4 text-center p-3 rounded" style="background:#ffffff;">
                        @if(!empty($homeSalesSection->bottom_note_prefix) || !empty($homeSalesSection->bottom_note_highlight) || !empty($homeSalesSection->bottom_note_suffix))
                            <p class="mb-1 fw-bold" style="font-size:16px; color:{{ $homeSalesSection->bottom_note_text_color ?: '#212529' }};">
                                {{ $homeSalesSection->bottom_note_prefix }}
                                <span style="color:{{ $homeSalesSection->bottom_note_highlight_color ?: '#26AE61' }};">
                                    {{ $homeSalesSection->bottom_note_highlight }}
                                </span>
                                {{ $homeSalesSection->bottom_note_suffix }}
                            </p>
                        @elseif(!empty($homeSalesSection->bottom_note))
                            <p class="mb-1 fw-bold" style="font-size:16px; color:{{ $homeSalesSection->bottom_note_text_color ?: '#212529' }};">{{ $homeSalesSection->bottom_note }}</p>
                        @endif
                        @if(!empty($homeSalesSection->bottom_note_subtext))
                            <p class="small text-muted">{{ $homeSalesSection->bottom_note_subtext }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif


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


<style>
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
.featured-section-block .featured-section-swiper-wrap { padding: 0; overflow: hidden; }
.featured-section-block .featured-section-swiper { padding: 0 0 48px; position: relative; }
.share-anchor-target {
    scroll-margin-top: 110px;
}
.section-share-anchor {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-left: 10px;
    padding: 3px 8px;
    border-radius: 999px;
    border: 1px solid #d7e9dd;
    background: #f8fffb;
    color: #26ae61;
    font-size: 12px;
    font-weight: 600;
    line-height: 1;
    vertical-align: middle;
    text-decoration: none;
    white-space: nowrap;
}
.section-share-anchor:hover {
    background: #26ae61;
    border-color: #26ae61;
    color: #fff;
    text-decoration: none;
}
.section-share-anchor.copied {
    background: #26ae61;
    border-color: #26ae61;
    color: #fff;
}
@media (max-width: 768px) {
  .featured-section-block .featured-section-swiper-wrap { padding: 0 0 40px; }
  .featured-section-block .section-title h2 { font-size: 20px; }
  .section-share-anchor {
      margin-left: 6px;
      font-size: 11px;
      padding: 3px 6px;
  }
}
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
.featured-section-block .featured-card-price {
    font-size: 1rem;
    font-weight: 700;
    color: #26ae61;
}
.featured-section-block .featured-card-meta {
    gap: 0;
    align-items: stretch;
}
.featured-section-block .featured-card-meta li {
    min-width: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 2px 6px;
}
.featured-section-block .featured-card-meta li + li {
    border-left: 1px solid #eef1f3;
}
.featured-section-block .featured-meta-icon {
    font-size: 16px;
    color: #7b8794;
    width: 18px;
    text-align: center;
    flex: 0 0 18px;
}
.featured-section-block .featured-card-meta li span {
    display: inline-block;
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 12px;
    color: #6c757d;
    line-height: 1.2;
    font-weight: 500;
}
@media (max-width: 768px) {
    .featured-section-block .featured-card-meta li {
        gap: 3px;
        padding: 2px 4px;
    }
    .featured-section-block .featured-meta-icon {
        font-size: 14px;
        width: 16px;
        flex-basis: 16px;
    }
    .featured-section-block .featured-card-meta li span {
        font-size: 11px;
    }
}

/* Developers section – card design (logo + name + projects) */
.developers-section-block .section-title { color: #333; font-weight: 700; }
.developers-swiper-wrap { padding: 0; position: relative; }
.developers-section-block .developers-section-swiper { padding-bottom: 52px; position: relative; }
.developer-card { background: #fff; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow 0.2s; }
.developer-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important; }
.developer-card-logo {
    min-height: 100px; display: flex; align-items: center; justify-content: center; padding: 24px 16px;
    background: #fff; border-bottom: 1px solid #f0f0f0;
}
.developer-logo-text { font-size: 1.25rem; font-weight: 700; letter-spacing: 0.02em; color: #333; }
.developer-card-logo--dark { background: #1e3a5f !important; border-bottom-color: #1e3a5f; }
.developer-card-logo--dark .developer-logo-text { color: #fff; }
.developer-card-info { padding: 16px; flex: 1; }
.developer-name { font-weight: 600; font-size: 0.95rem; color: #333; margin-bottom: 4px; }
.developer-projects { font-size: 0.85rem; color: #6c757d; }
.developers-cta-btn {
    background: #eef0f7; color: #4A225B; border: none; padding: 10px 24px; border-radius: 8px;
    font-weight: 600; text-decoration: none; display: inline-block; transition: background 0.2s, color 0.2s;
}
.developers-cta-btn:hover { background: #4A225B; color: #fff; }
/* Developers carousel arrows – same as banner carousel */
.developers-section-block .swiper-button-prev,
.developers-section-block .swiper-button-next {
    width: 44px; height: 44px; margin-top: 0;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    border-radius: 50%;
    border: none;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    --swiper-navigation-size: 18px;
    top: 50%;
    transform: translateY(-50%);
    transition: background 0.2s ease, box-shadow 0.2s ease;
}
.developers-section-block .swiper-button-prev { left: 16px; right: auto; }
.developers-section-block .swiper-button-next { right: 16px; left: auto; }
.developers-section-block .swiper-button-prev::after,
.developers-section-block .swiper-button-next::after { font-size: 18px; font-weight: 700; }
.developers-section-block .swiper-button-prev:hover,
.developers-section-block .swiper-button-next:hover {
    background: #fff;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}
/* Developers dots – below cards with gap, not overlaid */
.developers-section-block .developers-section-pagination {
    position: absolute; bottom: 0; left: 0; width: 100%;
    text-align: center; padding-top: 20px; margin-top: 0;
    pointer-events: none;
}
.developers-section-block .developers-section-pagination .swiper-pagination-bullet {
    pointer-events: auto;
    width: 10px; height: 10px; background: #dee2e6; opacity: 1;
    transition: background 0.2s, transform 0.2s;
}
.developers-section-block .developers-section-pagination .swiper-pagination-bullet-active {
    background: #26ae61; transform: scale(1.2);
}
@media (max-width: 768px) {
    .developers-section-block .developers-section-swiper { padding-bottom: 48px; }
    .developer-card-logo { min-height: 80px; padding: 16px; }
    .developer-logo-text { font-size: 1rem; }
}

/* Image carousel section – match developers carousel (card: image top, text bottom) */
.image-carousel-section-block .section-title { color: #333; font-weight: 700; }
.image-carousel-section-block .image-carousel-heading--left { text-align: left; }
.image-carousel-section-block .image-carousel-heading--center { text-align: center; }
.image-carousel-section-block .image-carousel-heading--right { text-align: right; }
.image-carousel-swiper-wrap { padding: 0; position: relative; }
.image-carousel-section-block .image-carousel-swiper { padding-bottom: 52px; position: relative; }
.image-carousel-card {
    background: #fff;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s;
}
.image-carousel-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important; }
.image-carousel-card-image {
    min-height: 100px;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    overflow: hidden;
}
.image-carousel-card-img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    object-position: center;
    display: block;
}
.image-carousel-card-info { padding: 16px; flex: 1; }
.image-carousel-card-title { font-weight: 600; font-size: 0.95rem; color: #333; margin-bottom: 4px; }
.image-carousel-card-secondary { font-size: 0.85rem; color: #6c757d; }
.image-carousel-section-block .swiper-button-prev,
.image-carousel-section-block .swiper-button-next {
    width: 44px; height: 44px; margin-top: 0;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    border-radius: 50%;
    border: none;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    --swiper-navigation-size: 18px;
    top: 50%;
    transform: translateY(-50%);
    transition: background 0.2s ease, box-shadow 0.2s ease;
}
.image-carousel-section-block .swiper-button-prev { left: 16px; right: auto; }
.image-carousel-section-block .swiper-button-next { right: 16px; left: auto; }
.image-carousel-section-block .swiper-button-prev::after,
.image-carousel-section-block .swiper-button-next::after { font-size: 18px; font-weight: 700; }
.image-carousel-section-block .swiper-button-prev:hover,
.image-carousel-section-block .swiper-button-next:hover {
    background: #fff;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}
.image-carousel-section-block .image-carousel-pagination {
    position: absolute; bottom: 0; left: 0; width: 100%;
    text-align: center; padding-top: 20px; margin-top: 0;
    pointer-events: none;
}
.image-carousel-section-block .image-carousel-pagination .swiper-pagination-bullet {
    pointer-events: auto;
    width: 10px; height: 10px; background: #dee2e6; opacity: 1;
    transition: background 0.2s, transform 0.2s;
}
.image-carousel-section-block .image-carousel-pagination .swiper-pagination-bullet-active {
    background: #26ae61; transform: scale(1.2);
}
@media (max-width: 768px) {
    .image-carousel-section-block .image-carousel-swiper { padding-bottom: 48px; }
    .image-carousel-card-image { min-height: 80px; height: 120px; }
    .image-carousel-card-info { padding: 12px; }
    .image-carousel-card-title { font-size: 0.9rem; }
}
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
        document.querySelectorAll('.developers-section-swiper').forEach(function(el) {
            if (el.swiper) return;
            var wrap = el.closest('.developers-swiper-wrap');
            new Swiper(el, {
                slidesPerView: 1.5,
                spaceBetween: 16,
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
                navigation: {
                    nextEl: wrap ? wrap.querySelector('.swiper-button-next') : null,
                    prevEl: wrap ? wrap.querySelector('.swiper-button-prev') : null
                },
                breakpoints: {
                    576: { slidesPerView: 2.5 },
                    768: { slidesPerView: 3.5 },
                    992: { slidesPerView: 4.5 }
                }
            });
        });
        document.querySelectorAll('.image-carousel-swiper').forEach(function(el) {
            if (el.swiper) return;
            var wrap = el.closest('.image-carousel-swiper-wrap');
            new Swiper(el, {
                slidesPerView: 1.2,
                spaceBetween: 16,
                loop: true,
                autoplay: { delay: 4500, disableOnInteraction: false },
                pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
                navigation: {
                    nextEl: wrap ? wrap.querySelector('.swiper-button-next') : null,
                    prevEl: wrap ? wrap.querySelector('.swiper-button-prev') : null
                },
                breakpoints: {
                    576: { slidesPerView: 2 },
                    768: { slidesPerView: 2.5 },
                    992: { slidesPerView: 3.5 }
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
<script>
(function() {
    function showCopiedState(linkEl) {
        if (!linkEl) return;
        var span = linkEl.querySelector('span');
        if (!span) return;

        var originalText = linkEl.getAttribute('data-original-text') || span.textContent;
        linkEl.setAttribute('data-original-text', originalText);
        span.textContent = 'Link Copied';
        linkEl.classList.add('copied');

        clearTimeout(linkEl.__copyTimer);
        linkEl.__copyTimer = setTimeout(function() {
            span.textContent = originalText;
            linkEl.classList.remove('copied');
        }, 1400);
    }

    function scrollToHashSection() {
        if (!window.location.hash) return;
        var id = window.location.hash.slice(1);
        if (!id) return;

        var section = document.getElementById(id);
        if (!section) return;

        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function slugifySectionTitle(text) {
        return String(text || '')
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
    }

    function buildSectionShareLinks() {
        // Remove any previously injected share links (so Share appears only where allowed)
        document.querySelectorAll('.section-share-anchor').forEach(function(el) {
            el.remove();
        });

        var usedIds = new Set(Array.from(document.querySelectorAll('[id]')).map(function(el) { return el.id; }));
        // Only allow Share links on admin-created carousel sections
        var sections = document.querySelectorAll(
            'section.featured-section-block, section.developers-section-block, section.image-carousel-section-block'
        );

        sections.forEach(function(section, index) {
            if (section.classList.contains('d-none')) return;

            var heading = section.querySelector('.section-title h2, .section-title h1, h2, h1, h3');
            if (!heading) return;
            if (heading.querySelector('.section-share-anchor')) return;

            if (!section.id) {
                var baseId = slugifySectionTitle(heading.textContent) || ('section-' + (index + 1));
                var finalId = baseId;
                var counter = 2;
                while (usedIds.has(finalId)) {
                    finalId = baseId + '-' + counter++;
                }
                section.id = finalId;
                usedIds.add(finalId);
            }

            section.classList.add('share-anchor-target');

            var shareLink = document.createElement('a');
            shareLink.className = 'section-share-anchor';
            shareLink.href = '#' + section.id;
            shareLink.setAttribute('aria-label', 'Share link to this section');
            shareLink.innerHTML = '<i class="fas fa-link" aria-hidden="true"></i><span>Share</span>';

            shareLink.addEventListener('click', function() {
                var shareUrl = window.location.origin + window.location.pathname + window.location.search + '#' + section.id;
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(shareUrl)
                        .then(function() {
                            showCopiedState(shareLink);
                        })
                        .catch(function() {
                            showCopiedState(shareLink);
                        });
                } else {
                    showCopiedState(shareLink);
                }
            });

            heading.appendChild(shareLink);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            buildSectionShareLinks();
            setTimeout(scrollToHashSection, 0);
        });
    } else {
        buildSectionShareLinks();
        setTimeout(scrollToHashSection, 0);
    }

    window.addEventListener('hashchange', scrollToHashSection);
})();
</script>
@endpush

@endsection
