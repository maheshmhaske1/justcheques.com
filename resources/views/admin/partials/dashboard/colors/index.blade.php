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
                <h5 class="card-header heading-text"><strong>Colors</strong></h5>
                <div class="search-box-css">
                    <input type="text" id="customSearch" class="form-control w-auto" placeholder="Search colors..."
                        autocomplete="off">
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalColor">
                        Add Color
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="colorTable">
                    <thead>
                        <tr>
                            <th><strong>Sr No.</strong></th>
                            <th><strong>Image</strong></th>
                            <th><strong>Name</strong></th>
                            <th><strong>Value</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($colors as $color)
                            <tr>
                                <td><strong>{{ $loop->iteration + ($colors->currentPage() - 1) * $colors->perPage() }}</strong>
                                </td>
                                <td>
                                    @if($color->image)
                                        <img src="{{ asset('assets/front/img/' . $color->image) }}"
                                             alt="{{ $color->name }}"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $color->name }}</td>
                                <td>{{ $color->value }}</td>
                                <td>
                                    @if($color->is_active)
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
                                            <a class="dropdown-item" href="{{ route('admin.colors.edit', $color->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <form action="{{ route('admin.colors.destroy', $color->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this color?');">
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
            <div class="pagination justify-content-end mt-2">
                {{ $colors->links() }}
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.dashboard.colors.colorForm')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#colorTable').DataTable({
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#resetColor').click(function() {
            window.location.href = "{{ route('admin.colors') }}";
        });
    });
</script>
