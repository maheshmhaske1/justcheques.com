@extends('layouts.app')

@section('content')
    <section class="mid-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Breadcrumb -->
                    <div id="navBreadCrumb">
                        <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp; Add Customer
                    </div>

                    <!-- Heading Section -->
                    <div class="centerColumn" id="createAcctDefault">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <h1 id="createAcctDefaultHeading" class="back cust_hd">Add Customer</h1>
                            </div>
                        </div>
                        <div class="clearBoth"></div>

                        <!-- Form Section -->
                        <div class="col-md-12 bg_cls">
                            <form name="create_account" action="{{ route('customer.store') }}" method="post"
                                class="form-inline" id="create-form-inline" onsubmit="return check_form(create_account);">
                                @csrf
                                <input type="hidden" name="action" value="process">
                                <input type="hidden" name="email_pref_html" value="email_format">

                                <!-- Personal Details Section -->
                                <div class="col-left_new">
                                    <div id="billing-address-wrapper" class="login-details-wrapper">
                                        <h2 class="top_hdng">Personal Details</h2><br>
                                        <div class="container">
                                            <div class="pull-right validate_txt">
                                                <p>Fields marked with an asterisk(*) are required.</p>
                                            </div>
                                            <div class="clearBoth"></div>

                                            <!-- First Name -->
                                            <div class="form-group cust_formgrop">
                                                <label for="firstname" class="form-label">First Name *</label>
                                                <input type="text" name="firstname" size="33" maxlength="32"
                                                    id="firstname" placeholder="First Name" required>
                                                <div class="alert alert-info firstname" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div>

                                            <!-- Last Name -->
                                            <div class="form-group cust_formgrop">
                                                <label for="lastname" class="form-label">Last Name *</label>
                                                <input type="text" name="lastname" size="33" maxlength="32"
                                                    id="lastname" placeholder="Last Name" required>
                                                <div class="alert alert-info lastname" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div>

                                            <!-- Email ID -->
                                            <div class="form-group cust_formgrop">
                                                <label for="email" class="form-label">Email ID *</label>
                                                <input type="email" name="email" size="33" maxlength="32"
                                                    id="email" placeholder="Email ID" required>
                                                <div class="alert alert-info email" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div>

                                            <!-- Telephone -->
                                            <div class="form-group cust_formgrop">
                                                <label for="telephone" class="form-label">Telephone *</label>
                                                <input type="text" name="telephone" size="33" maxlength="32"
                                                    id="telephone" placeholder="Telephone" required>
                                                <div class="alert alert-info telephone" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div>

                                            <!-- Company Name -->
                                            <div class="form-group cust_formgrop">
                                                <label for="company" class="form-label">Company Name</label>
                                                <input type="text" name="company" size="33" maxlength="32"
                                                    autocomplete="off" id="company" placeholder="Company Name">
                                                <div class="alert alert-info company" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div>

                                            <!-- Street Address -->
                                            <div class="form-group cust_formgrop">
                                                <label for="street-address" class="form-label">Street Address</label>
                                                <input type="text" name="street_address" size="33" maxlength="32"
                                                    autocomplete="off" id="street-address" placeholder="Street Address"
                                                    required>
                                                <div class="alert alert-info street-address" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div>

                                            <!-- Suburb -->
                                            <div class="form-group cust_formgrop">
                                                <label for="suburb" class="form-label">Apt/Suite/Unit</label>
                                                <input type="text" name="suburb" size="33" maxlength="32"
                                                    id="suburb" placeholder="Apt., suite, unit, etc.">
                                            </div>

                                            <!-- Buzzer Code -->
                                            <div class="form-group cust_formgrop">
                                                <label for="buzzerCode" class="form-label">Buzzer Code</label>
                                                <input type="text" name="buzzer" size="33" maxlength="32"
                                                    id="buzzerCode" placeholder="Buzzer Code">
                                            </div>

                                            <!-- City -->
                                            <div class="form-group cust_formgrop">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" name="city" size="33" maxlength="32"
                                                    id="city" placeholder="City" required>
                                                <div class="alert alert-info city" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div>

                                            <!-- Postal Code -->
                                            <div class="form-group cust_formgrop">
                                                <label for="postcode" class="form-label">Postal Code</label>
                                                <input type="text" name="postcode" size="11" maxlength="10"
                                                    id="postcode" placeholder="Postal Code" autocomplete="off"
                                                    required>
                                                <div class="alert alert-info postcode" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div>

                                            <!-- State Selection -->
                                            <div class="form-group select-state cust_formgrop">
                                                <label for="stateZone" class="form-label">Province/Territory *</label>
                                                <select name="zone_id" id="stateZone" autocomplete="off" required>
                                                    <option value="" selected="selected">Please select ...</option>
                                                    <option value="AB">Alberta (AB)</option>
                                                    <option value="BC">British Columbia (BC)</option>
                                                    <option value="MB">Manitoba (MB)</option>
                                                    <option value="NB">New Brunswick (NB)</option>
                                                    <option value="NL">Newfoundland and Labrador (NL)</option>
                                                    <option value="NT">Northwest Territories (NT)</option>
                                                    <option value="NS">Nova Scotia (NS)</option>
                                                    <option value="NU">Nunavut (NU)</option>
                                                    <option value="ON">Ontario (ON)</option>
                                                    <option value="PE">Prince Edward Island (PE)</option>
                                                    <option value="QC">Quebec (QC)</option>
                                                    <option value="SK">Saskatchewan (SK)</option>
                                                    <option value="YT">Yukon (YT)</option>
                                                </select>
                                                <div class="alert alert-info stateZone" style="display:none">
                                                    <strong>Info!</strong> Please select a province or territory from the dropdown list.
                                                </div>
                                            </div>

                                            <!-- Country Selection -->
                                            <div class="form-group country-custom cust_formgrop">
                                                <label for="country" class="form-label">Country *</label>
                                                <select name="zone_country_id" id="country" required>
                                                    <option value="">Please Choose Your Country</option>
                                                    <option value="Canada">Canada</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Login Details Section -->
                                <div class="col-right_new">
                                    <div class="login-details-wrapper bg_cls">
                                        <!-- Submit Button -->
                                        <div class="submit-btn form-group cust_formgroplgn mt-10">
                                            <input type="hidden" name="user_id" id="user_id"
                                                value="{{ auth()->user()->id }}">
                                            <button type="submit" class="btn btn-primary" id="register-submit">Add
                                                Customer</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Validation Script -->
    <script>
        function check_form(form) {
            let valid = true;
            let alertMessages = {
                firstname: 'First name is required',
                lastname: 'Last name is required',
                telephone: 'Telephone is required',
                city: 'City is required',
                postcode: 'Postal code is required',
                zone_id: 'Province/Territory is required',
                zone_country_id: 'Country is required',
                email: 'Email address is required',
                street_address: 'Street address is required'
            };

            for (const field in alertMessages) {
                let element = form[field];
                if (!element.value) {
                    valid = false;
                    document.querySelector(`.${field}`).style.display = 'block';
                    document.querySelector(`.${field}`).innerHTML = `<strong>Info!</strong> ${alertMessages[field]}`;
                } else {
                    document.querySelector(`.${field}`).style.display = 'none';
                }
            }

            return valid;
        }
    </script>
@endsection