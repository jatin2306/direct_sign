@extends('layouts.home')

@section('content')    


<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css"/>

<!-- intl-tel-input JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>


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
                  <a href="{{ url(implode('/', array_slice(Request::segments(), 0, $loop->index + 1))) }}">
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
                <a class="btn btn-primary btn-md" href="{{ route('add.listing') }}"> <i class="fa fa-plus-circle"></i>Add Property </a>
              </div>
             
            </div>
<!-- 
<a href="{{ route('add.listing') }}" class="btn btn-success mb-2">
    + Add Listing
</a>

<a href="{{ route('my.listings') }}" class="btn btn-outline-primary mb-2">
    My Listings
</a>
 -->

            <div class="profile-nav">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link active" href="{{ route('dashboard') }}"><i class="far fa-user"></i> Edit Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('properties.my') }}"><i class="far fa-bell"></i>My properties</a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('properties.saved') }}"><i class="fas fa-home"></i> Saved Properties</a>
                </li>
               
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('user.transactions') }}"><i class="far fa-edit"></i> Transactions</a>
                </li>
                <li class="nav-item">
                  <!-- Hidden Logout Form -->
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                  <!-- Logout Link -->
                  <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='fas fa-sign-out-alt'></i> Log Out
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <style>

input#phone_number::placeholder {
    color: #80808099;
}
          #toggle-password-fields {
    padding: 10px 16px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.3s ease;
}

#toggle-password-fields:hover {
    background-color: #ffc107;
    color: #000;
}

#password-fields {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Button Focus Fix */
#toggle-password-fields:focus, 
#toggle-password-fields:active {
    background-color: #ffc107 !important;
    color: #000 !important;
    border-color: #ffc107 !important;
    box-shadow: none !important;
}

/* Modal Improvements */
.modal-content {
    border-radius: 8px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

        </style>  
        <div class="col-12">
          <div class="section-title d-flex align-items-center">
            <h2>Edit profile </h2>
            <span class="ms-auto">Joined {{ auth()->user()->created_at->format('M d, Y') }}</span>
          </div>
          @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
        
            <div class="row">
                <!-- Name Field -->
                <div class="form-group col-md-6 mb-3">
                    <label class="mb-2">User Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
        
                <!-- Email Field (Read-only) -->
                <div class="form-group col-md-6 mb-3">
                    <label class="mb-2">Email Address</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                </div>
        
                <!-- Phone Number Field -->
                <!-- <div class="form-group col-md-6 mb-3">
                    <label class="mb-2">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', auth()->user()->phone_number) }}" required>
                    @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div> -->
        
<!-- Phone Number Field -->
<div class="form-group col-md-6 mb-3">
  <label class="mb-2 d-block">Phone Number</label>
  <input 
    type="tel" 
    id="phone_number" 
    name="phone_number" 
    class="form-control" 
    value="{{ old('phone_number', auth()->user()->phone_number) }}" 
    required 
    pattern="[0-9\s]{6,20}" 
    title="Enter a valid phone number (6–15 digits)"
  >
  <input type="hidden" name="full_phone_number" id="full_phone_number">
  @error('phone_number') 
    <span class="text-danger">{{ $message }}</span> 
  @enderror
</div>


                <!-- Change Password Button (Aligned with Inputs) -->
                <div class="form-group col-md-6 mb-3 d-flex align-items-end">
                    <button type="button" id="toggle-password-fields" class="btn btn-outline-warning w-100">
                        <i class="fas fa-lock me-1"></i> Change Password
                    </button>
                </div>
            </div>
        
            <!-- Password Fields (Initially Hidden) -->
            <div id="password-fields" class="row d-none">
                <!-- New Password Field -->
                <div class="form-group col-md-6 mb-3">
                    <label class="mb-2">New Password</label>
                    <div class="input-group">
                        <input type="password" id="new-password" name="password" class="form-control" placeholder="Leave blank if unchanged">
                        <span class="input-group-text">
                            <a href="#" onclick="togglePasswordVisibility(event)" data-target="new-password">
                                <i class="fa fa-eye"></i>
                            </a>
                        </span>
                    </div>
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
        
                <!-- Confirm Password Field -->
                <div class="form-group col-md-6 mb-3">
                    <label class="mb-2">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" id="password-confirmation" name="password_confirmation" class="form-control" placeholder="Confirm your new password">
                        <span class="input-group-text">
                            <a href="#" onclick="togglePasswordVisibility(event)" data-target="password-confirmation">
                                <i class="fa fa-eye"></i>
                            </a>
                        </span>
                    </div>
                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        
            <!-- Save Changes Button (Opens Modal) -->
            <div class="col-md-12 d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#passwordModal">
                    Save Changes
                </button>
            </div>
        
            <!-- Password Confirmation Modal -->
            <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="passwordModalLabel">Confirm Changes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Please enter your current password to confirm the changes.</p>
        
                            <!-- Current Password Field Inside Modal -->
                            <div class="form-group mb-3">
                                <label class="mb-2">Current Password</label>
                                <div class="input-group">
                                    <input type="password" id="current-password" name="current_password" class="form-control" placeholder="Enter your current password" required>
                                    <span class="input-group-text">
                                        <a href="#" onclick="togglePasswordVisibility(event)" data-target="current-password">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </span>
                                </div>
                                @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm & Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
             
        
          <hr class="my-5" />
          
          <div class="mb-2">
            <h6>Delete Account?</h6>
            <p>This will remove your login information from our system, and you will not be able to login again. It cannot be undone.</p>
            <a class="btn btn-danger" href="#">Yes Delete My Account</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  My profile -->



<script>
document.addEventListener('DOMContentLoaded', function() {
  const input = document.querySelector("#phone_number");

  // Initialize intl-tel-input
  const iti = window.intlTelInput(input, {
    initialCountry: "ae", // Default UAE
    separateDialCode: true, // Show +971 separately
    preferredCountries: ["ae", "in", "us", "gb"],
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    geoIpLookup: function(callback) {
      fetch("https://ipapi.co/json")
        .then(res => res.json())
        .then(data => callback(data.country_code ? data.country_code.toLowerCase() : "ae"))
        .catch(() => callback("ae"));
    }
  });
  
  // Allow only digits
  input.addEventListener("keypress", function (e) {
    const char = String.fromCharCode(e.which);
    if (!/[0-9\s]/.test(char)) {
      e.preventDefault();
    }
  });

  // Strip non-digits if pasted
  input.addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9\s]/g, "");
  });

  // On form submit, validate
  const form = input.closest('form');
  form.addEventListener('submit', function(e) {
    const fullNumber = iti.getNumber(); // +971501234567

    if (!iti.isValidNumber()) {
      e.preventDefault();
      alert("⚠️ Please enter a valid phone number.");
      return false;
    }

    document.querySelector("#full_phone_number").value = fullNumber;
  });
});
</script>


@endsection

