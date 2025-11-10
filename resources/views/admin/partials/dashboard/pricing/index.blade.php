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
            <div class="d-flex align-items-center">
                <h5 class="card-header heading-text"><strong>Pricing Management</strong></h5>
                <div>
                    <a href="{{ route('admin.pricing.bulk-manage') }}" class="btn btn-primary">
                        Bulk Manage All Pricing
                    </a>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th><strong>Sr No.</strong></th>
                            <th><strong>Subcategory</strong></th>
                            <th><strong>Image</strong></th>
                            <th><strong>Pricing Set</strong></th>
                            <th><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($subcategories as $subcategory)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>{{ $subcategory->name }}</td>
                                <td>
                                    @if($subcategory->image)
                                        <img src="{{ asset('assets/front/img/' . $subcategory->image) }}"
                                             alt="{{ $subcategory->name }}"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>
                                    @if($subcategory->pricing->count() > 0)
                                        <span class="badge bg-success">{{ $subcategory->pricing->count() }} prices set</span>
                                    @else
                                        <span class="badge bg-warning">No pricing set</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.pricing.manage-subcategory', $subcategory->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bx bx-dollar"></i> Manage Pricing
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
