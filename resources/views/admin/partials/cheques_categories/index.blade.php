@extends('admin.admin')
@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible show" role="alert" style="font-size: 1.9em;">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="row px-2">
    <div class="card mt-2 mb-4">
        <div class="d-flex align-items-center">
            <h5 class="card-header  heading-text"><strong>Cheque Categories</strong></h5>
            <div class="search-box-css">
                <input type="text" id="customSearch" class="form-control w-auto" placeholder="Search users..."
                    autocomplete="off">
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalChequeCategories">
                    Add Cheque Categories
                </button>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table" id="userTable">
                <thead>
                    <tr>
                        <th><strong>Sr No.</strong></th>
                        <th><strong>Manual Cheque Id</strong></th>
                        <th><strong>Laser Cheque Id</strong></th>
                        <th><strong>Personal Cheque Id</strong></th>
                        <th><strong>Cheque Name</strong></th>
                        <th><strong>Price</strong></th>
                        <th><strong>Cheque Img</strong></th>
                        <th><strong>Created Date</strong></th>
                        <th><strong>Actions</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($chequeCategories as $chequeCategory)
                    <tr>
                        <td><strong>{{ $chequeCategory->id }}</strong></td>
                        <td>{{ $chequeCategory->manual_cheque_id }}</td>
                        <td>{{ $chequeCategory->laser_cheque_id }}</td>
                        <td>{{ $chequeCategory->personal_cheque_id }}</td>
                        <td>{{ $chequeCategory->chequeName }}</td>
                        <td>{{ $chequeCategory->price }}</td>
                        <td><img src="{{ asset('assets/front/img/' . $chequeCategory->img) }}" alt
                                class="w-px-50 h-auto" /></td>
                        <td>{{ $chequeCategory->created_at }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.cheque_categories.edit', $chequeCategory->id) }}"><i
                                            class="bx bx-edit-alt me-1"></i>
                                        Edit</a>
                                    <form action="{{ route('admin.cheque_categories.destroy', $chequeCategory->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this Customer?');">
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
            {{ $chequeCategories->links() }}
        </div>
    </div>
</div>
@endsection
@include('admin.partials.cheques_categories.chequeCategoriesForm')
<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable without the default search box
        var table = $('#userTable').DataTable({
            "paging": false,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "dom": "lrtip" // Remove default search box
        });

        // Custom Search Event Listener
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(isset($chequeCategoryData))
        var editModal = new bootstrap.Modal(document.getElementById('modalChequeCategories'));
        editModal.show();
        @endif

        $('#resetChequesCategories').click(function() {
            window.location.href = "{{ route('admin.cheque_categories') }}";
        });
    });
</script>