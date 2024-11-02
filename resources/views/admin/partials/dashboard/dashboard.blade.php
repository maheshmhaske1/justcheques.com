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


    {{-- tables --}}
    <div class="row px-2">

        <div class="card mt-2 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header"><strong>Users</strong></h5>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUser">
                        Add User
                    </button>
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
                        @foreach ($users as $user)
                            <tr>
                                <td><strong>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</strong></td>
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

        <div class="card">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header"><strong>Orders</strong></h5>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalOrder">
                        Add Order</button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th><strong>Sr No.</strong></th>
                            <th><strong>Customer Id</strong></th>
                            <th><strong>Quantity</strong></th>
                            <th><strong>Color</strong></th>
                            <th><strong>Company Info</strong></th>
                            <th><strong>Voided Cheque</strong></th>
                            <th><strong>Institution Number</strong></th>
                            <th><strong>Transit Number</strong></th>
                            <th><strong>Account Number</strong></th>
                            <th><strong>Confirm Account Number</strong></th>
                            <th><strong>Cheque Start Number</strong></th>
                            <th><strong>Cheque End Number</strong></th>
                            <th><strong>Cart Quantity</strong></th>
                            <th><strong>Cheque Category Id</strong></th>
                            <th><strong>Voided Cheque File</strong></th>
                            <th><strong>Company Logo</strong></th>
                            <th><strong>Vendor Id</strong></th>
                            <th><strong>Cheque Img</strong></th>
                            <th><strong>Order Status</strong></th>
                            <th><strong>Balance Status</strong></th>
                            <th><strong>Reorder</strong></th>
                            <th><strong>Created Date</strong></th>
                            <th><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $order)
                            <tr>
                                <td><strong>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</strong></td>
                                <td>{{ $order->customer_id }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->color }}</td>
                                <td>{{ $order->company_info }}</td>
                                <td>{{ $order->voided_cheque }}</td>
                                <td>{{ $order->institution_number }}</td>
                                <td>{{ $order->transit_number }}</td>
                                <td>{{ $order->account_number }}</td>
                                <td>{{ $order->confirm_account_number }}</td>
                                <td>{{ $order->cheque_start_number }}</td>
                                <td>{{ $order->cheque_end_number }}</td>
                                <td>{{ $order->cart_quantity }}</td>
                                <td>{{ $order->cheque_category_id }}</td>
                                <td><img src="{{ asset('assets/front/img/' . $order->voided_cheque_file) }}" alt
                                        class="w-px-50 h-auto" /></td>
                                <td><img src="{{ asset('assets/front/img/' . $order->company_logo) }}" alt
                                        class="w-px-50 h-auto" /></td>
                                <td>{{ $order->vendor_id }}</td>
                                <td><img src="{{ asset('assets/front/img/' . $order->cheque_img) }}" alt
                                        class="w-px-50 h-auto" /></td>
                                <td>{{ $order->order_status }}</td>
                                <td>{{ $order->balance_status }}</td>
                                <td>{{ $order->reorder }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.orders.edit', $order->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"><i
                                                        class="bx bx-trash me-1"></i> Delete</button>
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
@include('admin.partials.dashboard.orders.orderForm')
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
