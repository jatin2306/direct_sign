@extends('admin.layouts.app')
@section('title', 'Create Why Direct Deal Section')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Create Why Direct Deal Section</h4>
        <a href="{{ route('admin.home-cta-sections.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.home-why-sections.store') }}" method="POST" class="card shadow-sm">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Heading <span class="text-danger">*</span></label>
                    <input type="text" name="heading" class="form-control" value="{{ old('heading', 'Why Direct Deal UAE?') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Background Color</label>
                    <input type="color" name="background_color" class="form-control form-control-color w-100" value="{{ old('background_color', '#f7fdfb') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Heading Color</label>
                    <input type="color" name="heading_color" class="form-control form-control-color w-100" value="{{ old('heading_color', '#26AE61') }}">
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

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

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
                    <input type="text" class="form-control" name="cards[${index}][title]" value="${escapeHtml(card.title)}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="2" name="cards[${index}][description]">${escapeHtml(card.description)}</textarea>
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
            row.querySelector('strong').textContent = `Card ${index + 1}`;
            row.querySelector('input[name*="[title]"]').name = `cards[${index}][title]`;
            row.querySelector('textarea[name*="[description]"]').name = `cards[${index}][description]`;
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
