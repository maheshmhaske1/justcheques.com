@extends('layouts.app')
@section('content')
    <section class="cheque-order-section py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.show', $category->slug) }}">{{ $chequeCategoryName }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $chequeSubCategoryName }}</li>
                </ol>
            </nav>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (auth()->check())
                <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" id="chequeOrderForm">
                    @csrf

                    <div class="card shadow-sm">
                        <div class="card-header primary text-white">
                            <h2 class="mb-0">Order {{ $chequeSubCategoryName }}</h2>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Product Image -->
                                <div class="col-md-5 mb-4">
                                    <div class="product-image-container text-center">
                                        @if($subcategory->image)
                                            <img src="{{ asset('assets/front/img/' . $subcategory->image) }}"
                                                alt="{{ $subcategory->name }}"
                                                class="img-fluid main-product-image mb-3 border p-2">
                                        @else
                                            <img src="{{ asset('assets/images/default-cheque.jpg') }}"
                                                alt="{{ $subcategory->name }}"
                                                class="img-fluid main-product-image mb-3 border p-2">
                                        @endif

                                        <div class="thumbnail-container d-flex justify-content-center">
                                            @if($subcategory->image)
                                                <img src="{{ asset('assets/front/img/' . $subcategory->image) }}"
                                                    class="thumbnail-img active mr-2" onclick="changeMainImage(this)">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="product-price-box text-center p-3 mt-3 bg-light rounded">
                                        <strong class="text-muted">Price:</strong>
                                        <p><span id="previewPrice">Select quantity</span></p>
                                    </div>
                                </div>

                                <!-- Order Form -->
                                <div class="col-md-7">
                                    <!-- Customer Selection -->
                                    <div class="form-group">
                                        <label for="customer_id" class="font-weight-bold">Choose Customer <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="customer_id" id="customer_id" class="form-control" required>
                                                <option value="" selected disabled>Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    @if (Auth::user()->id == $customer->user_id)
                                                        <option value="{{ $customer->id }}"
                                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                            {{ $customer->company }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if (Auth::check() && Auth::user()->role === 'vendor')
                                                <div class="input-group-append">
                                                    <a href="{{ url('customer') }}" class="btn btn-outline-secondary">
                                                        <i class="fas fa-plus"></i> Add Customer
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="button" id="reorder-button" class="btn btn-secondary mb-3" data-toggle="modal"
                                        data-target="#reorder" style="display: none;">
                                        <i class="fas fa-redo-alt"></i> Reorder
                                    </button>

                                    <!-- Quantity Selection -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Quantity <span class="text-danger">*</span></label>
                                        @if($subcategory->pricing && $subcategory->pricing->count() > 0)
                                            <select name="quantity" id="quantity" class="form-control" required>
                                                <option value="" selected disabled>Select Quantity</option>
                                                @foreach($subcategory->pricing as $pricing)
                                                    @if($pricing->quantityTier)
                                                        <option value="{{ $pricing->quantityTier->quantity }}" data-price="{{ $pricing->price }}">
                                                            {{ $pricing->quantityTier->quantity }} cheques - ${{ number_format($pricing->price, 2) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <p class="text-danger">No quantity options available for this product</p>
                                        @endif
                                        <input type="hidden" name="quantity_option" id="quantity_option" value="21">
                                    </div>

                                    <!-- Item Selection -->
                                    @if($items && $items->count() > 0)
                                        <div class="form-group">
                                            <label for="subcategory_item_id" class="font-weight-bold">Select Item <span class="text-danger">*</span></label>
                                            <select name="subcategory_item_id" id="subcategory_item_id" class="form-control" required>
                                                <option value="" selected disabled>Select an item</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}" {{ old('subcategory_item_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <!-- Color Selection -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Select Colour <span
                                                class="text-danger">*</span></label>
                                        <div class="color-options row">
                                            @foreach($colors as $index => $color)
                                                <div class="col-4 col-md-3 mb-3">
                                                    <label class="color-option">
                                                        <input type="radio" name="color" value="{{ $color->value }}"
                                                            {{ $index == 0 ? 'checked' : '' }}
                                                            class="d-none">
                                                        @if($color->image)
                                                            <img src="{{ asset('assets/front/img/' . $color->image) }}"
                                                                alt="{{ $color->name }}"
                                                                class="color-image rounded border"
                                                                style="width: 100px; height: 100px; object-fit: cover; display: block;">
                                                        @else
                                                            <div class="rounded border d-flex align-items-center justify-content-center"
                                                                style="width: 100px; height: 100px; background-color: #f0f0f0;">
                                                                <span>{{ $color->name }}</span>
                                                            </div>
                                                        @endif
                                                        <span class="d-block text-center mt-1">{{ $color->name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Company Info -->
                                    <div class="form-group">
                                        <label for="company_info" class="font-weight-bold">Company Info</label>
                                        <textarea name="company_info" id="company_info" class="form-control" rows="4"
                                            placeholder="Enter your company information"></textarea>
                                        <small class="text-muted">Maximum 2000 characters</small>
                                    </div>

                                    <!-- Voided Cheque Section -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Voided Cheque Sample <span
                                                class="text-danger">*</span></label>
                                        <div class="alert alert-warning">
                                            <small>For accuracy please upload or fax a voided cheque. If you cannot supply a
                                                voided cheque we may request that you obtain a MICR SPEC SHEET from your
                                                bank.</small>
                                        </div>
                                        <select name="voided_cheque" id="voided_cheque" class="form-control"
                                            onchange="toggleFileInput()">
                                            <option value="" selected disabled>Please Select</option>
                                            <option value="upload">Upload Void Cheque</option>
                                            <option value="notVoidCheck">I Do Not Have A Void Cheque</option>
                                        </select>

                                        <div id="file-upload-field" class="mt-3" style="display: none;">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="voided_cheque_file"
                                                    id="voided_cheque_file">
                                                <label class="custom-file-label" for="voided_cheque_file">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bank Information (shown when not uploading void cheque) -->
                                    <div id="bank-info-section" class="hide_class">
                                        <h5 class="mt-4 mb-3 border-bottom pb-2">Bank Information</h5>

                                        <div class="form-group">
                                            <label for="institution_number" class="font-weight-bold">Institution Number
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="institution_number" id="institution_number"
                                                class="form-control" maxlength="3" placeholder="Enter 3 digits"
                                                pattern="\d{3}" title="Please enter exactly 3 digits">
                                        </div>

                                        <div class="form-group">
                                            <label for="transit_number" class="font-weight-bold">Transit Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="transit_number" id="transit_number"
                                                class="form-control" maxlength="5" placeholder="Enter 5 digits"
                                                pattern="\d{5}" title="Please enter exactly 5 digits">
                                        </div>

                                        <div class="form-group">
                                            <label for="account_number" class="font-weight-bold">Account Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="account_number" id="account_number"
                                                class="form-control" placeholder="Account Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="confirm_account_number" class="font-weight-bold">Confirm Account
                                                Number <span class="text-danger">*</span></label>
                                            <input type="text" name="confirm_account_number" id="confirm_account_number"
                                                class="form-control" placeholder="Confirm Account Number">
                                            <div id="account-number-error" style="color: red; display: none;">Account
                                                numbers do not match.</div>
                                        </div>
                                    </div>

                                    <!-- Cheque Numbers -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cheque_start_number" class="font-weight-bold">Cheque Start
                                                    Number <span class="text-danger">*</span></label>
                                                <input type="text" name="cheque_start_number" id="cheque_start_number"
                                                    class="form-control" placeholder="Start number" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select name="signature_line" id="signature_line" class="form-control">
                                                    <option value="" selected disabled>Signature Line</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select name="logo_alignment" id="logo_alignment" class="form-control">
                                                    <option value="" selected disabled>Cheque Logo Alignment</option>
                                                    <option value="center">Center</option>
                                                    <option value="left">Left</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Logo Upload -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Upload Your Logo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="company_logo"
                                                id="company_logo">
                                            <label class="custom-file-label" for="company_logo">Choose file</label>
                                        </div>
                                        <small class="text-muted">Optional - Upload your company logo to be printed on
                                            cheques</small>
                                    </div>

                                    <!-- Hidden Fields -->
                                    <input type="hidden" name="cart_quantity" id="cart_quantity" value="1">
                                    <input type="hidden" name="cheque_img" id="cheque_img"
                                        value="{{ $subcategory->image }}">
                                    <input type="hidden" name="vendor_id" id="vendor_id"
                                        value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="subcategory_id" id="subcategory_id"
                                        value="{{ $subcategory->id }}">

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" id="previewButton" class="btn btn-outline-primary"
                                            data-toggle="modal" data-target="#previewModal">
                                            <i class="fas fa-eye"></i> Preview Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Preview Modal -->
                <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Order Preview</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Left Column - Images -->
                                    <div class="col-md-5">
                                        <!-- Cheque Preview -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h6>Cheque Design</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <img id="chequeImgPreview"
                                                    src="{{ asset('assets/front/img/' . $subcategory->image) }}"
                                                    class="img-fluid border preview-image">
                                                <div class="mt-3">
                                                    <div class="color-preview d-inline-block"></div>
                                                    <span id="previewColor" class="ml-2 font-weight-bold"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Uploaded Files -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h6>Uploaded Files</h6>
                                            </div>
                                            <div class="card-body">
                                                <!-- Voided Cheque -->
                                                <div class="mb-3">
                                                    <h6>Voided Cheque</h6>
                                                    <img id="voidedChequeFilePreview" src=""
                                                        class="img-fluid border mb-2 preview-image"
                                                        style="display: none;">
                                                    <p id="voidedChequeText" class="small text-muted">No file uploaded</p>
                                                </div>

                                                <!-- Company Logo -->
                                                <div>
                                                    <h6>Company Logo</h6>
                                                    <img id="companyLogoPreview" src=""
                                                        class="img-fluid border mb-2 preview-image"
                                                        style="display: none;">
                                                    <p id="companyLogoText" class="small text-muted">No file uploaded</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Details -->
                                    <div class="col-md-7">
                                        <div class="preview-details">
                                            <!-- Product Information -->
                                            <div class="card mb-3">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">Product Information</h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-sm mb-0">
                                                        <tr>
                                                            <td class="font-weight-bold">Product:</td>
                                                            <td id="previewProductName">{{ $chequeSubCategoryName }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold">Category:</td>
                                                            <td>{{ $chequeCategoryName }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold">Quantity:</td>
                                                            <td id="previewQuantity"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold">Color:</td>
                                                            <td id="previewColorName"></td>
                                                        </tr>
                                                        <tr class="table-primary">
                                                            <td class="font-weight-bold">Total Price:</td>
                                                            <td class="font-weight-bold" id="previewTotalPrice"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Customer Information -->
                                            <div class="card mb-3">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">Customer Information</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p class="mb-1"><strong>Customer:</strong> <span id="previewCustomer"></span></p>
                                                    <p class="mb-0"><strong>Company Info:</strong></p>
                                                    <p class="text-muted small" id="previewCompanyInfo"></p>
                                                </div>
                                            </div>

                                            <!-- Bank Information -->
                                            <div class="card mb-3" id="previewBankCard">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">Bank Information</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p class="mb-1"><strong>Void Cheque:</strong> <span id="previewVoidCheque"></span></p>
                                                    <p class="mb-1" id="previewInstitution"></p>
                                                    <p class="mb-1" id="previewTransit"></p>
                                                    <p class="mb-0" id="previewAccount"></p>
                                                </div>
                                            </div>

                                            <!-- Cheque Details -->
                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">Cheque Details</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p class="mb-1"><strong>Starting Number:</strong> <span id="previewStartNumber"></span></p>
                                                    <p class="mb-1"><strong>Signature Lines:</strong> <span id="previewSignature"></span></p>
                                                    <p class="mb-0"><strong>Logo Alignment:</strong> <span id="previewAlignment"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-edit"></i> Edit Order
                                </button>
                                <button type="button" class="btn btn-primary" id="confirmOrderBtn">
                                    <i class="fas fa-check-circle"></i> Confirm Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reorder Modal -->
                <div class="modal fade" id="reorder" tabindex="-1" aria-labelledby="reorderLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reorderLabel">Reorder</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="reorderForm" method="POST" action="{{ route('order.reorder') }}">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="customer_id" id="reorder-customer-id">

                                    <div class="form-group">
                                        <label for="reorder-quantity">Quantity</label>
                                        @if($subcategory->pricing && $subcategory->pricing->count() > 0)
                                            <select name="quantity" id="reorder-quantity" class="form-control" required>
                                                @foreach($subcategory->pricing as $pricing)
                                                    @if($pricing->quantityTier)
                                                        <option value="{{ $pricing->quantityTier->quantity }}">
                                                            {{ $pricing->quantityTier->quantity }} cheques - ${{ number_format($pricing->price, 2) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="reorder-start-number">Cheque Start Number</label>
                                        <input type="number" name="cheque_start_number" id="reorder-start-number"
                                            class="form-control" min="1" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="reorder-form-button">Submit Reorder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <h4><i class="fas fa-exclamation-triangle"></i> Login Required</h4>
                    <p>Please <a href="{{ route('login') }}" class="alert-link">login</a> to place an order.</p>
                </div>
            @endif
        </div>
    </section>

    <style>
        .color-option {
            cursor: pointer;
            display: block;
            position: relative;
            margin-bottom: 10px;
        }

        .color-option input:checked + img,
        .color-option input:checked + div {
            border-color: #007bff !important;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        }

        .color-option:hover img,
        .color-option:hover div {
            transform: scale(1.05);
            transition: transform 0.2s;
        }

        .hide_class {
            display: none;
        }

        .preview-image {
            max-width: 100%;
            max-height: 300px;
        }

        .color-preview {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ccc;
        }

        .thumbnail-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #ddd;
            padding: 5px;
        }

        .thumbnail-img:hover,
        .thumbnail-img.active {
            border-color: #007bff;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Pricing data from backend
        const pricingData = {
            @foreach($subcategory->pricing as $pricing)
                @if($pricing->quantityTier)
                    {{ $pricing->quantityTier->quantity }}: {{ $pricing->price }},
                @endif
            @endforeach
        };

        // Quantity steps based on available pricing
        const quantitySteps = [{{ implode(', ', $quantityTiers->pluck('quantity')->toArray()) }}];

        // Toggle file input based on void cheque selection
        function toggleFileInput() {
            const voidedCheque = document.getElementById('voided_cheque').value;
            const fileUploadField = document.getElementById('file-upload-field');
            const bankInfoSection = document.getElementById('bank-info-section');

            if (voidedCheque === 'upload') {
                fileUploadField.style.display = 'block';
                bankInfoSection.classList.add('hide_class');
            } else if (voidedCheque === 'notVoidCheck') {
                fileUploadField.style.display = 'none';
                bankInfoSection.classList.remove('hide_class');
            }
        }

        // Change main image
        function changeMainImage(element) {
            const mainImage = document.querySelector('.main-product-image');
            mainImage.src = element.src;

            // Update active thumbnail
            document.querySelectorAll('.thumbnail-img').forEach(img => {
                img.classList.remove('active');
            });
            element.classList.add('active');
        }

        // Update price based on quantity
        function updatePrice(quantity) {
            let price = 0;

            // Find exact match or closest price
            if (pricingData[quantity]) {
                price = pricingData[quantity];
            } else {
                // Find closest lower quantity
                const availableQuantities = Object.keys(pricingData).map(Number).sort((a, b) => a - b);
                for (let i = availableQuantities.length - 1; i >= 0; i--) {
                    if (availableQuantities[i] <= quantity) {
                        price = pricingData[availableQuantities[i]];
                        break;
                    }
                }
            }

            document.getElementById('previewPrice').textContent = '$' + parseFloat(price).toFixed(2);
            return price;
        }

        // Adjust quantity by steps
        function adjustQuantity(direction) {
            const quantityInput = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityInput.value);
            let currentIndex = quantitySteps.indexOf(currentQuantity);

            if (currentIndex === -1) {
                // Find closest step
                for (let i = 0; i < quantitySteps.length; i++) {
                    if (quantitySteps[i] >= currentQuantity) {
                        currentIndex = i;
                        break;
                    }
                }
                if (currentIndex === -1) currentIndex = quantitySteps.length - 1;
            }

            if (direction === 'plus' && currentIndex < quantitySteps.length - 1) {
                currentIndex++;
            } else if (direction === 'minus' && currentIndex > 0) {
                currentIndex--;
            }

            const newQuantity = quantitySteps[currentIndex];
            quantityInput.value = newQuantity;
            updatePrice(newQuantity);
        }

        // Validate quantity
        function validateQuantity() {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value);

            if (quantity < quantitySteps[0]) {
                quantity = quantitySteps[0];
            }

            // Snap to closest allowed quantity
            let closestQuantity = quantitySteps[0];
            let minDiff = Math.abs(quantity - closestQuantity);

            for (let step of quantitySteps) {
                const diff = Math.abs(quantity - step);
                if (diff < minDiff) {
                    minDiff = diff;
                    closestQuantity = step;
                }
            }

            quantityInput.value = closestQuantity;
            updatePrice(closestQuantity);
        }

        // Check account number match
        function checkAccountNumber() {
            const accountNumber = document.getElementById('account_number').value;
            const confirmAccountNumber = document.getElementById('confirm_account_number').value;
            const errorDiv = document.getElementById('account-number-error');

            if (accountNumber && confirmAccountNumber) {
                if (accountNumber !== confirmAccountNumber) {
                    errorDiv.style.display = 'block';
                    document.getElementById('confirm_account_number').classList.add('is-invalid');
                    return false;
                } else {
                    errorDiv.style.display = 'none';
                    document.getElementById('confirm_account_number').classList.remove('is-invalid');
                    return true;
                }
            }
            return true;
        }

        // Preview file helper
        function previewFile(inputElement, imgId, textId) {
            const file = inputElement.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(imgId).src = e.target.result;
                    document.getElementById(imgId).style.display = 'block';
                    document.getElementById(textId).style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById(imgId).style.display = 'none';
                document.getElementById(textId).style.display = 'block';
            }
        }

        // Update preview data
        function updatePreviewData() {
            // Customer
            const customerSelect = document.getElementById('customer_id');
            const customerText = customerSelect.options[customerSelect.selectedIndex]?.text || 'Not selected';
            document.getElementById('previewCustomer').textContent = customerText;

            // Quantity and Price
            const quantitySelect = document.getElementById('quantity');
            const selectedOption = quantitySelect.options[quantitySelect.selectedIndex];
            const quantity = quantitySelect.value;
            const price = selectedOption ? selectedOption.getAttribute('data-price') : 0;

            document.getElementById('previewQuantity').textContent = quantity + ' cheques';
            document.getElementById('previewTotalPrice').textContent = '$' + parseFloat(price || 0).toFixed(2);

            // Color
            const selectedColor = document.querySelector('input[name="color"]:checked');
            if (selectedColor) {
                const colorName = selectedColor.parentElement.querySelector('span').textContent;
                document.getElementById('previewColorName').textContent = colorName;
                document.getElementById('previewColor').textContent = colorName;

                // Color preview dot
                const colorPreview = document.querySelector('.color-preview');
                colorPreview.style.backgroundColor = selectedColor.value;
            }

            // Company Info
            const companyInfo = document.getElementById('company_info').value || 'Not provided';
            document.getElementById('previewCompanyInfo').textContent = companyInfo;

            // Bank Information
            const voidChequeOption = document.getElementById('voided_cheque').value;
            if (voidChequeOption === 'upload') {
                document.getElementById('previewVoidCheque').textContent = 'File uploaded';
                document.getElementById('previewInstitution').style.display = 'none';
                document.getElementById('previewTransit').style.display = 'none';
                document.getElementById('previewAccount').style.display = 'none';
            } else if (voidChequeOption === 'notVoidCheck') {
                document.getElementById('previewVoidCheque').textContent = 'Manual entry';

                const institution = document.getElementById('institution_number').value;
                const transit = document.getElementById('transit_number').value;
                const account = document.getElementById('account_number').value;

                document.getElementById('previewInstitution').innerHTML = '<strong>Institution:</strong> ' + (institution || 'Not provided');
                document.getElementById('previewTransit').innerHTML = '<strong>Transit:</strong> ' + (transit || 'Not provided');
                document.getElementById('previewAccount').innerHTML = '<strong>Account:</strong> ' + (account ? '****' + account.slice(-4) : 'Not provided');

                document.getElementById('previewInstitution').style.display = 'block';
                document.getElementById('previewTransit').style.display = 'block';
                document.getElementById('previewAccount').style.display = 'block';
            } else {
                document.getElementById('previewBankCard').style.display = 'none';
            }

            // Cheque Details
            const startNumber = document.getElementById('cheque_start_number').value || 'Not provided';
            document.getElementById('previewStartNumber').textContent = startNumber;

            const signatureLine = document.getElementById('signature_line').value || 'Not selected';
            document.getElementById('previewSignature').textContent = signatureLine;

            const logoAlignment = document.getElementById('logo_alignment').value || 'Not selected';
            document.getElementById('previewAlignment').textContent = logoAlignment;

            // File previews
            previewFile(document.getElementById('voided_cheque_file'), 'voidedChequeFilePreview', 'voidedChequeText');
            previewFile(document.getElementById('company_logo'), 'companyLogoPreview', 'companyLogoText');
        }

        // Document ready
        $(document).ready(function() {
            // Quantity dropdown change
            $('#quantity').on('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                const quantity = selectedOption.value;

                if (price) {
                    document.getElementById('previewPrice').textContent = '$' + parseFloat(price).toFixed(2);
                }
            });

            // File input labels
            $('.custom-file-input').on('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
                $(this).next('.custom-file-label').text(fileName);
            });

            // Account number validation
            $('#account_number, #confirm_account_number').on('keyup', function() {
                checkAccountNumber();
            });

            // Preview button
            $('#previewButton').click(function(e) {
                e.preventDefault();
                updatePreviewData();
                $('#previewModal').modal('show');
            });

            // Confirm order
            $('#confirmOrderBtn').click(function() {
                // Validate account numbers if bank info is shown
                const bankInfoSection = document.getElementById('bank-info-section');
                if (!bankInfoSection.classList.contains('hide_class')) {
                    if (!checkAccountNumber()) {
                        alert('Please ensure account numbers match.');
                        return;
                    }
                }

                // Submit form
                document.getElementById('chequeOrderForm').submit();
            });

            // Check for reorder on customer selection
            $('#customer_id').change(function() {
                const customerId = $(this).val();
                const subcategoryId = {{ $subcategory->id }};

                if (customerId) {
                    fetch(`/check-orders/${customerId}/${subcategoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.hasOrders) {
                                $('#reorder-button').show();
                                $('#reorder-button').data('customer-id', customerId);
                                $('#reorder-customer-id').val(customerId);
                            } else {
                                $('#reorder-button').hide();
                            }
                        });
                }
            });

            // Submit reorder
            $('#reorder-form-button').click(function() {
                $('#reorderForm').submit();
            });
        });
    </script>
@endsection
