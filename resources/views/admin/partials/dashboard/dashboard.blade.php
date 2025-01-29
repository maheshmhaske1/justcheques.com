@extends('admin.admin')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row g-6 mb-6 my-3">
        <div class="col-sm-6 col-xl-3 my-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Users</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $totalUsers }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <i class="mdi mdi-account-multiple-outline bx-md text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Orders</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $totalOrder }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <i class="mdi mdi-border-all bx-md text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Customer</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $totalCustomer }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <i class="mdi mdi-account-group-outline bx-md text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Vendors</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $totalVendor }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <i class="mdi mdi-account-supervisor-outline bx-md text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (isset($userData))
            var editModal = new bootstrap.Modal(document.getElementById('modalUser'));
            editModal.show();
        @endif

        @if (isset($orderData))
            var editModal = new bootstrap.Modal(document.getElementById('modalOrder'));
            editModal.show();
        @endif
    });
</script>
