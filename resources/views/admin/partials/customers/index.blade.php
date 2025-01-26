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
                <h5 class="card-header"><strong>Customers</strong></h5>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCustomer">
                        Add Customer
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
                            <th><strong>Suburb</strong></th>
                            <th><strong>Buzzer Code</strong></th>
                            <th><strong>City</strong></th>
                            <th><strong>Post Code</strong></th>
                            <th><strong>State</strong></th>
                            <th><strong>Country</strong></th>
                            <th><strong>Email</strong></th>
                            <th><strong>User Id</strong></th>
                            <th><strong>User Name</strong></th>
                            <th><strong>Created Date</strong></th>
                            <th><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($customers as $customer)
                            <tr>
                                <td><strong>{{ $customer->id }}</strong></td>
                                <td>{{ $customer->firstname }}</td>
                                <td>{{ $customer->lastname }}</td>
                                <td>{{ $customer->telephone }}</td>
                                <td>{{ $customer->company }}</td>
                                <td>{{ $customer->street_address }}</td>
                                <td>{{ $customer->suburb }}</td>
                                <td>{{ $customer->buzzer_code }}</td>
                                <td>{{ $customer->city }}</td>
                                <td>{{ $customer->postcode }}</td>
                                <td>{{ $customer->state }}</td>
                                <td>{{ $customer->country }}</td>
                                <td>{{ $customer->email }}</td>
                                 <td>{{ $customer->user_id }}</td>
                                <td>{{ \App\Models\User::find($customer->user_id)?->firstname }} {{ \App\Models\User::find($customer->user_id)?->lastname ?? 'N/A' }} ({{ \App\Models\User::find($customer->user_id)?->role }})</td>
                                <td>{{ $customer->created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.customer.edit', $customer->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <form action="{{ route('admin.customer.destroy', $customer->id) }}" method="POST"
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
                {{ $customers->links() }}
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.customers.customerForm')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (isset($customerData))
            var editModal = new bootstrap.Modal(document.getElementById('modalCustomer'));
            editModal.show();
        @endif
    });
</script>