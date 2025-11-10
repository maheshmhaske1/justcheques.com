@extends('admin.admin')
@section('content')
    <div class="row px-2">
        <div class="card mt-2 mb-4">
            <div class="card-header">
                <h5 class="mb-0"><strong>Add New Category</strong></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Category Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="e.g., Manual Cheques, Laser Cheques" value="{{ old('name') }}"
                            required />
                        <small class="text-muted">The slug will be auto-generated from the name</small>
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
                        <small class="text-muted">Only active categories will be displayed to users</small>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
