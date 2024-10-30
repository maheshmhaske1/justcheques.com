@extends('admin.admin')
@section('content')
<div class="row g-6 mb-6 my-3">
    <div class="col-sm-6 col-xl-3">
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
    <div class="col-sm-6 col-xl-3">
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
    <div class="col-sm-6 col-xl-3">
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
    <div class="col-sm-6 col-xl-3">
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


{{-- tables --}}
<div class="row px-2">

    <div class="card mt-2 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header"><strong>Users</strong></h5>
            <div>
                <a class="btn btn-primary my-2 mx-2" href="{{ url('admin/manual_cheques_form') }}" role="button">Add User </a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
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
                  @foreach( $users as $user)
                    <tr>
                        <td><strong>{{ $user->id}}</strong></td>
                        <td>{{ $user->firstname}}</td>
                        <td>{{ $user->lastname}}</td>
                        <td>{{ $user->telephone}}</td>
                        <td>{{ $user->company}}</td>
                        <td>{{ $user->street_address}}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->role}}</td>
                        <td>{{ $user->city}}</td>
                        <td>{{ $user->postcode}}</td>
                        <td>{{ $user->state}}</td>
                        <td>{{ $user->country}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>
                                        Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                        Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>




    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Orders</h5>
            <div>
                <a class="btn btn-primary my-2" href="{{ url('admin/manual_cheques_form') }}" role="button">Add Order </a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Users</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></td>
                        <td>Albert Cook</td>
                        <td>
                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                    <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                                </li>
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                    <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                                </li>
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    class="avatar avatar-xs pull-up" title="Christina Parker">
                                    <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                                </li>
                            </ul>
                        </td>
                        <td><span class="badge bg-label-primary me-1">Active</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>
                                        Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                        Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection