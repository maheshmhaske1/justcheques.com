@extends('admin.admin')
@section('content')
    <div class="row px-2">
        <div class="card mt-2 mb-4">
            <div class="card-header">
                <h5 class="mb-0"><strong>Edit Color</strong></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.colors.update', $color->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Color Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="e.g., Burgundy, Blue, Green" value="{{ old('name', $color->name) }}"
                            required />
                        <small class="text-muted">Display name for the color</small>
                    </div>

                    <!-- Value -->
                    <div class="mb-3">
                        <label class="form-label" for="value">Color Value</label>
                        <input type="text" class="form-control" name="value" id="value"
                            placeholder="e.g., burgundy, blue, green" value="{{ old('value', $color->value) }}"
                            required />
                        <small class="text-muted">Internal value used in forms (lowercase, no spaces)</small>
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label class="form-label" for="image">Color Image</label>
                        <input type="file" class="form-control" name="image" id="image"
                            accept="image/jpeg,image/png,image/jpg,image/gif" />
                        <small class="text-muted">Upload an image showing this color (optional)</small>
                        @if ($color->image)
                            <div class="mt-2">
                                <img src="{{ asset('assets/front/img/' . $color->image) }}"
                                    alt="{{ $color->name }}"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                <p class="small text-muted mt-1">Current image</p>
                            </div>
                        @endif
                    </div>

                    <!-- Is Active -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                value="1" {{ old('is_active', $color->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                        <small class="text-muted">Only active colors will be displayed to users</small>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.colors') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Color</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
