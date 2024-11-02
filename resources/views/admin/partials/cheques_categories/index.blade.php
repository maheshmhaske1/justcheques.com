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
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header"><strong>Cheque Categories</strong></h5>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalChequeCategories">
                        Add Cheque Categories
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (isset($chequeCategoryData))
            var editModal = new bootstrap.Modal(document.getElementById('modalChequeCategories'));
            editModal.show();
        @endif
    });
</script>