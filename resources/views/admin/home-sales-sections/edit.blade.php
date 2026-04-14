@extends('admin.layouts.app')
@section('title', 'Edit Property Sales Section')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Property Sales Section</h4>
        <a href="{{ route('admin.home-cta-sections.index') }}" class="btn btn-secondary">Back</a>
    </div>
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ route('admin.home-sales-sections.update', $section->id) }}" method="POST" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8"><label class="form-label">Heading</label><input type="text" name="heading" class="form-control" value="{{ old('heading', $section->heading) }}" required></div>
                <div class="col-md-4"><label class="form-label">Heading Highlight</label><input type="text" name="heading_highlight" class="form-control" value="{{ old('heading_highlight', $section->heading_highlight) }}"></div>
                <div class="col-md-4"><label class="form-label">Section BG</label><input type="color" name="section_background_color" class="form-control form-control-color w-100" value="{{ old('section_background_color', $section->section_background_color) }}"></div>
                <div class="col-md-4"><label class="form-label">Heading Color</label><input type="color" name="heading_color" class="form-control form-control-color w-100" value="{{ old('heading_color', $section->heading_color) }}"></div>
                <div class="col-md-4"><label class="form-label">Highlight Color</label><input type="color" name="heading_highlight_color" class="form-control form-control-color w-100" value="{{ old('heading_highlight_color', $section->heading_highlight_color) }}"></div>
                <div class="col-md-4"><label class="form-label">Box BG</label><input type="color" name="box_background_color" class="form-control form-control-color w-100" value="{{ old('box_background_color', $section->box_background_color) }}"></div>
                <div class="col-md-4"><label class="form-label">Box Border</label><input type="color" name="box_border_color" class="form-control form-control-color w-100" value="{{ old('box_border_color', $section->box_border_color) }}"></div>
                <div class="col-md-4"><label class="form-label">Step Title Color</label><input type="color" name="step_title_color" class="form-control form-control-color w-100" value="{{ old('step_title_color', $section->step_title_color) }}"></div>

                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Steps</label>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-step-btn">Add Step</button>
                    </div>
                    <div id="steps-wrapper" class="d-grid gap-2"></div>
                    @error('steps') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-12"><label class="form-label">Bottom Note (Plain)</label><textarea name="bottom_note" rows="2" class="form-control">{{ old('bottom_note', $section->bottom_note) }}</textarea></div>
                <div class="col-md-4"><label class="form-label">Bottom Note - Prefix</label><input type="text" name="bottom_note_prefix" class="form-control" value="{{ old('bottom_note_prefix', $section->bottom_note_prefix) }}"></div>
                <div class="col-md-4"><label class="form-label">Bottom Note - Highlight</label><input type="text" name="bottom_note_highlight" class="form-control" value="{{ old('bottom_note_highlight', $section->bottom_note_highlight) }}"></div>
                <div class="col-md-4"><label class="form-label">Bottom Note - Suffix</label><input type="text" name="bottom_note_suffix" class="form-control" value="{{ old('bottom_note_suffix', $section->bottom_note_suffix) }}"></div>
                <div class="col-md-6"><label class="form-label">Bottom Note Text Color</label><input type="color" name="bottom_note_text_color" class="form-control form-control-color w-100" value="{{ old('bottom_note_text_color', $section->bottom_note_text_color) }}"></div>
                <div class="col-md-6"><label class="form-label">Bottom Note Highlight Color</label><input type="color" name="bottom_note_highlight_color" class="form-control form-control-color w-100" value="{{ old('bottom_note_highlight_color', $section->bottom_note_highlight_color) }}"></div>
                <div class="col-12"><label class="form-label">Bottom Note Subtext</label><textarea name="bottom_note_subtext" rows="2" class="form-control">{{ old('bottom_note_subtext', $section->bottom_note_subtext) }}</textarea></div>
                <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $section->is_active) ? 'checked' : '' }}><label class="form-check-label" for="is_active">Active</label></div></div>
            </div>
            <hr class="my-4"><button type="submit" class="btn btn-primary">Update Section</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('steps-wrapper');
    const addBtn = document.getElementById('add-step-btn');
    const oldSteps = @json(old('steps', $steps ?? []));
    function esc(v){return String(v||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');}
    function addRow(step={title:'',description:''}) {
        const i = wrapper.children.length;
        const row = document.createElement('div');
        row.className = 'border rounded p-3';
        row.innerHTML = `<div class="d-flex justify-content-between align-items-center mb-2"><strong>Step ${i+1}</strong><button type="button" class="btn btn-sm btn-outline-danger rm">Remove</button></div><div class="row g-2"><div class="col-md-5"><label class="form-label">Title</label><input class="form-control" name="steps[${i}][title]" value="${esc(step.title)}"></div><div class="col-md-7"><label class="form-label">Description</label><textarea rows="2" class="form-control" name="steps[${i}][description]">${esc(step.description)}</textarea></div></div>`;
        wrapper.appendChild(row);
        row.querySelector('.rm').addEventListener('click', function(){ row.remove(); reindex(); });
    }
    function reindex() {
        Array.from(wrapper.children).forEach((row, i) => {
            row.querySelector('strong').textContent = `Step ${i+1}`;
            row.querySelector('input[name*="[title]"]').name = `steps[${i}][title]`;
            row.querySelector('textarea[name*="[description]"]').name = `steps[${i}][description]`;
        });
    }
    addBtn.addEventListener('click', function(){ addRow(); });
    (Array.isArray(oldSteps) && oldSteps.length ? oldSteps : [{title:'',description:''}]).forEach(addRow);
});
</script>
@endpush
