
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
          <h2 class="text-center">Admin Login</h2>
        </div>
        <ul class="nav nav-tabs nav-tabs-02 justify-content-center" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="agent-tab" data-bs-toggle="tab" href="#agent" role="tab" aria-controls="agent" aria-selected="false">Welcome to Direct Deal</a>
          </li>
          
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="agent" role="tabpanel" aria-labelledby="agent-tab">
            <form class="row mt-4 align-items-center" method="POST" action="{{ route('admin.login') }}">
              @csrf
              <div class="mb-3 col-sm-12">
                <label class="form-label" for="email">Email Address:</label>
                <input type="email" id="email" class="form-control" name="email" :value="old('email')" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>
              <div class="mb-3 col-sm-12">
                <label class="form-label" for="password">Password:</label>
                <input type="Password" id="password" class="form-control" name="password"
                required autocomplete="current-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
              
              <div class="mb-3 col-sm-12">
                <label for="remember_me" class="inline-flex items-center">
                  <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                  <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
              </label>
              </div>

              <div class="col-sm-6 d-grid">
                <button type="submit" class="btn btn-primary">Sign in</button>
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