@extends('admin.layouts.app')
@section('title', 'Create Verified Listings Section')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Create Verified Listings Section</h4>
        <a href="{{ route('admin.home-cta-sections.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.home-verified-sections.store') }}" method="POST" class="card shadow-sm" id="verified-section-form">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Heading <span class="text-danger">*</span></label>
                    <input type="text" name="heading" class="form-control" value="{{ old('heading', '100% Verified Listings - No Fake Ads, No Time Wasters') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Intro Text</label>
                    <textarea name="intro_text" class="form-control" rows="2">{{ old('intro_text', 'Every property on Direct Deal UAE goes through strict verification:') }}</textarea>
                </div>

                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Cards <span class="text-danger">*</span></label>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-card-btn">Add Card</button>
                    </div>
                    <div id="cards-wrapper" class="d-grid gap-2"></div>
                    @error('cards')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Footer Text</label>
                    <textarea name="footer_text" class="form-control" rows="2">{{ old('footer_text', 'No duplicates. No misleading ads. Only real, verified Dubai properties.') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Heading Color</label>
                    <input type="color" name="heading_color" class="form-control form-control-color w-100" value="{{ old('heading_color', '#26AE61') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Text Color</label>
                    <input type="color" name="text_color" class="form-control form-control-color w-100" value="{{ old('text_color', '#4A225B') }}">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active (show this section on homepage)</label>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <button type="submit" class="btn btn-primary">Create Section</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('cards-wrapper');
    const addBtn = document.getElementById('add-card-btn');
    const oldCards = @json(old('cards', $defaultCards ?? []));

    function addCardRow(card = { title: '', description: '' }) {
        const index = wrapper.children.length;
        const row = document.createElement('div');
        row.className = 'border rounded p-3';
        row.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Card ${index + 1}</strong>
                <button type="button" class="btn btn-sm btn-outline-danger remove-card-btn">Remove</button>
            </div>
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="cards[${index}][title]" value="${(card.title || '').replace(/"/g, '&quot;')}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="2" name="cards[${index}][description]">${card.description || ''}</textarea>
                </div>
            </div>
        `;
        wrapper.appendChild(row);
        row.querySelector('.remove-card-btn').addEventListener('click', function () {
            row.remove();
            reindex();
        });
    }

    function reindex() {
        Array.from(wrapper.children).forEach((row, index) => {
            const title = row.querySelector('input[name*="[title]"]');
            const desc = row.querySelector('textarea[name*="[description]"]');
            const heading = row.querySelector('strong');
            heading.textContent = `Card ${index + 1}`;
            title.name = `cards[${index}][title]`;
            desc.name = `cards[${index}][description]`;
        });
    }

    addBtn.addEventListener('click', function () {
        addCardRow();
    });

    if (Array.isArray(oldCards) && oldCards.length) {
        oldCards.forEach(addCardRow);
    } else {
        addCardRow();
    }
});
</script>
@endpush
