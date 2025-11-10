@extends('admin.admin')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row px-2">
        <div class="card mt-2 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="heading-text mb-0"><strong>Manage Subcategories for: {{ $category->name }}</strong></h5>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to Categories</a>
            </div>

            <!-- Assign New Subcategory -->
            <div class="card-body">
                <form action="{{ route('admin.categories.assign-subcategory', $category->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <label for="subcategory_id" class="form-label">Select Subcategory to Add</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                <option value="">-- Select Subcategory --</option>
                                @foreach($availableSubcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" name="display_order" id="display_order" class="form-control" min="1">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Add Subcategory</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Assigned Subcategories Table -->
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th><strong>Display Order</strong></th>
                            <th><strong>Subcategory Name</strong></th>
                            <th><strong>Image</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($assignedSubcategories as $subcategory)
                            <tr>
                                <td><strong>{{ $subcategory->pivot->display_order }}</strong></td>
                                <td>{{ $subcategory->name }}</td>
                                <td>
                                    @if($subcategory->image)
                                        <img src="{{ asset('assets/front/img/' . $subcategory->image) }}"
                                             alt="{{ $subcategory->name }}"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>
                                    @if($subcategory->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.pricing.manage-subcategory', $subcategory->id) }}">
                                                <i class="bx bx-dollar me-1"></i> Manage Pricing
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.subcategories.edit', $subcategory->id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit Subcategory
                                            </a>
                                            <form action="{{ route('admin.categories.remove-subcategory', [$category->id, $subcategory->id]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Remove this subcategory from this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item mb-0">
                                                    <i class="bx bx-unlink"></i> Remove from Category
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No subcategories assigned to this category yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
