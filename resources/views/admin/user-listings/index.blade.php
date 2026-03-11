@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">User Listings</h4>

    @foreach($listings as $listing)
        <div class="card mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ $listing->user->name }}</strong><br>
                        <small class="text-muted">{{ $listing->user->email }}</small>
                    </div>

                    <span class="badge bg-secondary text-uppercase">
                        {{ $listing->listing_type }}
                    </span>
                </div>

                <hr>

                <p><strong>Status:</strong> {{ ucfirst($listing->property_status) }}</p>
                <p><strong>Price:</strong> AED {{ number_format($listing->price) }}</p>

                @if($listing->listing_type === 'rent')
                    <p><strong>Rent Frequency:</strong> {{ ucfirst($listing->rent_frequency) }}</p>
                @endif

                {{-- DOCUMENTS --}}
                <div class="mb-3">
                    <strong>Documents:</strong><br>

                    @if($listing->title_deed)
                        <a href="{{ ('http://localhost/deal/direct_sign/storage/app/public/'.$listing->title_deed) }}" target="_blank">
                            View Title Deed
                        </a><br>
                    @endif

                    @if($listing->oqood)
                        <a href="{{ ('http://localhost/deal/direct_sign/storage/app/public/'.$listing->oqood) }}" target="_blank">
                            View Oqood
                        </a><br>
                    @endif

                    <!-- <a href="{{ asset('storage/'.$listing->emirates_id) }}" target="_blank"> -->
                        <a href="{{ ('http://localhost/deal/direct_sign/storage/app/public/'.$listing->emirates_id) }}" target="_blank">
                        View Emirates ID
                    </a>
                </div>

                {{-- IMAGES --}}
                @if($listing->images)
                    <div class="row">
                        @foreach($listing->images as $img)
                            <div class="col-3 mb-2">
                                <img src="{{ ('http://localhost/deal/direct_sign/storage/app/public/'.$img) }}"
                                     class="img-fluid rounded border">
                            </div>
                        @endforeach
                    </div>
                @endif

                <hr>

                {{-- ACTIONS --}}
                @if($listing->status === 'pending')
                    @if(admin_can('user-listings.approve'))
                    <form method="POST" action="{{ route('admin.user-listings.approve', $listing) }}">
                        @csrf

                        <div class="mb-2">
                            <label>Property URL (optional)</label>
                            <input type="text"
                                name="property_url"
                                class="form-control"
                                placeholder="https://example.com/property/123">
                        </div>

                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>
                    @endif

                    @if(admin_can('user-listings.reject'))
                    <form method="POST"
                          action="{{ route('admin.user-listings.reject', $listing) }}"
                          class="mt-2">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm">
                            Reject
                        </button>
                    </form>
                    @endif
                @else
                    <span class="badge bg-info">
                        {{ ucfirst($listing->status) }}
                    </span>

                    @if($listing->property_url)
                        <div class="mt-2">
                            <a href="{{ $listing->property_url }}"
                               target="_blank"
                               class="btn btn-sm btn-primary">
                                View Property
                            </a>
                        </div>
                    @endif
                @endif

            </div>
        </div>
    @endforeach

    {{ $listings->links() }}
</div>
@endsection
