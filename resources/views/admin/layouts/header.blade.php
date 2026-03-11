<!-- resources/views/admin/layouts/header.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm px-4 py-3">
  <div class="container-fluid">
    <span class="navbar-brand h5 mb-0">Admin Panel</span>

    <ul class="navbar-nav ms-auto align-items-center">
      <li class="nav-item me-3">
        <span class="text-muted md">Welcome,</span>
        @if(Auth::guard('admin')->check())
    <strong style="color: #26ae61 !important;"
    >{{ Auth::guard('admin')->user()->name }}</strong>
@else
    <strong style="color: #26ae61 !important;"
    >Guest Admin</strong>
@endif

      </li>
      <li class="nav-item">
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="fa fa-sign-out-alt me-1"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </div>
</nav>
