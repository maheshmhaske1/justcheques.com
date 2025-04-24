@extends('layouts.app')
@section('content')
    <section class="cheque-order-section py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/computerCheques">{{ $chequeCategoryName }}</a></li>
                    <li class="breadcrumb-item"><a href="/chequeOnTop">{{ $chequeSubCategoryName }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $chequeList->chequeName }}</li>
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
                            <h2 class="mb-0">Order {{ $chequeList->chequeName }}</h2>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Product Image -->
                                <div class="col-md-5 mb-4">
                                    <div class="product-image-container text-center">
                                        <img src="{{ asset('assets/front/img/' . $chequeList->img) }}"
                                            alt="{{ $chequeList->chequeName }}"
                                            class="img-fluid main-product-image mb-3 border p-2">

                                        <div class="thumbnail-container d-flex justify-content-center">
                                            <img src="{{ asset('assets/front/img/' . $chequeList->img) }}"
                                                class="thumbnail-img active mr-2" onclick="changeMainImage(this)">
                                            <!-- Add more thumbnails if available -->
                                        </div>
                                    </div>

                                    <div class="product-price-box text-center p-3 mt-3 bg-light rounded">
                                        <span class="text-muted">Price:</span>
                                        <span class="h4 text-primary ml-2"
                                            id="dynamic-price">${{ $chequeList->price }}</span>
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

                                    <button type="button" id="reorder-button" class="btn btn-info mb-3" data-toggle="modal"
                                        data-target="#reorder" style="display: none;">
                                        <i class="fas fa-redo-alt"></i> Reorder
                                    </button>

                                    <!-- Quantity Selection -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Quantity <span class="text-danger">*</span></label>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-secondary quantity-btn"
                                                id="quantity-minus">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantity" id="quantity"
                                                class="form-control text-center mx-2" value="50" min="50"
                                                step="50" required style="max-width: 80px;">
                                            <button type="button" class="btn btn-outline-secondary quantity-btn"
                                                id="quantity-plus">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <span class="mx-3">cheques</span>
                                        </div>
                                        <input type="hidden" name="quantity_option" id="quantity_option" value="21">
                                    </div>

                                    <!-- Color Selection -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Select Colour <span
                                                class="text-danger">*</span></label>
                                        <div class="color-options row">
                                            <div class="col-4 col-md-3 mb-3">
                                                <label class="color-option">
                                                    <input type="radio" name="color" value="Purple" checked
                                                        class="d-none">
                                                    <img src="{{ asset('assets/front/img/Burgundy.jpg') }}" alt="Burgundy"
                                                        class="img-fluid rounded border">
                                                    <span class="d-block text-center mt-1">Burgundy</span>
                                                </label>
                                            </div>
                                            <div class="col-4 col-md-3 mb-3">
                                                <label class="color-option">
                                                    <input type="radio" name="color" value="Blue" class="d-none">
                                                    <img src="{{ asset('assets/front/img/Blue.jpg') }}" alt="Blue"
                                                        class="img-fluid rounded border">
                                                    <span class="d-block text-center mt-1">Blue</span>
                                                </label>
                                            </div>
                                            <div class="col-4 col-md-3 mb-3">
                                                <label class="color-option">
                                                    <input type="radio" name="color" value="Green" class="d-none">
                                                    <img src="{{ asset('assets/front/img/green.jpg') }}" alt="Green"
                                                        class="img-fluid rounded border">
                                                    <span class="d-block text-center mt-1">Green</span>
                                                </label>
                                            </div>
                                            <div class="col-4 col-md-3 mb-3">
                                                <label class="color-option">
                                                    <input type="radio" name="color" value="Tan" class="d-none">
                                                    <img src="{{ asset('assets/front/img/tan.jpg') }}" alt="Tan"
                                                        class="img-fluid rounded border">
                                                    <span class="d-block text-center mt-1">Tan</span>
                                                </label>
                                            </div>
                                            <div class="col-4 col-md-3 mb-3">
                                                <label class="color-option">
                                                    <input type="radio" name="color" value="gray" class="d-none">
                                                    <img src="{{ asset('assets/front/img/grey.jpg') }}" alt="Grey"
                                                        class="img-fluid rounded border">
                                                    <span class="d-block text-center mt-1">Grey</span>
                                                </label>
                                            </div>
                                            <div class="col-4 col-md-3 mb-3">
                                                <label class="color-option">
                                                    <input type="radio" name="color" value="purple" class="d-none">
                                                    <img src="{{ asset('assets/front/img/purple.jpg') }}" alt="Purple"
                                                        class="img-fluid rounded border">
                                                    <span class="d-block text-center mt-1">Purple</span>
                                                </label>
                                            </div>
                                            <div class="col-4 col-md-3 mb-3">
                                                <label class="color-option">
                                                    <input type="radio" name="color" value="orange" class="d-none">
                                                    <img src="{{ asset('assets/front/img/orange.jpg') }}" alt="Orange"
                                                        class="img-fluid rounded border">
                                                    <span class="d-block text-center mt-1">Orange</span>
                                                </label>
                                            </div>
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
                                            <input type="text" id="account_number" class="form-control"
                                                placeholder="Account Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="confirm_account_number" class="font-weight-bold">Confirm Account
                                                Number <span class="text-danger">*</span></label>
                                            <input type="text" id="confirm_account_number" class="form-control"
                                                placeholder="Confirm Account Number">
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
                                                    class="form-control" placeholder="Start number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cheque_end_number" class="font-weight-bold">Cheque End Number
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="cheque_end_number" id="cheque_end_number"
                                                    class="form-control" placeholder="End number">
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
                                        value="{{ $chequeList->img }}">
                                    <input type="hidden" name="vendor_id" id="vendor_id"
                                        value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="cheque_category_id" id="cheque_category_id"
                                        value="{{ $chequeList->id }}">

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" id="previewButton" class="btn btn-outline-primary"
                                            data-toggle="modal" data-target="#previewModal">
                                            <i class="fas fa-eye"></i> Preview Order
                                        </button>
                                        {{-- <button type="submit" class="btn btn-primary"
                                    onclick="return checkAccountNumber();">
                                    <i class="fas fa-check-circle"></i> Place Order
                                </button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Preview Modal -->
                <div class="modal" id="previewModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Order Preview</h5>
                                <!-- <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button> -->
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
                                                    src="{{ asset('assets/front/img/' . $chequeList->img) }}"
                                                    class="img-fluid border" style="max-height: 250px;">
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
                                                        class="img-fluid border mb-2"
                                                        style="max-height: 150px; display: none;">
                                                    <p id="voidedChequeText" class="small text-muted">No file uploaded</p>
                                                </div>

                                                <!-- Company Logo -->
                                                <div>
                                                    <h6>Company Logo</h6>
                                                    <img id="companyLogoPreview" src=""
                                                        class="img-fluid border mb-2"
                                                        style="max-height: 150px; display: none;">
                                                    <p id="companyLogoText" class="small text-muted">No file uploaded</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Details -->
                                    <div class="col-md-7">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h6>Order Details</h6>
                                            </div>
                                            <div class="card-body">
                                                <!-- Customer Info -->
                                                <div class="mb-3">
                                                    <h6 class="border-bottom pb-2">Customer Information</h6>
                                                    <p><strong>Customer:</strong> <span id="previewCustomer">Not
                                                            selected</span></p>
                                                    <p><strong>Company Info:</strong></p>
                                                    <div id="previewCompanyInfo"
                                                        class="border p-2 bg-light rounded small"></div>
                                                </div>

                                                <!-- Order Details -->
                                                <div class="mb-3">
                                                    <h6 class="border-bottom pb-2">Order Specifications</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Product:</strong> {{ $chequeList->chequeName }}</p>
                                                            <p><strong>Quantity:</strong> <span id="previewQuantity">Not
                                                                    selected</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Price:</strong> <span
                                                                    id="previewPrice">${{ $chequeList->price }}</span></p>
                                                            <p><strong>Color:</strong> <span id="previewColorText">Not
                                                                    selected</span></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bank Info -->
                                                <div class="mb-3">
                                                    <h6 class="border-bottom pb-2">Bank Information</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Void Cheque:</strong> <span
                                                                    id="previewVoidOption">Not selected</span></p>
                                                            <p><strong>Institution #:</strong> <span
                                                                    id="previewInstitutionNumber">Not provided</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Transit #:</strong> <span
                                                                    id="previewTransitNumber">Not provided</span></p>
                                                            <p><strong>Account #:</strong> <span
                                                                    id="previewAccountNumber">Not provided</span></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cheque Numbers -->
                                                <div class="mb-3">
                                                    <h6 class="border-bottom pb-2">Cheque Numbers</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Start #:</strong> <span
                                                                    id="previewChequeStartNumber">Not provided</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>End #:</strong> <span
                                                                    id="previewChequeEndNumber">Not provided</span></p>
                                                        </div>
                                                    </div>
                                                    <p><strong>Range:</strong> <span id="previewChequeRange">Not
                                                            provided</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" id="editOrderBtn" data-dismiss="modal">
                                    <i class="fas fa-edit mr-1"></i> Edit Order
                                </button> --}}
                                <button type="button" class="btn btn-primary" id="confirmOrderBtn">
                                    <i class="fas fa-check mr-1"></i> Confirm Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reorder Modal -->
                <div class="modal" id="reorder" tabindex="-1" role="dialog" aria-labelledby="reorderModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="reorderModalLabel">Reorder Cheques</h5>
                                <!-- <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button> -->
                            </div>
                            <div class="modal-body">
                                <form id="reorderForm">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-outline-secondary quantity-btn"
                                                    id="reorder-quantity-minus">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantity" id="reorder-quantity"
                                                    class="form-control text-center mx-2" value="50" min="50"
                                                    step="50" required style="max-width: 80px;">
                                                <button type="button" class="btn btn-outline-secondary quantity-btn"
                                                    id="reorder-quantity-plus">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <span class="mx-3">cheques</span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="reorderChequeStartNumber">Cheque Start Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        id="reorderChequeStartNumber" name="cheque_start_number"
                                                        placeholder="Start number" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="reorderChequeEndNumber">Cheque End Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        id="reorderChequeEndNumber" name="cheque_end_number"
                                                        placeholder="End number" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-check"></i> Place Reorder
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Login Required Alert -->
                <div class="alert alert-warning text-center py-4">
                    <h4><i class="fas fa-exclamation-triangle mr-2"></i>Login Required</h4>
                    <p class="mb-3">You need to be logged in to place an order.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login Now
                    </a>
                </div>
            @endif

            <!-- Product Details Tabs -->
            <div class="mt-5">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab"
                            aria-controls="reviews" aria-selected="true">
                            Customer Reviews
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="faq-tab" data-toggle="tab" href="#faq" role="tab"
                            aria-controls="faq" aria-selected="false">
                            Frequently Asked Questions
                        </a>
                    </li>
                </ul>

                <div class="tab-content p-3 border border-top-0 rounded-bottom" id="productTabsContent">
                    <!-- Reviews Tab -->
                    <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="review-container">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="overallRating">
                                    <span class="font-weight-bold mr-2">Overall Rating:</span>
                                    <span class="stars">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </span>
                                    <span class="ml-2">5.0 (12 reviews)</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-pen"></i> Write a Review
                                </a>
                            </div>

                            <div class="review-list">
                                <div class="review-item mb-4 pb-3 border-bottom">
                                    <div class="stars mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <h5 class="review-title">I am very impressed</h5>
                                    <div class="review-text">
                                        Hi, This is my first time ordering with your company, and I wanted to let you know
                                        that your service is exceptional!! Thank you!
                                        I ordered Wednesday, and I have the cheques in my hand today – Monday!! WOW!
                                        Great job, I am very happy with the product, and the service was AWESOME!
                                        I will be sure to recommend you to others, as I am very impressed.
                                    </div>
                                    <div class="review-meta text-muted mt-2">
                                        <span class="review-author">By: Ann H.</span> |
                                        <span class="review-date">Date: October 03, 2018</span>
                                    </div>
                                </div>

                                <div class="review-item mb-4 pb-3 border-bottom">
                                    <div class="stars mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <h5 class="review-title">Good product for the price</h5>
                                    <div class="review-text">
                                        Cheques were printed correctly and arrived super fast!
                                    </div>
                                    <div class="review-meta text-muted mt-2">
                                        <span class="review-author">By: Mukash E.</span> |
                                        <span class="review-date">Date: August 08, 2018</span>
                                    </div>
                                </div>

                                <a href="#" class="btn btn-outline-primary btn-block mt-3">
                                    <i class="fas fa-comments"></i> Read More Reviews
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Tab -->
                    <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                        <div id="accordion">
                            <div class="card mb-2">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            <i class="fas fa-question-circle text-primary mr-2"></i> Are these cheques
                                            compatible with quickbooks software?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        Yes, they are 100% compatible with quickbooks and with all popular accounting
                                        programs.
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="fas fa-question-circle text-primary mr-2"></i> How many cheques on a
                                            page?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        This is a single cheque per page with stubs. Looking for 3 per page? Click here: <a
                                            href="#">Three per page cheques</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Add more FAQ items as needed -->

                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fas fa-question-circle"></i> View All FAQs
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .cheque-order-section {
            background-color: #f8f9fa;
        }

        .product-image-container {
            position: relative;
        }

        .main-product-image {
            max-height: 400px;
            object-fit: contain;
        }

        .thumbnail-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #ddd;
            border-radius: 4px;
        }

        .thumbnail-img.active {
            border-color: #007bff;
        }

        .thumbnail-img:hover {
            border-color: #0056b3;
        }

        .product-price-box {
            border-left: 4px solid #007bff;
        }

        .color-option {
            cursor: pointer;
            transition: all 0.3s;
        }

        .color-option:hover {
            transform: scale(1.05);
        }

        .color-option img {
            transition: all 0.3s;
        }

        .color-option input:checked+img {
            border: 2px solid #007bff !important;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-bottom: 3px solid #007bff;
        }

        .review-item {
            transition: all 0.3s;
        }

        .review-item:hover {
            background-color: #f8f9fa;
        }

        #bank-info-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #6c757d;
        }

        .color-preview {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ddd;
        }

        @media (max-width: 768px) {
            .main-product-image {
                max-height: 300px;
            }
        }

        /* Preview Modal Styles */
        #previewModal .modal-body {
            max-height: 80vh;
            overflow-y: auto;
        }

        .color-preview {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ddd;
            display: inline-block;
        }

        .img-preview {
            max-width: 100%;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #previewModal .modal-dialog {
                margin: 0.5rem auto;
            }

            #previewModal .modal-body {
                max-height: none;
                overflow-y: visible;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            // Reorder quantity controls
            $('#reorder-quantity-plus').click(function() {
                let currentVal = parseInt($('#reorder-quantity').val());
                let newVal = currentVal + 50;
                $('#reorder-quantity').val(newVal);
            });

            $('#reorder-quantity-minus').click(function() {
                let currentVal = parseInt($('#reorder-quantity').val());
                if (currentVal > 50) {
                    $('#reorder-quantity').val(currentVal - 50);
                }
            });

            // Handle reorder form submission
            $('#reorderForm').submit(function(e) {
                e.preventDefault();

                const customerId = $('#reorder-button').data('customer-id');
                const formData = $(this).serialize();

                // Show loading state
                const submitBtn = $(this).find('[type="submit"]');
                submitBtn.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Processing...');

                $.ajax({
                    url: `/reorder/${customerId}`,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#reorder').modal('hide');
                            // Show success message
                            alert('Reorder placed successfully!');
                            // Optional: redirect or refresh
                            window.location.href = "{{ route('success') }}";
                        } else {
                            alert('Error: ' + (response.message || 'Unknown error occurred'));
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Failed to place reorder. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).join('\n');
                        }
                        alert(errorMsg);
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(
                            '<i class="fas fa-check"></i> Place Reorder');
                    }
                });
            });

            // When customer changes, check for reorder eligibility
            $('#customer_id').change(function() {
                const customerId = $(this).val();
                if (customerId) {
                    $.get(`/check-orders/${customerId}`, function(data) {
                        if (data.hasOrders) {
                            $('#reorder-button').show().data('customer-id', customerId);
                        } else {
                            $('#reorder-button').hide();
                        }
                    });
                } else {
                    $('#reorder-button').hide();
                }
            });
        });
    </script>

    <script>
        // JavaScript functions would go here
        // Similar to your existing JS but updated for the new UI

        function toggleFileInput() {
            var selectBox = document.getElementById('voided_cheque');
            var fileUploadField = document.getElementById('file-upload-field');
            var bankInfoSection = document.getElementById('bank-info-section');

            if (selectBox.value === 'upload') {
                fileUploadField.style.display = 'block';
                bankInfoSection.style.display = 'none';
            } else if (selectBox.value === 'notVoidCheck') {
                fileUploadField.style.display = 'none';
                bankInfoSection.style.display = 'block';
            } else {
                fileUploadField.style.display = 'none';
                bankInfoSection.style.display = 'none';
            }
        }

        function changeMainImage(element) {
            var mainImage = document.querySelector('.main-product-image');
            var thumbnails = document.querySelectorAll('.thumbnail-img');

            // Update main image
            mainImage.src = element.src;

            // Update active thumbnail
            thumbnails.forEach(function(thumb) {
                thumb.classList.remove('active');
            });
            element.classList.add('active');
        }

        // Update file input labels
        document.querySelectorAll('.custom-file-input').forEach(function(input) {
            input.addEventListener('change', function() {
                var fileName = this.files[0] ? this.files[0].name : "Choose file";
                var label = this.nextElementSibling;
                label.textContent = fileName;
            });
        });

        // Preview modal setup
        document.addEventListener('DOMContentLoaded', function() {
            // Preview button click handler
            document.getElementById('previewButton').addEventListener('click', function(e) {
                e.preventDefault();
                updatePreviewData();
                $('#previewModal').modal('show');
            });

            // File input change handlers
            document.getElementById('voided_cheque_file').addEventListener('change', function() {
                previewFile(this, 'voidedChequeFilePreview', 'voidedChequeText');
            });

            document.getElementById('company_logo').addEventListener('change', function() {
                previewFile(this, 'companyLogoPreview', 'companyLogoText');
            });
        });

        function updatePreviewData() {
            // Customer Information
            const customerSelect = document.getElementById('customer_id');
            document.getElementById('previewCustomer').textContent =
                customerSelect.selectedIndex > 0 ? customerSelect.options[customerSelect.selectedIndex].text :
                "Not selected";

            // Order Details
            const quantitySelect = document.getElementById('quantity');
            document.getElementById('previewQuantity').textContent =
                quantitySelect.options[quantitySelect.selectedIndex].text;

            // Color Selection
            const selectedColor = document.querySelector('input[name="color"]:checked');
            if (selectedColor) {
                const colorLabel = selectedColor.closest('.color-option').querySelector('span').textContent.trim();
                document.getElementById('previewColor').textContent = colorLabel;
                document.getElementById('previewColorText').textContent = colorLabel;

                // Update color preview dot
                const colorDot = document.querySelector('.color-preview');
                colorDot.style.backgroundColor = getColorHex(selectedColor.value);

                // Update cheque image preview
                updateChequeImagePreview(selectedColor.value);
            }

            // Company Info
            document.getElementById('previewCompanyInfo').textContent =
                document.getElementById('company_info').value.trim() || "Not provided";

            // Void Cheque Option
            const voidOption = document.getElementById('voided_cheque');
            document.getElementById('previewVoidOption').textContent =
                voidOption.options[voidOption.selectedIndex].text || "Not selected";

            // Bank Information
            document.getElementById('previewInstitutionNumber').textContent =
                document.getElementById('institution_number').value || "Not provided";
            document.getElementById('previewTransitNumber').textContent =
                document.getElementById('transit_number').value || "Not provided";

            // Account Number (masked)
            const accountNumber = document.getElementById('account_number').value;
            document.getElementById('previewAccountNumber').textContent =
                accountNumber ? '•'.repeat(accountNumber.length) : "Not provided";

            // Cheque Numbers
            const startNum = document.getElementById('cheque_start_number').value;
            const endNum = document.getElementById('cheque_end_number').value;
            document.getElementById('previewChequeStartNumber').textContent = startNum || "Not provided";
            document.getElementById('previewChequeEndNumber').textContent = endNum || "Not provided";
            document.getElementById('previewChequeRange').textContent =
                (startNum && endNum) ? `${startNum} to ${endNum}` : "Not provided";

            // File uploads
            previewFile(document.getElementById('voided_cheque_file'), 'voidedChequeFilePreview', 'voidedChequeText');
            previewFile(document.getElementById('company_logo'), 'companyLogoPreview', 'companyLogoText');
        }

        function updateChequeImagePreview(colorValue) {
            const colorImages = {
                'Purple': 'purple.jpg',
                'Blue': 'Blue.jpg',
                'Green': 'green.jpg',
                'Tan': 'tan.jpg',
                'gray': 'grey.jpg',
                'Grey': 'grey.jpg',
                'Burgundy': 'Burgundy.jpg',
                'Orange': 'orange.jpg'
            };

            if (colorImages[colorValue]) {
                const imgPath = "{{ asset('assets/front/img/') }}/" + colorImages[colorValue];
                document.getElementById('chequeImgPreview').src = imgPath;
            }
        }

        function previewFile(inputElement, imgId, textId) {
            const previewImg = document.getElementById(imgId);
            const previewText = document.getElementById(textId);

            if (inputElement.files && inputElement.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    previewText.textContent = inputElement.files[0].name;
                };
                reader.readAsDataURL(inputElement.files[0]);
            } else {
                previewImg.style.display = 'none';
                previewText.textContent = 'No file uploaded';
            }
        }

        function getColorHex(colorName) {
            const colorMap = {
                'Burgundy': '#800020',
                'Blue': '#0000FF',
                'Green': '#008000',
                'Tan': '#D2B48C',
                'Grey': '#808080',
                'Purple': '#800080',
                'Orange': '#FFA500'
            };
            return colorMap[colorName] || '#800080';
        }


        // Reorder functionality
        document.getElementById('customer_id').addEventListener('change', function() {
            var customerId = this.value;
            var reorderButton = document.getElementById('reorder-button');

            if (customerId) {
                // Check if customer has previous orders
                fetch(`/check-orders/${customerId}`)
                    .then(response => response.json())
                    .then(data => {
                        reorderButton.style.display = data.hasOrders ? 'block' : 'none';
                        reorderButton.dataset.customerId = customerId;
                    });
            } else {
                reorderButton.style.display = 'none';
            }
        });

        // Submit reorder form
        document.getElementById('submitReorderForm').addEventListener('click', function() {
            var customerId = document.getElementById('reorder-button').dataset.customerId;
            var formData = new FormData(document.getElementById('reorderForm'));

            fetch(`/reorder/${customerId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {

                    console.log(data)
                    if (data.success) {
                        window.location.href = "{{ route('success') }}";
                    } else if (data.errors) {
                        // Display validation errors
                        let errorString = "";
                        for (const field in data.errors) {
                            errorString += `${field}: ${data.errors[field].join(", ")}\n`;
                        }
                        alert(errorString);
                    }
                });
        });
    </script>
    <script>
        function checkAccountNumber() {
            var accountNumber = document.getElementById('account_number').value;
            var confirmAccountNumber = document.getElementById('confirm_account_number').value;
            var errorElement = document.getElementById('account-number-error'); // Fix: use getElementById, not jQuery

            if (accountNumber !== confirmAccountNumber) {
                errorElement.style.display = 'block';
                document.getElementById('confirm_account_number').classList.add('is-invalid');
                return false;
            } else {
                errorElement.style.display = 'none';
                document.getElementById('confirm_account_number').classList.remove('is-invalid');
                return true;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('confirm_account_number').addEventListener('keyup', checkAccountNumber);
            document.getElementById('account_number').addEventListener('keyup', checkAccountNumber);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Define price tiers (quantity: additional price)
            const priceTiers = {
                50: 69,
                100: 79,
                250: 139,
                500: 219,
                1000: 319,
                2000: 479,
                2500: 539,
                3000: 599,
                4000: 759,
                5000: 929,
                10000: 1499,
                15000: 1799
            };

            // Get elements
            const quantityInput = document.getElementById('quantity');
            const minusBtn = document.getElementById('quantity-minus');
            const plusBtn = document.getElementById('quantity-plus');
            const priceDisplay = document.getElementById('dynamic-price');
            const quantityOption = document.getElementById('quantity_option');
            const basePrice = {{ $chequeList->price }};

            // Initialize
            updatePrice(parseInt(quantityInput.value));

            // Event listeners
            minusBtn.addEventListener('click', decreaseQuantity);
            plusBtn.addEventListener('click', increaseQuantity);
            quantityInput.addEventListener('change', validateQuantity);

            function decreaseQuantity() {
                let currentQty = parseInt(quantityInput.value);
                const quantities = Object.keys(priceTiers).map(Number).sort((a, b) => a - b);

                // Find next lower tier
                for (let i = quantities.length - 1; i >= 0; i--) {
                    if (quantities[i] < currentQty) {
                        quantityInput.value = quantities[i];
                        updatePrice(quantities[i]);
                        return;
                    }
                }

                // If we get here, we're at minimum quantity
                if (currentQty > 50) {
                    quantityInput.value = 50;
                    updatePrice(50);
                }
            }

            function increaseQuantity() {
                let currentQty = parseInt(quantityInput.value);
                const quantities = Object.keys(priceTiers).map(Number).sort((a, b) => a - b);

                // Find next higher tier
                for (let i = 0; i < quantities.length; i++) {
                    if (quantities[i] > currentQty) {
                        quantityInput.value = quantities[i];
                        updatePrice(quantities[i]);
                        return;
                    }
                }

                // If we get here, we're at maximum quantity
                if (currentQty < 15000) {
                    quantityInput.value = 15000;
                    updatePrice(15000);
                }
            }

            function validateQuantity() {
                let qty = parseInt(quantityInput.value);
                if (isNaN(qty)) {
                    qty = 50;
                }

                // Find closest tier
                const quantities = Object.keys(priceTiers).map(Number).sort((a, b) => a - b);
                let closest = quantities[0];

                for (let i = 0; i < quantities.length; i++) {
                    if (Math.abs(quantities[i] - qty) < Math.abs(closest - qty)) {
                        closest = quantities[i];
                    }
                }

                quantityInput.value = closest;
                updatePrice(closest);
            }

            function updatePrice(quantity) {
                // Find the correct price tier
                let additionalPrice = 0;
                let optionValue = '65'; // Default option

                // Find the closest tier (equal or higher)
                const quantities = Object.keys(priceTiers).map(Number).sort((a, b) => a - b);
                for (let i = 0; i < quantities.length; i++) {
                    if (quantity <= quantities[i]) {
                        additionalPrice = priceTiers[quantities[i]];
                        optionValue = getOptionValueForQuantity(quantities[i]);
                        break;
                    }
                }

                // If quantity is higher than our max tier
                if (quantity > quantities[quantities.length - 1]) {
                    additionalPrice = priceTiers[15000];
                    optionValue = '244';
                }

                // Update display and hidden field
                const totalPrice = basePrice + additionalPrice;
                priceDisplay.textContent = `$${totalPrice.toFixed(2)}`;
                quantityOption.value = optionValue;
            }

            function getOptionValueForQuantity(quantity) {
                // Map quantities to your original option values
                const quantityToOption = {
                    50: '21',
                    100: '22',
                    250: '23',
                    500: '24',
                    1000: '25',
                    2000: '26',
                    2500: '27',
                    3000: '28',
                    4000: '29',
                    5000: '30',
                    10000: '64',
                    15000: '244'
                };
                return quantityToOption[quantity] || '65';
            }
        });
    </script>

    <script>
        // ... (keep your existing quantity/price JavaScript code) ...

        // Preview functionality
        document.getElementById('previewButton').addEventListener('click', function(e) {
            e.preventDefault();
            updatePreviewData();
        });

        // Confirm order button in preview modal
        document.getElementById('confirmOrderBtn').addEventListener('click', function() {
            if (validateForm()) {
                document.getElementById('chequeOrderForm').submit();
            }
        });

        function validateForm() {
            // Add any additional form validation here
            return true; // Return false if validation fails
        }

        function updatePreviewData() {
            // Customer Information
            const customerSelect = document.getElementById('customer_id');
            document.getElementById('previewCustomer').textContent =
                customerSelect.selectedIndex > 0 ? customerSelect.options[customerSelect.selectedIndex].text :
                "Not selected";

            // Quantity and Price
            const quantity = document.getElementById('quantity').value;
            const priceDisplay = document.getElementById('dynamic-price').textContent;
            document.getElementById('previewQuantity').textContent = quantity + ' cheques';
            document.getElementById('previewPrice').textContent = priceDisplay;

            // Color Selection
            const selectedColor = document.querySelector('input[name="color"]:checked');
            if (selectedColor) {
                const colorLabel = selectedColor.closest('.color-option').querySelector('span').textContent.trim();
                document.getElementById('previewColor').textContent = colorLabel;
                document.getElementById('previewColorText').textContent = colorLabel;

                // Update color preview dot
                const colorDot = document.querySelector('.color-preview');
                colorDot.style.backgroundColor = getColorHex(selectedColor.value);

                // Update cheque image preview
                updateChequeImagePreview(selectedColor.value);
            }

            // Company Info
            document.getElementById('previewCompanyInfo').textContent =
                document.getElementById('company_info').value.trim() || "Not provided";

            // Void Cheque Option
            const voidOption = document.getElementById('voided_cheque');
            document.getElementById('previewVoidOption').textContent =
                voidOption.options[voidOption.selectedIndex].text || "Not selected";

            // Bank Information
            const showBankInfo = voidOption.value === 'notVoidCheck';
            document.getElementById('previewInstitutionNumber').textContent =
                showBankInfo ? (document.getElementById('institution_number').value || "Not provided") : "N/A";
            document.getElementById('previewTransitNumber').textContent =
                showBankInfo ? (document.getElementById('transit_number').value || "Not provided") : "N/A";

            // Account Number (masked)
            const accountNumber = document.getElementById('account_number').value;
            document.getElementById('previewAccountNumber').textContent =
                showBankInfo ? (accountNumber ? '•'.repeat(accountNumber.length) : "Not provided") : "N/A";

            // Cheque Numbers
            const startNum = document.getElementById('cheque_start_number').value;
            const endNum = document.getElementById('cheque_end_number').value;
            document.getElementById('previewChequeStartNumber').textContent = startNum || "Not provided";
            document.getElementById('previewChequeEndNumber').textContent = endNum || "Not provided";
            document.getElementById('previewChequeRange').textContent =
                (startNum && endNum) ? `${startNum} to ${endNum}` : "Not provided";

            // File uploads preview
            previewFile(document.getElementById('voided_cheque_file'), 'voidedChequeFilePreview', 'voidedChequeText');
            previewFile(document.getElementById('company_logo'), 'companyLogoPreview', 'companyLogoText');

            // Show the modal after updating all data
            $('#previewModal').modal('show');
        }

        function updateChequeImagePreview(colorValue) {
            const colorImages = {
                'Burgundy': 'Burgundy.jpg',
                'Blue': 'Blue.jpg',
                'Green': 'green.jpg',
                'Tan': 'tan.jpg',
                'Grey': 'grey.jpg',
                'Purple': 'purple.jpg',
                'Orange': 'orange.jpg'
            };

            if (colorImages[colorValue]) {
                const imgPath = "{{ asset('assets/front/img/') }}/" + colorImages[colorValue];
                document.getElementById('chequeImgPreview').src = imgPath;
            }
        }

        function previewFile(inputElement, imgId, textId) {
            const previewImg = document.getElementById(imgId);
            const previewText = document.getElementById(textId);

            if (inputElement.files && inputElement.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    previewText.textContent = inputElement.files[0].name;
                };
                reader.readAsDataURL(inputElement.files[0]);
            } else {
                previewImg.style.display = 'none';
                previewText.textContent = inputElement.value ? 'File selected (not shown)' : 'No file uploaded';
            }
        }

        function getColorHex(colorName) {
            const colorMap = {
                'Burgundy': '#800020',
                'Blue': '#0000FF',
                'Green': '#008000',
                'Tan': '#D2B48C',
                'Grey': '#808080',
                'Purple': '#800080',
                'Orange': '#FFA500'
            };
            return colorMap[colorName] || '#800080';
        }
    </script>
    <style>
        /* Preview modal styles */
        #previewModal .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .preview-image {
            max-height: 200px;
            object-fit: contain;
        }

        /* Color preview dot */
        .color-preview {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ddd;
            display: inline-block;
            vertical-align: middle;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #previewModal .modal-dialog {
                margin: 10px auto;
                max-width: 95%;
            }

            #previewModal .modal-body {
                max-height: 65vh;
            }
        }
    </style>
    <style>
        .quantity-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50% !important;
        }

        #quantity {
            -moz-appearance: textfield;
        }

        #quantity::-webkit-outer-spin-button,
        #quantity::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .product-price-box {
            border-left: 4px solid #007bff;
            max-width: 200px;
            margin: 0 auto;
        }
    </style>

@endsection
