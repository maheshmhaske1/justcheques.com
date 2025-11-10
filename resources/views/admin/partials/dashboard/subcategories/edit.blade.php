@extends('admin.admin')
@section('content')
    <div class="row px-2">
        <div class="card mt-2 mb-4">
            <div class="card-header">
                <h5 class="mb-0"><strong>Edit Subcategory</strong></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Subcategory Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="e.g., 1 up Manual Green, Top Laser Blue" value="{{ old('name', $subcategory->name) }}"
                            required />
                        <small class="text-muted">The slug will be auto-generated from the name</small>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"
                            placeholder="Optional description...">{{ old('description', $subcategory->description) }}</textarea>
                    </div>

                    <!-- Current Image -->
                    @if($subcategory->image)
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div>
                                <img src="{{ asset('assets/front/img/' . $subcategory->image) }}"
                                     alt="{{ $subcategory->name }}"
                                     style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
                            </div>
                        </div>
                    @endif

                    <!-- Image -->
                    <div class="mb-3">
                        <label class="form-label" for="image">Change Image</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*" />
                        <small class="text-muted">Upload a new image to replace the current one (JPG, PNG, GIF)</small>
                    </div>

                    <!-- Colors -->
                    <div class="mb-3">
                        <label class="form-label">Available Colors</label>
                        <div class="row">
                            @foreach($colors as $color)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="colors[]"
                                            value="{{ $color->id }}" id="color_{{ $color->id }}"
                                            {{ in_array($color->id, old('colors', $subcategory->colors->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center" for="color_{{ $color->id }}">
                                            @if($color->image)
                                                <img src="{{ asset('assets/front/img/' . $color->image) }}"
                                                    alt="{{ $color->name }}"
                                                    style="width: 30px; height: 30px; object-fit: cover; margin-right: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                            @else
                                                <span style="display: inline-block; width: 30px; height: 30px; background-color: {{ $color->value }}; border: 1px solid #ddd; border-radius: 4px; margin-right: 10px;"></span>
                                            @endif
                                            {{ $color->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Select the colors available for this subcategory</small>
                    </div>

                    <!-- Is Active -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                value="1" {{ old('is_active', $subcategory->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                        <small class="text-muted">Only active subcategories will be displayed to users</small>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
