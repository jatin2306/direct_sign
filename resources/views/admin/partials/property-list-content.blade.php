@php $showPropertyActions = admin_can('properties.verify') || admin_can('properties.edit') || admin_can('properties.create') || admin_can('properties.delete'); @endphp
<div class="card shadow-sm border-0">
  <div class="card-body table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Property</th>
          <th>Type</th>
          <th>Status</th>
          <th>Price</th>
          <th>Posted By</th>
          @if($showPropertyActions)<th>Actions</th>@endif
        </tr>
      </thead>
      <tbody>
        @forelse ($properties as $index => $property)
          <tr>
            <td>{{ $properties->firstItem() + $index }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div>
                  <div class="fw-bold">{{ $property->propertyName }}</div>
                  <small class="text-muted">{{ $property->address }}</small>
                </div>
              </div>
            </td>
            <td>{{ $propertyTypes[$property->propertyType] ?? 'N/A' }}</td>
            <td>
              @if(admin_can('properties.verify'))
              <form method="POST" action="{{ route('admin.properties.toggleVerified', $property->id) }}">
                @csrf
                @method('PUT')
                <button class="btn btn-sm {{ $property->verified ? 'btn-success' : 'btn-outline-danger' }}">
                  {{ $property->verified ? 'Verified' : 'Not Verified' }}
                </button>
              </form>
              @else
              <span class="badge {{ $property->verified ? 'bg-success' : 'bg-secondary' }}">{{ $property->verified ? 'Verified' : 'Not Verified' }}</span>
              @endif
            </td>
            <td>₹{{ number_format($property->price) }}</td>
            <td>{{ $property->user->name ?? 'N/A' }}</td>
            @if($showPropertyActions)
            <td>
              <a href="{{ route('property.show', $property->slug ?? $property->id) }}" class="btn btn-sm px-2 btn-outline-info" target="_blank"><i class="fa fa-eye"></i></a>
              @if(admin_can('properties.edit') || (admin_can('properties.create') && $property->created_by_admin_id == Auth::guard('admin')->id()))
              <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn btn-sm px-2 btn-outline-warning"><i class="fa fa-edit"></i></a>
              @endif
              @if(admin_can('properties.create'))
              <form action="{{ route('admin.properties.duplicate', $property->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Duplicate this property?')">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary px-2"><i class="fa fa-copy"></i></button>
              </form>
              @endif
              @if(admin_can('properties.delete'))
              <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this property?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger px-2"><i class="fa fa-trash"></i></button>
              </form>
              @endif
            </td>
            @endif
          </tr>
        @empty
          <tr>
            <td colspan="{{ $showPropertyActions ? 7 : 6 }}" class="text-center text-muted py-4">No properties found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <ul class="pagination mt-3">
      @if ($properties->onFirstPage())
        <li class="page-item disabled me-auto"><span class="page-link b-radius-none">Prev</span></li>
      @else
        <li class="page-item me-auto">
          <a class="page-link b-radius-none" href="{{ $properties->withQueryString()->previousPageUrl() }}">Prev</a>
        </li>
      @endif
      @foreach ($properties->getUrlRange(1, $properties->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $properties->currentPage() ? 'active' : '' }}">
          <a href="{{ $properties->withQueryString()->url($page) }}" class="page-link">{{ $page }}</a>
        </li>
      @endforeach
      @if ($properties->hasMorePages())
        <li class="page-item ms-auto">
          <a class="page-link b-radius-none" href="{{ $properties->withQueryString()->nextPageUrl() }}">Next</a>
        </li>
      @else
        <li class="page-item disabled ms-auto"><span class="page-link b-radius-none">Next</span></li>
      @endif
    </ul>
  </div>
</div>
