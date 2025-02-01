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
                <a href="{{ route('admin.users') }}">
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
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-1">
            <div class="card">
                <a href="{{ route('admin.orders') }}">
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
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-1">
            <div class="card">
                <a href="{{ route('admin.customer') }}">
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
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 my-1">
            <div class="card">
                <a href="{{ route('admin.users') }}">
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
                </a>
            </div>
        </div>
    
    <!-- Orders Status Doughnut Chart -->
    <div class="col-lg-6 col-6 mb-6 mt-5">
        <div class="card">
            <h5 class="card-header">Orders Status</h5>
            <div class="card-body">
                <canvas id="doughnutChart" class="chartjs mb-6"></canvas>
                <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
                    <li class="ct-series-0 d-flex flex-column">
                        <h5 class="mb-0 mr-5">Processing</h5>
                        <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(102, 110, 232); width:35px; height:6px;"></span>
                        <div class="text-body-secondary">{{ number_format($totalProcessing, 2) }}%</div>
                    </li>
                    <li class="ct-series-1 d-flex flex-column">
                        <h5 class="mb-0 mr-2">Completed</h5>
                        <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(40, 208, 148); width:35px; height:6px;"></span>
                        <div class="text-body-secondary">{{ number_format($totalCompleted, 2) }}%</div>
                    </li>
                    <li class="ct-series-2 d-flex flex-column">
                        <h5 class="mb-0">Pending</h5>
                        <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(253, 172, 52); width:35px; height:6px;"></span>
                        <div class="text-body-secondary">{{ number_format($totalPending, 2) }}%</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Doughnut Chart -->
     <!-- Doughnut Chart -->
    <div class="col-lg-6 col-12 mb-6 mt-5">
        <div class="card">
            <h5 class="card-header">Analytical Graph</h5>
            <div class="card-body">
                <canvas id="totalDataChart" class="chartjs mb-6"></canvas>
                <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
                    <li class="ct-series-0 d-flex flex-column">
                        <h5 class="mb-0 mr-5">Users</h5>
                        <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(102, 110, 232); width:35px; height:6px;"></span>
                        <div class="text-body-secondary">{{ number_format($totalUsers, 2) }}%</div>
                    </li>
                    <li class="ct-series-1 d-flex flex-column">
                        <h5 class="mb-0 mr-2">Orders</h5>
                        <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(40, 208, 148); width:35px; height:6px;"></span>
                        <div class="text-body-secondary">{{ number_format($totalOrder, 2) }}%</div>
                    </li>
                    <li class="ct-series-2 d-flex flex-column">
                        <h5 class="mb-0">Customers</h5>
                        <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(253, 172, 52); width:35px; height:6px;"></span>
                        <div class="text-body-secondary">{{ number_format($totalCustomer, 2) }}%</div>
                    </li>
                     <li class="ct-series-2 d-flex flex-column">
                        <h5 class="mb-0">Vendors</h5>
                        <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(253, 172, 52); width:35px; height:6px;"></span>
                        <div class="text-body-secondary">{{ number_format($totalVendor, 2) }}%</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    <!-- /Doughnut Chart -->
@endsection
<script src="{{ asset('assets/js/chartjs.js') }}"></script>


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



        var ctx = document.getElementById("doughnutChart").getContext("2d");

        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Processing", "Complated", "Pending"],
                datasets: [{
                    data: [{{$totalProcessing}}, {{$totalCompleted}}, {{$totalPending}}],
                    backgroundColor: ["#666ee8", "#28d094", "#fdac34"],
                    borderColor: "transparent",
                }],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        enabled: true,
                    },
                    hover: {
                        mode: "index",
                    },
                },
            },
        });

    //total all data
    var ctx = document.getElementById("totalDataChart").getContext("2d");

        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Users", "Orders", "Customers", "Vendors"],
                datasets: [{
                    data: [{{$totalUsers}}, {{$totalOrder}}, {{$totalCustomer}}, {{$totalVendor}}],
                    backgroundColor: ["rgb(113 221 55)","#666ee8", "#c569ff", "#fdac34"],
                    borderColor: "transparent",
                }],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        enabled: true,
                    },
                    hover: {
                        mode: "index",
                    },
                },
            },
        });
    });
</script>
