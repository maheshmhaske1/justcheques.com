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
                <div>
                    <h5 class="heading-text mb-0"><strong>Manage Pricing: {{ $subcategory->name }}</strong></h5>
                    <small class="text-muted">Set prices for each quantity tier</small>
                </div>
                <div>
                    <a href="{{ route('admin.pricing.index') }}" class="btn btn-secondary">Back to Pricing</a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.pricing.update-subcategory', $subcategory->id) }}" method="POST">
                    @csrf

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Display Order</th>
                                    <th>Quantity (Cheques)</th>
                                    <th>Price ($)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quantityTiers as $tier)
                                    <tr>
                                        <td class="text-center"><strong>{{ $tier->display_order }}</strong></td>
                                        <td><span class="badge bg-primary">{{ $tier->quantity }} cheques</span></td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number"
                                                       class="form-control"
                                                       name="prices[{{ $tier->id }}]"
                                                       value="{{ $existingPricing->has($tier->id) ? $existingPricing[$tier->id]->price : '' }}"
                                                       step="0.01"
                                                       min="0"
                                                       placeholder="0.00">
                                            </div>
                                            <small class="text-muted">Leave empty to remove pricing</small>
                                        </td>
                                        <td>
                                            @if($existingPricing->has($tier->id))
                                                <span class="badge bg-success">Price Set</span>
                                            @else
                                                <span class="badge bg-secondary">Not Set</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Pricing</button>
                        <a href="{{ route('admin.pricing.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
