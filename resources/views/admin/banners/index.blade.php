@extends('admin.layouts.app')

@section('title', 'Banners')

@section('content')
@php $showBannerActions = admin_can('banners.edit') || admin_can('banners.delete'); @endphp
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Homepage Banners</h4>
        @if(admin_can('banners.create'))
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i> Add Banner</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Heading</th>
                        <th>Sub heading</th>
                        <th>CTA</th>
                        <th>Placement</th>
                        <th>Order</th>
                        <th>Active</th>
                        @if($showBannerActions)<th>Actions</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $index => $banner)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($banner->image)
                                    <img src="{{ $banner->image_url }}" alt="" class="rounded" style="max-height: 50px; max-width: 120px; object-fit: cover;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($banner->heading, 30) ?: '—' }}</td>
                            <td>{{ Str::limit($banner->sub_heading, 30) ?: '—' }}</td>
                            <td>
                                @if($banner->cta_text)
                                    <span class="badge bg-secondary">{{ $banner->cta_text }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td><span class="badge bg-info text-capitalize">{{ $banner->text_placement ?? 'left' }}</span></td>
                            <td>{{ $banner->sort_order }}</td>
                            <td>
                                @if($banner->is_active)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            @if($showBannerActions)
                            <td>
                                @if(admin_can('banners.edit'))
                                <a href="{{ url('admin/banners/' . $banner->id . '/edit') }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                @endif
                                @if(admin_can('banners.delete'))
                                <form action="{{ url('admin/banners/' . $banner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                                @endif
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $showBannerActions ? 9 : 8 }}" class="text-center text-muted py-4">No banners yet.@if(admin_can('banners.create')) <a href="{{ route('admin.banners.create') }}">Add one</a>@endif</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
