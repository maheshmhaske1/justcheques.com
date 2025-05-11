@extends('layouts.app')

@section('content')
<section class="mid-content">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 1.9em;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Breadcrumb -->
                <div id="navBreadCrumb">
                    <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp; Edit Customer
                </div>

                <!-- Heading Section -->
                <div class="centerColumn" id="createAcctDefault">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <h1 id="createAcctDefaultHeading" class="back cust_hd">Edit Customer</h1>
                        </div>
                    </div>
                    <div class="clearBoth"></div>

                    <!-- Form Section -->
                    <div class="col-md-12 bg_cls">
                        <form name="edit_customer" action="{{ route('customer.update', $customer->id) }}" method="post"
                            class="form-inline" id="create-form-inline" onsubmit="return check_form(edit_customer);">
                            @csrf
                            @method('PUT')
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
                                        <!-- <div class="form-group cust_formgrop">
                                                <label for="firstname" class="form-label">First Name *</label>
                                                <input type="text" name="firstname" size="33" maxlength="32"
                                                    id="firstname" placeholder="First Name"
                                                    value="{{ old('firstname', $customer->firstname) }}" required>
                                                <div class="alert alert-info firstname" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div> -->

                                        <!-- Last Name -->
                                        <!-- <div class="form-group cust_formgrop">
                                                <label for="lastname" class="form-label">Last Name *</label>
                                                <input type="text" name="lastname" size="33" maxlength="32"
                                                    id="lastname" placeholder="Last Name"
                                                    value="{{ old('lastname', $customer->lastname) }}" required>
                                                <div class="alert alert-info lastname" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div> -->

                                        <!-- Email ID -->
                                        <!-- <div class="form-group cust_formgrop">
                                                <label for="email" class="form-label">Email ID *</label>
                                                <input type="email" name="email" size="33" maxlength="32"
                                                    id="email" placeholder="Email ID"
                                                    value="{{ old('email', $customer->email) }}" required>
                                                <div class="alert alert-info email" style="display:none">
                                                    <strong>Info!</strong> Indicates a neutral informative change or action.
                                                </div>
                                            </div> -->

                                        <!-- Company Name -->
                                        <div class="form-group cust_formgrop">
                                            <label for="company" class="form-label">Company Name</label>
                                            <input type="text" name="company" size="33" maxlength="32"
                                                autocomplete="off" id="company" placeholder="Company Name"
                                                value="{{ old('company', $customer->company) }}">
                                            <div class="alert alert-info company" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Telephone -->
                                        <div class="form-group cust_formgrop">
                                            <label for="telephone" class="form-label">Telephone</label>
                                            <input type="text" name="telephone" size="33" maxlength="32"
                                                id="telephone" placeholder="Telephone"
                                                value="{{ old('telephone', $customer->telephone) }}">
                                            <div class="alert alert-info telephone" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>



                                        <!-- Street Address -->
                                        <div class="form-group cust_formgrop">
                                            <label for="street-address" class="form-label">Street Address</label>
                                            <input type="text" name="street_address" size="33" maxlength="32"
                                                autocomplete="off" id="street-address" placeholder="Street Address"
                                                value="{{ old('street_address', $customer->street_address) }}">
                                            <div class="alert alert-info street-address" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Suburb -->
                                        <div class="form-group cust_formgrop">
                                            <label for="suburb" class="form-label">Apt/Suite/Unit</label>
                                            <input type="text" name="suburb" size="33" maxlength="32"
                                                id="suburb" placeholder="Apt., suite, unit, etc."
                                                value="{{ old('suburb', $customer->suburb) }}">
                                        </div>

                                        <!-- Buzzer Code -->
                                        <div class="form-group cust_formgrop">
                                            <label for="buzzerCode" class="form-label">Buzzer Code</label>
                                            <input type="text" name="buzzer_code" size="33" maxlength="32"
                                                id="buzzerCode" placeholder="Buzzer Code"
                                                value="{{ old('buzzer_code', $customer->buzzer_code) }}">
                                        </div>

                                        <!-- City -->
                                        <div class="form-group cust_formgrop">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" size="33" maxlength="32"
                                                id="city" placeholder="City"
                                                value="{{ old('city', $customer->city) }}">
                                            <div class="alert alert-info city" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Postal Code -->
                                        <div class="form-group cust_formgrop">
                                            <label for="postcode" class="form-label">Postal Code</label>
                                            <input type="text" name="postcode" size="11" maxlength="10"
                                                id="postcode" placeholder="Postal Code" autocomplete="off"
                                                value="{{ old('postcode', $customer->postcode) }}">
                                            <div class="alert alert-info postcode" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- State Selection -->
                                        <div class="form-group select-state cust_formgrop">
                                            <label for="stateZone" class="form-label">Province/Territory</label>
                                            <select name="state" id="stateZone" autocomplete="off">
                                                <option value="">Please select ...</option>
                                                <option value="AB" {{ old('state', $customer->state) == 'AB' ? 'selected' : '' }}>
                                                    Alberta (AB)
                                                </option>
                                                <option value="BC" {{ old('state', $customer->state) == 'BC' ? 'selected' : '' }}>
                                                    British Columbia (BC)
                                                </option>
                                                <option value="MB" {{ old('state', $customer->state) == 'MB' ? 'selected' : '' }}>
                                                    Manitoba (MB)
                                                </option>
                                                <option value="NB" {{ old('state', $customer->state) == 'NB' ? 'selected' : '' }}>
                                                    New Brunswick (NB)
                                                </option>
                                                <option value="NL" {{ old('state', $customer->state) == 'NL' ? 'selected' : '' }}>
                                                    Newfoundland and Labrador (NL)
                                                </option>
                                                <option value="NT" {{ old('state', $customer->state) == 'NT' ? 'selected' : '' }}>
                                                    Northwest Territories (NT)
                                                </option>
                                                <option value="NS" {{ old('state', $customer->state) == 'NS' ? 'selected' : '' }}>
                                                    Nova Scotia (NS)
                                                </option>
                                                <option value="NU" {{ old('state', $customer->state) == 'NU' ? 'selected' : '' }}>
                                                    Nunavut (NU)
                                                </option>
                                                <option value="ON" {{ old('state', $customer->state) == 'ON' ? 'selected' : '' }}>
                                                    Ontario (ON)
                                                </option>
                                                <option value="PE" {{ old('state', $customer->state) == 'PE' ? 'selected' : '' }}>
                                                    Prince Edward Island (PE)
                                                </option>
                                                <option value="QC" {{ old('state', $customer->state) == 'QC' ? 'selected' : '' }}>
                                                    Quebec (QC)
                                                </option>
                                                <option value="SK" {{ old('state', $customer->state) == 'SK' ? 'selected' : '' }}>
                                                    Saskatchewan (SK)
                                                </option>
                                                <option value="YT" {{ old('state', $customer->state) == 'YT' ? 'selected' : '' }}>
                                                    Yukon (YT)
                                                </option>
                                            </select>
                                            <div class="alert alert-info stateZone" style="display:none">
                                                <strong>Info!</strong> Please select a province or territory from the dropdown list.
                                            </div>
                                        </div>

                                        <!-- Country Selection -->
                                        <!-- <div class="form-group country-custom cust_formgrop">
                                                <label for="country" class="form-label">Country *</label>
                                                <select name="country" id="country" required>
                                                    <option value="">Please Choose Your Country</option>
                                                    <option value="Canada" {{ old('country', $customer->country) == 'Canada' ? 'selected' : '' }}>
                                                        Canada
                                                    </option>
                                                </select>
                                            </div> -->
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
                                        <button type="submit" class="btn btn-primary" id="register-submit">Update
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
            state: 'Province/Territory is required',
            country: 'Country is required',
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