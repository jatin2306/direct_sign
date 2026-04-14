@extends('admin.layouts.app')
@section('title', 'Home Sections')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Home Sections</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">Home CTA Section</h5>
                            @if($section)
                                <div class="small text-muted">{{ $section->title }}</div>
                                <span class="badge {{ $section->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $section->is_active ? 'Active' : 'Inactive' }}</span>
                            @else
                                <span class="badge bg-secondary">Not Created</span>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            @if(!$section && admin_can('home-cta.create'))
                                <a href="{{ route('admin.home-cta-sections.create') }}" class="btn btn-sm btn-primary">Create</a>
                            @endif
                            @if($section && admin_can('home-cta.edit'))
                                <a href="{{ route('admin.home-cta-sections.edit', $section->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.home-cta-sections.toggleActive', $section->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-warning">{{ $section->is_active ? 'Deactivate' : 'Activate' }}</button>
                                </form>
                            @endif
                            @if($section && admin_can('home-cta.delete'))
                                <form action="{{ route('admin.home-cta-sections.destroy', $section->id) }}" method="POST" onsubmit="return confirm('Delete this section?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if($section)
                        <p class="mb-3">{{ $section->description }}</p>
                        <div class="small"><strong>Primary:</strong> {{ $section->primary_button_text ?: '-' }}</div>
                        <div class="small"><strong>Secondary:</strong> {{ $section->secondary_button_text ?: '-' }}</div>
                    @else
                        <div class="alert alert-info mb-0">Create this section to manage the CTA block above homepage content.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">Verified Listings Section</h5>
                            @if($verifiedSection)
                                <div class="small text-muted">{{ $verifiedSection->heading }}</div>
                                <span class="badge {{ $verifiedSection->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $verifiedSection->is_active ? 'Active' : 'Inactive' }}</span>
                            @else
                                <span class="badge bg-secondary">Not Created</span>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            @if(!$verifiedSection && admin_can('home-cta.create'))
                                <a href="{{ route('admin.home-verified-sections.create') }}" class="btn btn-sm btn-primary">Create</a>
                            @endif
                            @if($verifiedSection && admin_can('home-cta.edit'))
                                <a href="{{ route('admin.home-verified-sections.edit', $verifiedSection->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.home-verified-sections.toggleActive', $verifiedSection->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-warning">{{ $verifiedSection->is_active ? 'Deactivate' : 'Activate' }}</button>
                                </form>
                            @endif
                            @if($verifiedSection && admin_can('home-cta.delete'))
                                <form action="{{ route('admin.home-verified-sections.destroy', $verifiedSection->id) }}" method="POST" onsubmit="return confirm('Delete this section?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if($verifiedSection)
                        @php
                            $verifiedCards = is_array($verifiedSection->cards ?? null) ? $verifiedSection->cards : [];
                            if (empty($verifiedCards)) {
                                $verifiedCards = collect([
                                    ['title' => $verifiedSection->item_1_title],
                                    ['title' => $verifiedSection->item_2_title],
                                    ['title' => $verifiedSection->item_3_title],
                                    ['title' => $verifiedSection->item_4_title],
                                ])->filter(fn ($card) => ! empty($card['title']))->values()->all();
                            }
                        @endphp
                        <p class="mb-2">{{ $verifiedSection->intro_text }}</p>
                        <div class="small mb-1"><strong>Total Cards:</strong> {{ count($verifiedCards) }}</div>
                        @foreach(array_slice($verifiedCards, 0, 4) as $index => $card)
                            <div class="small"><strong>Card {{ $index + 1 }}:</strong> {{ $card['title'] ?? '-' }}</div>
                        @endforeach
                    @else
                        <div class="alert alert-info mb-0">Create this section to manage the "100% Verified Listings" block on homepage.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">Why Direct Deal Section</h5>
                            @if($whySection)
                                <div class="small text-muted">{{ $whySection->heading }}</div>
                                <span class="badge {{ $whySection->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $whySection->is_active ? 'Active' : 'Inactive' }}</span>
                            @else
                                <span class="badge bg-secondary">Not Created</span>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            @if(!$whySection && admin_can('home-cta.create'))
                                <a href="{{ route('admin.home-why-sections.create') }}" class="btn btn-sm btn-primary">Create</a>
                            @endif
                            @if($whySection && admin_can('home-cta.edit'))
                                <a href="{{ route('admin.home-why-sections.edit', $whySection->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.home-why-sections.toggleActive', $whySection->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-warning">{{ $whySection->is_active ? 'Deactivate' : 'Activate' }}</button>
                                </form>
                            @endif
                            @if($whySection && admin_can('home-cta.delete'))
                                <form action="{{ route('admin.home-why-sections.destroy', $whySection->id) }}" method="POST" onsubmit="return confirm('Delete this section?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if($whySection)
                        @php $whyCards = is_array($whySection->cards ?? null) ? $whySection->cards : []; @endphp
                        <div class="small mb-1"><strong>Total Cards:</strong> {{ count($whyCards) }}</div>
                        @foreach(array_slice($whyCards, 0, 4) as $index => $card)
                            <div class="small"><strong>Card {{ $index + 1 }}:</strong> {{ $card['title'] ?? '-' }}</div>
                        @endforeach
                    @else
                        <div class="alert alert-info mb-0">Create this section to manage the "Why Direct Deal UAE?" block on homepage.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">Property Sales Section</h5>
                            @if($salesSection)
                                <div class="small text-muted">{{ $salesSection->heading }}</div>
                                <span class="badge {{ $salesSection->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $salesSection->is_active ? 'Active' : 'Inactive' }}</span>
                            @else
                                <span class="badge bg-secondary">Not Created</span>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            @if(!$salesSection && admin_can('home-cta.create'))
                                <a href="{{ route('admin.home-sales-sections.create') }}" class="btn btn-sm btn-primary">Create</a>
                            @endif
                            @if($salesSection && admin_can('home-cta.edit'))
                                <a href="{{ route('admin.home-sales-sections.edit', $salesSection->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.home-sales-sections.toggleActive', $salesSection->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-warning">{{ $salesSection->is_active ? 'Deactivate' : 'Activate' }}</button>
                                </form>
                            @endif
                            @if($salesSection && admin_can('home-cta.delete'))
                                <form action="{{ route('admin.home-sales-sections.destroy', $salesSection->id) }}" method="POST" onsubmit="return confirm('Delete this section?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if($salesSection)
                        @php $salesSteps = is_array($salesSection->steps ?? null) ? $salesSection->steps : []; @endphp
                        <div class="small mb-1"><strong>Total Steps:</strong> {{ count($salesSteps) }}</div>
                        <div class="small"><strong>Bottom Note:</strong> {{ \Illuminate\Support\Str::limit($salesSection->bottom_note, 80) }}</div>
                    @else
                        <div class="alert alert-info mb-0">Create this section to manage "How Direct Deal Works - Property Sales".</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
