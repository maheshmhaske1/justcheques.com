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
                    <h5 class="heading-text mb-0"><strong>Bulk Manage All Pricing</strong></h5>
                    <small class="text-muted">Update prices for all subcategories at once</small>
                </div>
                <div>
                    <a href="{{ route('admin.pricing.index') }}" class="btn btn-secondary">Back to Pricing</a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.pricing.bulk-update') }}" method="POST">
                    @csrf

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width: 200px;">Subcategory</th>
                                    @foreach($quantityTiers as $tier)
                                        <th class="text-center" style="min-width: 120px;">
                                            <div>{{ $tier->quantity }}</div>
                                            <small class="text-muted">cheques</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subcategories as $subcategory)
                                    @php
                                        $prices = $subcategory->pricing->keyBy('quantity_tier_id');
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $subcategory->name }}</strong>
                                            @if($subcategory->image)
                                                <br>
                                                <img src="{{ asset('assets/front/img/' . $subcategory->image) }}"
                                                     alt="{{ $subcategory->name }}"
                                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px; margin-top: 5px;">
                                            @endif
                                        </td>
                                        @foreach($quantityTiers as $tier)
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number"
                                                           class="form-control"
                                                           name="pricing[{{ $subcategory->id }}][{{ $tier->id }}]"
                                                           value="{{ $prices->has($tier->id) ? $prices[$tier->id]->price : '' }}"
                                                           step="0.01"
                                                           min="0"
                                                           placeholder="0.00">
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save All Pricing</button>
                        <a href="{{ route('admin.pricing.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>

                <div class="alert alert-info mt-4">
                    <i class="bx bx-info-circle"></i>
                    <strong>Tip:</strong> Leave fields empty to remove pricing for that quantity tier. All changes will be saved when you click "Save All Pricing".
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .table-responsive {
        overflow-x: auto;
    }
    .table td input {
        min-width: 80px;
    }
</style>
