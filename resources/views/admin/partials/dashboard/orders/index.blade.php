@extends('admin.admin')
@section('content')
 @if (session('success'))
        <div class="alert alert-success alert-dismissible show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
 <div class="row px-2">
          <div class="card">
            <div class="d-flex align-items-center">
                <h5 class="card-header heading-text"><strong>Orders</strong></h5>
                 <div class="search-box-css">
                    <input type="text" id="customSearch" class="form-control w-auto" placeholder="Search users..."
                        autocomplete="off">
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalOrder">
                        Add Order</button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="userTable">
                    <thead>
                        <tr>
                            <th><strong>Sr No.</strong></th>
                            <th><strong>Customer Name</strong></th>
                            <th><strong>Vendor Name</strong></th>
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
                                <td>{{ \App\Models\Customer::find($order->customer_id)?->firstname }} {{ \App\Models\Customer::find($order->customer_id)?->lastname }}</td>
                                <td>{{ \App\Models\User::find($order->vendor_id)?->firstname }} {{ \App\Models\User::find($order->vendor_id)?->lastname }}</td>
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
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.dashboard.orders.orderForm')
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
        @if (isset($orderData))
            var editModal = new bootstrap.Modal(document.getElementById('modalOrder'));
            editModal.show();
        @endif

        $('#resetOrder').click(function () {
            window.location.href = "{{ route('admin.orders') }}";
        });
    });
</script>