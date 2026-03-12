@extends('admin.layouts.app')

@section('title', 'Developers Carousel')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Projects by developers (homepage carousel)</h4>
        <a href="{{ route('admin.developers.create') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i> Add developer</a>
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
                        <th>Name</th>
                        <th>Logo text</th>
                        <th>Dark style</th>
                        <th>Search slug</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($developers as $index => $dev)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $dev->name }}</td>
                            <td><code>{{ $dev->logo_text ?: '—' }}</code></td>
                            <td>
                                @if($dev->logo_dark)
                                    <span class="badge bg-dark">Dark</span>
                                @else
                                    <span class="badge bg-light text-dark">Light</span>
                                @endif
                            </td>
                            <td><code>{{ $dev->search_slug ?: '—' }}</code></td>
                            <td>{{ $dev->sort_order }}</td>
                            <td>
                                @if($dev->is_active)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.developers.edit', $dev) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.developers.destroy', $dev) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this developer from the carousel?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No developers yet. <a href="{{ route('admin.developers.create') }}">Add one</a></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
