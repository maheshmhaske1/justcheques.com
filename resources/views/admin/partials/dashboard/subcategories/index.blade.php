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
            <div class="d-flex  align-items-center">
                <h5 class="card-header heading-text"><strong>Subcategories</strong></h5>
                <div class="search-box-css">
                    <input type="text" id="customSearch" class="form-control w-auto" placeholder="Search subcategories..."
                        autocomplete="off">
                </div>
                <div>
                    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">
                        Add Subcategory
                    </a>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="subcategoryTable">
                    <thead>
                        <tr>
                            <th><strong>Sr No.</strong></th>
                            <th><strong>Name</strong></th>
                            <th><strong>Image</strong></th>
                            <th><strong>Colors</strong></th>
                            <th><strong>Categories</strong></th>
                            <th><strong>Status</strong></th>
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
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>
                                    @if($subcategory->colors && $subcategory->colors->count() > 0)
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($subcategory->colors as $color)
                                                @if($color->image)
                                                    <img src="{{ asset('assets/front/img/' . $color->image) }}"
                                                        alt="{{ $color->name }}"
                                                        title="{{ $color->name }}"
                                                        style="width: 25px; height: 25px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                                                @else
                                                    <span title="{{ $color->name }}" style="display: inline-block; width: 25px; height: 25px; background-color: {{ $color->value }}; border: 1px solid #ddd; border-radius: 4px;"></span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">No colors</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-info">{{ $subcategory->categories_count }} categories</span></td>
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
                                            <a class="dropdown-item" href="{{ route('admin.pricing.manage-subcategory', $subcategory->id) }}"><i
                                                    class="bx bx-dollar me-1"></i>
                                                Manage Pricing</a>
                                            <a class="dropdown-item" href="{{ route('admin.subcategories.edit', $subcategory->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <form action="{{ route('admin.subcategories.destroy', $subcategory->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item mb-0"><i
                                                        class="bx bx-trash"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#subcategoryTable').DataTable({
            "paging": false,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "dom": "lrtip"
        });

        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>
