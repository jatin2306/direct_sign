@extends('admin.layouts.app')
@section('title', 'Add Admin User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add Admin User</h4>
        <a href="{{ route('admin.admin-users.index') }}" class="btn btn-secondary">Back to Admin Users</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.admin-users.store') }}" method="POST" class="card shadow-sm">
        @csrf
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_super_admin" value="1" id="is_super_admin" {{ old('is_super_admin') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_super_admin">Super Admin (full access to all pages and actions)</label>
                    </div>
                </div>
            </div>

            <h6 class="border-bottom pb-2 mb-3">Permissions (ignored if Super Admin is checked)</h6>
            <div class="row g-3">
                @foreach($permissionConfig as $resource => $config)
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body py-2">
                            <strong class="d-block mb-2">{{ $config['label'] }}</strong>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($config['actions'] as $action)
                                @php $perm = $resource . '.' . $action; @endphp
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm }}" id="perm_{{ $perm }}" {{ in_array($perm, old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $perm }}">{{ \App\Support\AdminPermission::actionLabel($action) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary">Create Admin User</button>
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
