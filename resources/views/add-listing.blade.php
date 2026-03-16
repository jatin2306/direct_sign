@extends('layouts.home')

@section('content')

<!-- Breadcrumb -->
<div class="bg-light">
    <div class="container">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fas fa-chevron-right"></i> Add Listing
            </li>
        </ol>
    </div>
</div>

<section class="space-ptb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <form method="POST"
                      action="{{ route('add.listing.store') }}"
                      enctype="multipart/form-data"
                      class="p-4 bg-white shadow rounded">

                    @csrf

                    <h2 class="mb-4">List your property</h2>

                    {{-- LISTING TYPE --}}
                    <div class="mb-4">
                        <label class="fw-bold mb-2 d-block">Do you want to</label>

                        <input type="hidden" name="listing_type" id="listing_type" value="sell">

                        <button type="button"
                                class="selectable selected"
                                data-value="sell">
                            Sell Property
                        </button>

                        <button type="button" id="rentBtn"
                                class="selectable"
                                data-value="rent">
                            Rent Property
                        </button>
                    </div>

                    {{-- DOCUMENTS --}}
                    <div class="mb-4">
                        <h5 class="d-none mb-3">Legal Documents</h5>

                        <div id="sellFields">
                            <label>Title Deed / Oqood / Pre Title Deed</label>
                            <input type="file"
                                   class="form-control mb-3"
                                   name="title_deed"
                                   accept=".pdf,image/*">
                        </div>

                        <div id="rentFields" class="d-none">
                            <label>Title Deed / Oqood / Pre Title Deed</label>
                            <input type="file"
                                   class="form-control mb-3"
                                   name="oqood"
                                   accept=".pdf,image/*">

                            <label>Rent Frequency</label>
                            <div class="d-flex gap-3">
                                <label>
                                    <input type="radio" name="rent_frequency" value="year">
                                    Yearly
                                </label>

                                <label>
                                    <input type="radio" name="rent_frequency" value="month">
                                    Monthly
                                </label>

                                <label>
                                    <input type="radio" name="rent_frequency" value="custom">
                                    Custom
                                </label>
                            </div>

                            <!-- Custom Date Range (disabled when hidden so they are not submitted) -->
                            <div id="customDates" class="row mt-3 d-none">
                                <div class="col-md-6">
                                    <label>Start Date</label>
                                    <input type="date"
                                        class="form-control"
                                        name="custom_start_date"
                                        disabled>
                                </div>

                                <div class="col-md-6">
                                    <label>End Date</label>
                                    <input type="date"
                                        class="form-control"
                                        name="custom_end_date"
                                        disabled>
                                </div>
                            </div>

                        </div>

                        <label class="mt-3">Emirates ID / Passport *</label>
                        <input type="file"
                               class="form-control"
                               name="emirates_id"
                               required
                               accept=".pdf,image/*">
                    </div>

                    {{-- PROPERTY STATUS --}}
                    <div class="mb-4">
                        <h5 class="mb-3">Property Status</h5>

                        <div class="d-flex flex-wrap gap-3">
                            <label>
                                <input type="radio"
                                       name="property_status"
                                       value="vacant"
                                       required>
                                Vacant
                            </label>

                            <label>
                                <input type="radio"
                                       name="property_status"
                                       value="vacant_on_transfer">
                                Vacant on Transfer
                            </label>

                            <label>
                                <input type="radio"
                                       name="property_status"
                                       value="rented">
                                Rented
                            </label>

                            <label id="offPlan">
                                <input type="radio"
                                       name="property_status"
                                       value="off_plan">
                                Off Plan / Under Construction
                            </label>
                        </div>
                    </div>

                    {{-- PRICE --}}
                    <!--<div class="mb-4">-->
                    <!--    <label class="fw-bold">Price (AED) *</label>-->
                    <!--    <input type="number"-->
                    <!--           class="form-control"-->
                    <!--           name="price"-->
                    <!--           required>-->
                    <!--</div>-->
                    
                    <div class="mb-4">
                        <label class="fw-bold">Price (AED)</label>
                    
                        <!-- Visible formatted input -->
                        <input type="text"
                               class="form-control"
                               id="price_display"
                               inputmode="numeric"
                               placeholder="e.g. 1,250,000" required>
                    
                        <!-- Hidden pure numeric value -->
                        <input type="hidden"
                               name="price"
                               id="price">
                    </div>

                    {{-- IMAGES --}}
                    <div class="mb-4">
                        <label class="fw-bold">Property Images</label>
                        <input type="file"
                               class="form-control"
                               name="images[]"
                               multiple
                               accept="image/*">

                        <small class="text-muted">
                            Max 10 images · 5MB each
                        </small>

                        <div class="row mt-3" id="preview"></div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4">
                            Submit Listing
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

{{-- STYLES --}}
<style>
input#price_display::placeholder {
    color: #00000061;
}
.selectable {
    background: #fff;
    border: 2px solid #26ae61;
    padding: 10px 18px;
    margin-right: 10px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}
.selectable.selected {
    background: #26ae61;
    color: #fff;
}
</style>

{{-- JS --}}
<script>

document.querySelectorAll('input[name="rent_frequency"]').forEach(radio => {
    radio.addEventListener('change', function () {
        const customDates = document.getElementById('customDates');
        const startInput = customDates.querySelector('input[name="custom_start_date"]');
        const endInput = customDates.querySelector('input[name="custom_end_date"]');

        if (this.value === 'custom') {
            customDates.classList.remove('d-none');
            if (startInput) { startInput.removeAttribute('disabled'); startInput.setAttribute('required', 'required'); }
            if (endInput) { endInput.removeAttribute('disabled'); endInput.setAttribute('required', 'required'); }
        } else {
            customDates.classList.add('d-none');
            customDates.querySelectorAll('input').forEach(i => {
                i.value = '';
                i.setAttribute('disabled', 'disabled');
                i.removeAttribute('required');
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const rentBtn = document.getElementById('rentBtn');
    const offPlan = document.getElementById('offPlan');

    if (!rentBtn || !offPlan) return;

    function toggleOffPlan() {
        const isRent = rentBtn.classList.contains('selected');
        const input = offPlan.querySelector('input');
    
        offPlan.style.display = isRent ? 'none' : '';
        input.disabled = isRent;
    
        if (isRent) {
            input.checked = false;
        }
    }

    toggleOffPlan(); // on load

    document.querySelectorAll('.selectable').forEach(btn => {
        btn.addEventListener('click', toggleOffPlan);
    });
});

document.querySelectorAll('.selectable').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.selectable').forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');
        document.getElementById('listing_type').value = this.dataset.value;

        document.getElementById('sellFields').classList.toggle('d-none', this.dataset.value !== 'sell');
        document.getElementById('rentFields').classList.toggle('d-none', this.dataset.value !== 'rent');
    });
});

/* IMAGE PREVIEW */
document.querySelector('input[name="images[]"]').addEventListener('change', function () {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    [...this.files].slice(0,10).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML += `
                <div class="col-3 mb-3">
                    <img src="${e.target.result}" class="img-fluid rounded border">
                </div>`;
        };
        reader.readAsDataURL(file);
    });
});

const displayInput = document.getElementById('price_display');
const hiddenInput  = document.getElementById('price');

if (displayInput && hiddenInput) {
    displayInput.addEventListener('input', function () {

        let numericValue = this.value.replace(/\D/g, '');

        hiddenInput.value = numericValue;

        this.value = numericValue
            ? numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
            : '';
    });
}

</script>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



@endsection
