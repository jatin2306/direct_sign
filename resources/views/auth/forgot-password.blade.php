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
            <a href="{{ url('') }}"></a>
          </li>
          <li class="breadcrumb-item active">
            <i class="fas fa-chevron-right"></i> 
            <span>Forgot Password</span>
          </li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--=================================
Breadcrumb -->

<!--=================================
Forgot Password -->
<section class="space-ptb login">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-sm-10">
        <div class="section-title">
          <h2 class="text-center">Forgot Password</h2>
        </div>

        <ul class="nav nav-tabs nav-tabs-02 justify-content-center" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="reset-tab" data-bs-toggle="tab" href="#reset" role="tab" aria-controls="reset" aria-selected="true">
              Reset Your Password
            </a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="reset" role="tabpanel" aria-labelledby="reset-tab">

            {{-- Success Message --}}
            @if (session('status'))
              <div class="alert alert-success mt-3">
                {{ session('status') }}
              </div>
            @endif

            {{-- Error Message --}}
            @if ($errors->any())
              <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form class="row mt-4 align-items-center" method="POST" action="{{ route('password.email') }}">
              @csrf

              <div class="mb-3 col-sm-12">
                <label class="form-label" for="email">Email Address:</label>
                <input 
                  type="email" 
                  id="email" 
                  class="form-control" 
                  name="email" 
                  value="{{ old('email') }}" 
                  required 
                  autofocus 
                  placeholder="Enter your registered email address">
              </div>

              <div class="col-sm-12 d-grid mt-3">
                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
              </div>

              <div class="col-sm-12 text-center mt-3">
                <a href="{{ route('login') }}" class="text-success">
                  <i class="fas fa-arrow-left"></i> Back to Login
                </a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
Forgot Password -->

@endsection
