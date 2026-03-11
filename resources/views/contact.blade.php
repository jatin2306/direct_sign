
@extends('layouts.home')

@section('title', 'Contact Direct Deal UAE | Dubai Real Estate Experts')
@section('meta_description', 'Get in touch with Direct Deal UAE for property buying, selling or renting assistance. Speak with Dubai real estate experts today.')

@section('content')
<!--=================================
breadcrumb -->
<div class="bg-light">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fas fa-home"></i> </a></li>
          <li class="breadcrumb-item"> <i class="fas fa-chevron-right"></i> <a href="#">Pages</a></li>
          <li class="breadcrumb-item active"> <i class="fas fa-chevron-right"></i> <span> Contact us </span></li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--=================================
breadcrumb -->

<!--=================================
Contact -->
<section class="space-ptb">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2>Contact Us</h2>
        </div>
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-lg-5">
        <div class="contact-address bg-light p-4">
          <div class="d-flex mb-3">
            <div class="contact-address-icon">
              <i class="flaticon-map text-primary font-xlll"></i>
            </div>
            <div class="ms-3">
              <h6>Address</h6>
              <p>Dubai Investment Park, Dubai</p>
            </div>
          </div>
          <div class="d-flex mb-3">
            <div class="contact-address-icon">
              <i class="flaticon-email text-primary font-xlll"></i>
            </div>
            <div class="ms-3">
              <h6>Email</h6>
              <p><a href="mailto:info@directdealuae.com">info@directdealuae.com</a></p>
            </div>
          </div>
          <div class="d-flex mb-3">
            <div class="contact-address-icon">
              <i class="flaticon-call text-primary font-xlll"></i>
            </div>
            <div class="ms-3">
              <h6>Phone Number</h6>
              <p><a href="tel:+971581144230">+971581144230</a></p>
            </div>
          </div>
         
          <div class="social-icon-02">
            <div class="d-flex align-items-center">
              <h6 class="me-3">Follow us:</h6>
              <ul class="list-unstyled mb-0 list-inline">
                <li class="list-inline-item"><a href="https://www.facebook.com/share/1GYi1wEoKn/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li class="list-inline-item"><a href="https://x.com/directdealuae" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"><i class="fab fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="https://www.linkedin.com/company/direct-deal-llc/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a></li>
                <li class="list-inline-item"><a href="https://www.instagram.com/directdealuae?igsh=MTh0dW9sdHNzN2kzYg%3D%3D&utm_source=qr" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7 mt-4 mt-lg-0">
        <div class="contact-form">
          <h4 class="mb-4">Need assistance? Please complete the contact form</h4>
          <form>
            <div class="row">
              <div class="mb-3 col-md-6">
                <input type="text" class="form-control" id="name" placeholder="Your name">
              </div>
              <div class="mb-3 col-md-6">
                <input type="email" class="form-control" id="inputEmail4" placeholder="Your email">
              </div>
              <div class="mb-3 col-md-6">
                <input type="text" class="form-control" id="phone" placeholder="Your phone">
              </div>
              <div class="mb-3 col-md-6">
                <input type="text" class="form-control" id="subject" placeholder="Subject">
              </div>
              <div class="mb-3 col-md-12">
                <textarea class="form-control" rows="4" placeholder="Your message"></textarea>
              </div>
              <div class="mb-3 col-md-12">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label pe-5" for="flexCheckDefault">
                 I consent to having this website store my submitted information so they can respond to my inquiry.
                </label>
              </div>
              </div>
              <div class="col-md-12">
                <a class="btn btn-primary" href="#">Send message</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row mt-1 mt-md-2">
      <div class="col-12">
        <h4 class="mb-4 my-4 my-sm-5">Additional contact Info</h4>
      </div>
      <div class="col-md-4">
        <div class="d-flex">
          <i class="flaticon-time-call font-xlll text-primary"></i>
          <div class="ms-4">
            <h5>Estate agency offices</h5>
            <p>Our Estate Agency offices can help with you buying or selling a home.</p>
            <a href="#">Click to contact an estate agency branch</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mt-4 mt-md-0">
        <div class="d-flex">
          <i class="flaticon-email-1 font-xlll text-primary"></i>
          <div class="ms-4">
            <h5>Lettings offices</h5>
            <p>Our Lettings offices can assist with you letting your home, protection and moving home.</p>
            <a href="#">Click to contact a lettings branch</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mt-4 mt-md-0">
        <div class="d-flex">
          <i class="flaticon-group font-xlll text-primary"></i>
          <div class="ms-4">
            <h5>Chat to us online</h5>
            <p class="mb-0">Chat to us online if you have a question about using our Mortgage calculator.</p>
            <a class="btn btn-primary btn-sm mt-3" href="#"> Start web chat</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
Contact -->

@endsection