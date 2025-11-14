@extends('admin.admin')
@section('content')
    <div class="row px-2">
        <div class="card mt-2 mb-4">
            <div class="card-header">
                <h5 class="mb-0"><strong>Add New Subcategory Item</strong></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subcategory-items.store') }}" method="POST">
                    @csrf

                    <!-- Subcategory -->
                    <div class="mb-3">
                        <label class="form-label" for="subcategory_id">Subcategory</label>
                        <select class="form-select" name="subcategory_id" id="subcategory_id" required>
                            <option value="">Select a subcategory</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subcategory_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Item Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Enter item name" value="{{ old('name') }}" required />
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                        <small class="text-muted">Only active items will be displayed to users</small>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.subcategory-items.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
