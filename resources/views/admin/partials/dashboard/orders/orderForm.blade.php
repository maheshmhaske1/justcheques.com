<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <!-- Modal -->
        <div class="modal fade" id="modalOrder" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form
                    action="{{ isset($orderData) ? route('admin.orders.update', $orderData->id) : route('admin.orderStore') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($orderData))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">
                                {{ isset($orderData) ? 'Edit Order' : 'Add Order' }}</h5>
                            <button type="button" class="btn-close" id="resetOrder" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <!-- Customer ID -->
                                <div class="mb-3">
                                    <label class="form-label" for="customer_id">Customer Name</label>
                                    <select class="form-control" name="customer_id" id="customer_id" required>
                                        <option value="">Select a Customer</option>
                                        @foreach (\App\Models\Customer::all() as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id', $orderData->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->company }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Quantity -->
                                <div class="mb-3">
                                    <label class="form-label" for="quantity">Quantity</label>
                                    <input type="number" class="form-control" name="quantity" id="quantity"
                                        value="{{ old('quantity', $orderData->quantity ?? '') }}" required />
                                </div>

                                <!-- Color -->
                                <div class="mb-3">
                                    <label class="form-label" for="color">Color</label>
                                    <input type="text" class="form-control" name="color" id="color"
                                        value="{{ old('color', $orderData->color ?? '') }}" />
                                </div>

                                <!-- Company Info -->
                                <div class="mb-3">
                                    <label class="form-label" for="company_info">Company Info</label>
                                    <input type="text" class="form-control" name="company_info" id="company_info"
                                        value="{{ old('company_info', $orderData->company_info ?? '') }}" />
                                </div>

                                <!-- Voided Cheque -->
                                <div class="mb-3">
                                    <label class="form-label" for="voided_cheque">Voided Cheque</label>
                                    <input type="checkbox" name="voided_cheque" id="voided_cheque"
                                        {{ old('voided_cheque', $orderData->voided_cheque ?? false) ? 'checked' : '' }} />
                                </div>

                                <!-- Institution Number -->
                                <div class="mb-3">
                                    <label class="form-label" for="institution_number">Institution Number</label>
                                    <input type="text" class="form-control" name="institution_number"
                                        id="institution_number"
                                        value="{{ old('institution_number', $orderData->institution_number ?? '') }}" />
                                </div>

                                <!-- Transit Number -->
                                <div class="mb-3">
                                    <label class="form-label" for="transit_number">Transit Number</label>
                                    <input type="text" class="form-control" name="transit_number" id="transit_number"
                                        value="{{ old('transit_number', $orderData->transit_number ?? '') }}" />
                                </div>

                                <!-- Account Number -->
                                <div class="mb-3">
                                    <label class="form-label" for="account_number">Account Number</label>
                                    <input type="text" class="form-control" name="account_number" id="account_number"
                                        value="{{ old('account_number', $orderData->account_number ?? '') }}"
                                         />
                                </div>

                                <!-- Confirm Account Number -->
                                <div class="mb-3">
                                    <label class="form-label" for="confirm_account_number">Confirm Account
                                        Number</label>
                                    <input type="text" class="form-control" name="confirm_account_number"
                                        id="confirm_account_number"
                                        value="{{ old('confirm_account_number', $orderData->confirm_account_number ?? '') }}" />
                                    <div id="accountNumberError" class="text-danger" style="display: none;">
                                        Account numbers do not match!
                                    </div>
                                </div>

                                <!-- Cheque Start Number -->
                                <div class="mb-3">
                                    <label class="form-label" for="cheque_start_number">Cheque Start Number</label>
                                    <input type="text" class="form-control" name="cheque_start_number"
                                        id="cheque_start_number"
                                        value="{{ old('cheque_start_number', $orderData->cheque_start_number ?? '') }}" />
                                </div>

                                <!-- Cheque End Number -->
                                <div class="mb-3">
                                    <label class="form-label" for="cheque_end_number">Cheque End Number</label>
                                    <input type="text" class="form-control" name="cheque_end_number"
                                        id="cheque_end_number"
                                        value="{{ old('cheque_end_number', $orderData->cheque_end_number ?? '') }}" />
                                </div>

                                <!-- Cart Quantity -->
                                <div class="mb-3">
                                    <label class="form-label" for="cart_quantity">Cart Quantity</label>
                                    <input type="number" class="form-control" name="cart_quantity"
                                        id="cart_quantity"
                                        value="{{ old('cart_quantity', $orderData->cart_quantity ?? '') }}"
                                        required />
                                </div>

                                <!-- Voided Cheque File -->
                                <div class="mb-3">
                                    <label class="form-label" for="voided_cheque_file">Voided Cheque File</label>
                                    <input type="file" class="form-control" name="voided_cheque_file"
                                        id="voided_cheque_file" />
                                </div>

                                <!-- Company Logo -->
                                <div class="mb-3">
                                    <label class="form-label" for="company_logo">Company Logo</label>
                                    <input type="file" class="form-control" name="company_logo"
                                        id="company_logo" />
                                </div>

                                <!-- Vendor ID -->
                                <div class="mb-3">
                                    <label class="form-label" for="vendor_id">Vendor Name</label>
                                    <select class="form-control" name="vendor_id" id="vendor_id" required>
                                        <option value="">Select a Customer</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            @if ($user->role === 'vendor')
                                                <option value="{{ $user->id }}"
                                                    {{ old('vendor_id', $orderData->vendor_id ?? '') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->firstname }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Cheque Image -->
                                <div class="mb-3">
                                    <label class="form-label" for="cheque_img">Cheque Image</label>
                                    <input type="file" class="form-control" name="cheque_img" id="cheque_img" />
                                </div>

                                <!-- Order Status -->
                                <div class="mb-3">
                                    <label class="form-label" for="order_status">Order Status</label>
                                    @php
                                        $orderStatus = ['Completed', 'Pending', 'Processing', 'Cancelled'];
                                    @endphp
                                    <select class="form-control" name="order_status" id="order_status">
                                        <option value="">Select Status</option>
                                        @foreach ($orderStatus as $status)
                                            <option value="{{ $status }}"
                                                {{ old('state', $orderData->order_status ?? '') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Balance Status -->
                                <div class="mb-3">
                                    <label class="form-label" for="balance_status">Balance Status</label>
                                    @php
                                        $orderStatus = ['Completed', 'Pending', 'Processing', 'Cancelled'];
                                    @endphp
                                    <select class="form-control" name="balance_status" id="balance_status">
                                        <option value="">Select Status</option>
                                        @foreach ($orderStatus as $status)
                                            <option value="{{ $status }}"
                                                {{ old('state', $orderData->balance_status ?? '') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Reorder -->
                                <div class="mb-3">
                                    <label class="form-label" for="reorder">Reorder</label>
                                    <input type="checkbox" name="reorder" id="reorder"
                                        {{ old('reorder', $orderData->reorder ?? false) ? 'checked' : '' }} />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="resetOrder" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Real-time validation for account numbers
        $('#account_number, #confirm_account_number').on('keyup', function() {
            validateAccountNumbers();
        });

        // Form submission validation
        $('#orderForm').on('submit', function(e) {
            if (!validateAccountNumbers()) {
                e.preventDefault();
                $('#accountNumberError').show();
            }
        });

        function validateAccountNumbers() {
            const accountNumber = $('#account_number').val();
            const confirmAccountNumber = $('#confirm_account_number').val();

            if (accountNumber && confirmAccountNumber && accountNumber !== confirmAccountNumber) {
                $('#accountNumberError').show();
                $('#submitBtn').prop('disabled', true);
                return false;
            } else {
                $('#accountNumberError').hide();
                $('#submitBtn').prop('disabled', false);
                return true;
            }
        }
    });
</script>
