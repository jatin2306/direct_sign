
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
          <li class="breadcrumb-item"> <i class="fas fa-chevron-right"></i> <a href="#">Pages</a></li>
          <li class="breadcrumb-item active"> <i class="fas fa-chevron-right"></i> <span> About us </span></li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--=================================
breadcrumb -->

<!--=================================
error -->
<section class="space-ptb bg-holder">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6">
        <div class="error-404">
          <h1>404</h1>
          <strong>Oops – no one seems to be home.</strong>
          <span>In the meantime try a <a href="{{ route('home') }}"> search for homes </a></span>
        </div>
      </div>
      <div class="col-md-6 text-center mt-5 mt-md-0 position-relative overflow-hidden">
         <img class="img-fluid house-animation" src="{{ asset('images/error/01.png')}}" alt="">
         <img class="img-fluid cloud cloud-01" src="{{ asset('images/error/cloud-01.png')}}" alt="">
         <img class="img-fluid cloud cloud-02" src="{{ asset('images/error/cloud-02.png')}}" alt="">
         <img class="img-fluid cloud cloud-03" src="{{ asset('images/error/cloud-03.png')}}" alt="">
         <img class="img-fluid cloud cloud-04" src="{{ asset('images/error/cloud-04.png')}}" alt="">
         <img class="img-fluid mt-5" src="{{ asset('images/error/02.png')}}" alt="">
      </div>
    </div>
  </div>
</section>
<!--=================================
error -->

@endsection