
@extends('layouts.home')

@section('content')

<!--=================================
Breadcrumb -->
<div class="bg-light">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
              <i class="fa fa-home"></i>
              <a href="{{url('')}}"></a>
          </li>
       
          @for($i = 2; $i <= count(Request::segments()); $i++)
             <li class="breadcrumb-item active"> <i class="fas fa-chevron-right"></i>
              <span>
                <a href="{{ URL::to( implode( '/', array_slice(Request::segments(), 0 ,$i, true)))}}">
                   {{strtoupper(Request::segment($i))}}
                </a>
              </span>  
             </li>
          @endfor
       </ol>
      </div>
    </div>
  </div>
</div>
<!--=================================
Breadcrumb -->

<!--=================================
Login -->
<section class="space-ptb login">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-sm-10">
        <div class="section-title">
          <h2 class="text-center">Admin Registration</h2>
        </div>
        <ul class="nav nav-tabs nav-tabs-02 justify-content-center" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="agent-tab" data-bs-toggle="tab" href="#agent" role="tab" aria-controls="agent" aria-selected="false">Direct Deal Admin</a>
          </li>
          
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="agent" role="tabpanel" aria-labelledby="agent-tab">
            
            <form class="row mt-4 align-items-center" method="POST" action="{{ route('admin.register') }}">
              @csrf
             <div class="mb-3 col-sm-12">
                <label class="form-label">Username:</label>
                <input  class="form-control" type="text" id="name" name="name" :value="old('name')" required autofocus autocomplete="name">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
              </div>
              <div class="mb-3 col-sm-12">
                <label class="form-label" for="email">Email Address:</label>
                <input id="email" type="email" class="form-control" name="email" :value="old('email')" required autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>
              <div class="mb-3 col-sm-12">
                <label class="form-label" for="password">Password:</label>
                <input type="Password" id="password" class="form-control" name="password" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
              <div class="mb-3 col-sm-12">
                <label class="form-label" for="password_confirmation">Confirm Password:</label>
                <input type="Password" id="password_confirmation" class="form-control" name="password_confirmation" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
              </div>
              <div class="col-sm-6 d-grid">
                <button type="submit" class="btn btn-primary">Sign up</button>
              </div>
              <div class="col-sm-6">
                <ul class="list-unstyled d-flex mb-1 mt-sm-0 mt-3">
                  <li class="me-1"><a href="{{ route('admin.login') }}">Already Registered User? Click here to login</a></li>
                </ul>
              </div>
            </form>

          </div>

        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
Login -->

@endsection