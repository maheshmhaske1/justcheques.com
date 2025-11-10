@extends('admin.admin')
@section('content')
    <div class="row px-2">
        <div class="card mt-2 mb-4">
            <div class="card-header">
                <h5 class="mb-0"><strong>Add New Quantity Tier</strong></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.quantity-tiers.store') }}" method="POST">
                    @csrf

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity"
                            placeholder="e.g., 100, 250, 500" value="{{ old('quantity') }}" min="1"
                            required />
                        <small class="text-muted">Enter the number of cheques for this tier</small>
                    </div>

                    <!-- Display Order -->
                    <div class="mb-3">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" class="form-control" name="display_order" id="display_order"
                            placeholder="e.g., 1, 2, 3" value="{{ old('display_order') }}" min="0" />
                        <small class="text-muted">Lower numbers appear first. Leave empty to add at the end.</small>
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
                        <small class="text-muted">Only active quantity tiers will be available for selection</small>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.quantity-tiers.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Quantity Tier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
