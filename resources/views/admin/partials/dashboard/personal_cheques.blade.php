@extends('admin.admin')
@section('content')
@if (session('error'))
<div class="alert alert-danger alert-dismissible show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('success'))
<div class="alert alert-success alert-dismissible show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<!-- <div style="display: flex; justify-content: flex-start;">
    <a class="btn btn-primary my-4" href="{{ url('admin/personal_cheques_form') }}" role="button">Add PersonalCheques </a>
</div> -->
<div class="card">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-header"><strong>Manual Cheque</strong></h5>
        <div>
            <button type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#modalManualCheque">
            Personal Cheques</button>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th><strong>Sr No.</strong></th>
                    <th><strong>Categories Name</strong></th>
                    <th><strong>Image</strong></th>
                    <th><strong>Actions</strong></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($personalCheques as $cheque)
                <tr>
                    <td><strong>{{ $cheque->id }}</strong></td>
                    <td><strong>{{ $cheque->categoriesName }}</strong></td>
                    <td><img src="{{ asset('assets/front/img/' . $cheque->img) }}" alt="Product A Image" style="max-width: 100px; height: 50px;"></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('edit.personal.cheque', $cheque->id) }}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                <form action="{{ route('delete.personal.cheque', $cheque->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-2"></i> Delete</button>
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
@endsection
@include('admin.partials.dashboard.personalcheque_form')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (isset($chequesCategory))
            var editModal = new bootstrap.Modal(document.getElementById('modalManualCheque'));
            editModal.show();
        @endif
    });


</script>