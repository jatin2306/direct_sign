@extends('admin.layouts.app')
@section('title', 'Edit Admin User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Admin User</h4>
        <a href="{{ route('admin.admin-users.index') }}" class="btn btn-secondary">Back to Admin Users</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.admin-users.update', $adminUser->id) }}" method="POST" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $adminUser->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    @if(!empty($isProtected))
                        <input type="text" class="form-control bg-light" value="{{ $adminUser->email }}" readonly>
                        <input type="hidden" name="email" value="{{ $adminUser->email }}">
                    @else
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $adminUser->email) }}" required>
                    @endif
                </div>
            </div>

            <h6 class="border-bottom pb-2 mb-3 mt-4">Change password</h6>
            <p class="text-muted small mb-3">Leave both fields blank to keep the current password. Otherwise enter a new password and confirm it.</p>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" placeholder="Leave blank to keep current">
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Same as above if changing">
                </div>
                @if(empty($isProtected) && Auth::guard('admin')->user()->is_super_admin)
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_super_admin" value="1" id="is_super_admin" {{ old('is_super_admin', $adminUser->is_super_admin) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_super_admin">Super Admin (full access to all pages and actions)</label>
                    </div>
                </div>
                @endif
            </div>

            @if(empty($isProtected) && Auth::guard('admin')->user()->is_super_admin)
            <h6 class="border-bottom pb-2 mb-3">Permissions (ignored if Super Admin is checked)</h6>
            <div class="row g-3">
                @php $currentPerms = old('permissions', $adminUser->permissions ?? []); @endphp
                @foreach($permissionConfig as $resource => $config)
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body py-2">
                            <strong class="d-block mb-2">{{ $config['label'] }}</strong>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($config['actions'] as $action)
                                @php $perm = $resource . '.' . $action; @endphp
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm }}" id="perm_{{ $perm }}" {{ in_array($perm, $currentPerms) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $perm }}">{{ \App\Support\AdminPermission::actionLabel($action) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @elseif(empty($isProtected))
            <p class="text-muted">Only a super admin can change permissions for this user.</p>
            @endif

            <hr class="my-4">
            <button type="submit" class="btn btn-primary">Update Admin User</button>
            <a href="{{ route('admin.admin-users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    var superAdminCb = document.getElementById('is_super_admin');

    function getResource(val) {
        if (!val || val.indexOf('.') === -1) return null;
        return val.split('.')[0];
    }

    function isViewPerm(val) {
        return val && val.endsWith('.view');
    }

    // When Super Admin is checked, select all permissions; when unchecked, clear all
    if (superAdminCb) {
        superAdminCb.addEventListener('change', function() {
            checkboxes.forEach(function(cb) {
                cb.checked = superAdminCb.checked;
            });
        });
    }

    if (!checkboxes.length) return;

    checkboxes.forEach(function(cb) {
        cb.addEventListener('change', function() {
            var val = this.value || '';
            var resource = getResource(val);

            if (this.checked) {
                if (!isViewPerm(val) && resource) {
                    var viewCb = document.getElementById('perm_' + resource + '.view');
                    if (viewCb && !viewCb.checked) {
                        viewCb.checked = true;
                    }
                }
            } else {
                if (isViewPerm(val) && resource) {
                    var viewPrefix = resource + '.';
                    checkboxes.forEach(function(other) {
                        var otherVal = other.value || '';
                        if (otherVal.startsWith(viewPrefix) && otherVal !== resource + '.view') {
                            other.checked = false;
                        }
                    });
                }
            }
        });
    });
});
</script>
@endpush
@endsection
