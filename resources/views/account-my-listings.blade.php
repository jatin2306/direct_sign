@extends('layouts.home')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">My Listings</h3>

        <a href="{{ route('add.listing') }}" class="btn btn-primary">
            + Add New Listing
        </a>
    </div>

    @if($listings->count() === 0)
        <div class="alert alert-info">
            You haven’t added any listings yet.
        </div>
    @endif

    @foreach($listings as $listing)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <div class="row align-items-center">
                    
                    <!-- LEFT -->
                    <div class="col-md-8">
                        <h5 class="mb-1">
                            {{ ucfirst($listing->listing_type) }} Listing
                        </h5>

                        <p class="mb-1 text-muted">
                            Property Status:
                            <strong>{{ ucwords(str_replace('_',' ', $listing->property_status)) }}</strong>
                        </p>

                        <p class="mb-0">
                            Price:
                            <strong>AED {{ number_format($listing->price) }}</strong>
                        </p>
                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">

                        @if($listing->status === 'approved')
                            <span class="badge bg-success">Approved</span>

                            @if($listing->property_url)
                                <a href="{{ $listing->property_url }}"
                                target="_blank"
                                class="btn btn-sm btn-primary ms-2">
                                    View Property
                                </a>
                            @endif
                        @elseif($listing->status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning">Pending Admin Review</span>
                        @endif



                    </div>
                </div>

            </div>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $listings->links() }}
    </div>

</div>
@endsection
