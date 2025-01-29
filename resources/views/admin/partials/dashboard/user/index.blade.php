@extends('admin.admin')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row px-2">
        <div class="card mt-2 mb-4">
            <div class="d-flex  align-items-center">
                <h5 class="card-header heading-text"><strong>Users</strong></h5>
                <div class="search-box-css">
                    <input type="text" id="customSearch" class="form-control w-auto" placeholder="Search users..."
                        autocomplete="off">
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUser">
                        Add User
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="userTable">
                    <thead>
                        <tr>
                            <th><strong>Sr No.</strong></th>
                            <th><strong>First Name</strong></th>
                            <th><strong>Last Name</strong></th>
                            <th><strong>Telephone</strong></th>
                            <th><strong>Company</strong></th>
                            <th><strong>Street Address</strong></th>
                            <th><strong>Email</strong></th>
                            <th><strong>Role</strong></th>
                            <th><strong>City</strong></th>
                            <th><strong>Post Code</strong></th>
                            <th><strong>State</strong></th>
                            <th><strong>Country</strong></th>
                            <th><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                            <tr>
                                <td><strong>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</strong>
                                </td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>{{ $user->company }}</td>
                                <td>{{ $user->street_address }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->city }}</td>
                                <td>{{ $user->postcode }}</td>
                                <td>{{ $user->state }}</td>
                                <td>{{ $user->country }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');">
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
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.dashboard.user.userForm')
<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
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
        $('#customSearch').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (isset($userData))
            var editModal = new bootstrap.Modal(document.getElementById('modalUser'));
            editModal.show();
        @endif
    });
</script>
