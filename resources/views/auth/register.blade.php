@extends('layouts.app')

@section('content')
<section class="mid-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <!-- Breadcrumb -->
                <div id="navBreadCrumb">
                    <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp; Create an Account
                </div>

                <!-- Heading Section -->
                <div class="centerColumn" id="createAcctDefault">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <h1 id="createAcctDefaultHeading" class="back cust_hd">Create an Account</h1>
                        </div>
                        <div class="col-md-4">
                            <h4 id="createAcctDefaultLoginLink" class="alrdy_login">
                                <i class="fa fa-lock cust_iccn2"></i>&nbsp;Secure Login<br>
                                already have an account? <a href="/login" class="signin_link">sign in now</a>.
                            </h4>
                        </div>
                    </div>
                    <div class="clearBoth"></div>

                    <!-- Form Section -->
                    <div class="col-md-8">
                        <form name="create_account" action="{{ route('register') }}" method="post" class="form-inline" id="create-form-inline" onsubmit="return check_form(create_account);">
                            @csrf

                            <!-- Personal Details Section -->
                            <div class="col-left_new">
                                <div id="billing-address-wrapper" class="login-details-wrapper bg_cls">
                                    <h2 class="top_hdng">Personal Details</h2><br>
                                    <div class="container">
                                        <div class="alert alert-info gender" id="gender" style="display:none">
                                            <strong>Info!</strong> Indicates a neutral informative change or action.
                                        </div>
                                        <div class="pull-right validate_txt">
                                            <p>Fields marked with an asterisk(*) are required.</p>
                                        </div>
                                        <div class="clearBoth"></div>

                                        <!-- First Name -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="firstname" size="33" maxlength="32" id="firstname" placeholder="First Name*" required>
                                            <div class="alert alert-info firstname" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="lastname" size="33" maxlength="32" id="lastname" placeholder="Last Name*" required>
                                            <div class="alert alert-info lastname" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Telephone -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="telephone" size="33" maxlength="32" id="telephone" placeholder="Telephone*" required>
                                            <div class="alert alert-info telephone" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Company Name -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="company" size="33" maxlength="32" autocomplete="off" id="company" placeholder="Company Name">
                                            <div class="alert alert-info company" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Street Address -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="street_address" size="33" maxlength="32" autocomplete="off" id="street-address" placeholder="Street Address*" required>
                                            <div class="alert alert-info street-address" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Suburb -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="suburb" size="33" maxlength="32" id="suburb" placeholder="Apt., suite, unit, etc.">
                                        </div>

                                        <!-- Buzzer Code -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="buzzer" size="33" maxlength="32" id="buzzerCode" placeholder="Buzzer Code">
                                        </div>

                                        <!-- City -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="city" size="33" maxlength="32" id="city" placeholder="City*" required>
                                            <div class="alert alert-info city" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- Postal Code -->
                                        <div class="form-group cust_formgrop">
                                            <input type="text" name="postcode" size="11" maxlength="10" id="postcode" placeholder="Postal Code*" autocomplete="off" required>
                                            <div class="alert alert-info postcode" style="display:none">
                                                <strong>Info!</strong> Indicates a neutral informative change or action.
                                            </div>
                                        </div>

                                        <!-- State Selection -->
                                        <div class="form-group select-state cust_formgrop">
                                            <select name="zone_id" id="stateZone" autocomplete="off" required>
                                                <option value="" selected="selected">Please select ...</option>
                                                <option value="AB">Alberta</option>
                                                <option value="BC">British Columbia</option>
                                                <option value="MB">Manitoba</option>
                                                <option value="NB">New Brunswick</option>
                                                <option value="NL">Newfoundland</option>
                                                <option value="NT">Northwest Territories</option>
                                                <option value="NS">Nova Scotia</option>
                                                <option value="NU">Nunavut</option>
                                                <option value="ON">Ontario</option>
                                                <option value="PE">Prince Edward Island</option>
                                                <option value="QC">Quebec</option>
                                                <option value="SK">Saskatchewan</option>
                                                <option value="YT">Yukon Territory</option>
                                            </select>
                                            <div class="alert alert-info stateZone" style="display:none">
                                                <strong>Info!</strong> Please select a state from the dropdown list.
                                            </div>
                                        </div>

                                        <!-- Country Selection -->
                                        <div class="form-group cust_formgroplgn">
                                            <select name="zone_country_id" id="country" required>
                                                <option value="">Please Choose Your Country</option>
                                                <option value="canada" selected="selected">Canada</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Login Details Section -->
                            <div class="col-right_new">
                                <div class="login-details-wrapper bg_cls">
                                    <h2 class="top_hdng">Login Details</h2><br>

                                    <!-- Email Address -->
                                    <div class="form-group cust_formgroplgn">
                                        <input type="email" name="email_address" size="41" maxlength="96" id="email-address" placeholder="Email example@example.com*" required>
                                        <div class="alert alert-info email-address" style="display:none">
                                            <strong>Info!</strong> Indicates a neutral informative change or action.
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group cust_formgroplgn">
                                        <input type="password" name="password" size="41" maxlength="40" id="password-new" placeholder="Password*" required>
                                        <div class="alert alert-info password" style="display:none">
                                            <strong>Info!</strong> Indicates a neutral informative change or action.
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="form-group cust_formgroplgn">
                                        <input type="password" name="confirmation" size="41" maxlength="40" id="password-confirm" placeholder="Confirm Password*" required>
                                        <div class="alert alert-info password-confirm" style="display:none">
                                            <strong>Info!</strong> Indicates a neutral informative change or action.
                                        </div>
                                    </div>

                                    <div class="form-group cust_formgroplgn">
                                            <select name="role" id="role" required>
                                                <option value="">Please Choose Role</option>
                                                {{-- <option value="admin" selected="selected">Admin</option> --}}
                                                <option value="vendor">Vendor</option>
                                                <option value="customer">Customer</option>
                                            </select>
                                        </div>

                                    <!-- Submit Button -->
                                    <div class="submit-btn form-group cust_formgroplgn mt-10">
                                        <button type="submit" class="btn btn-primary" id="register-submit">Create Account</button>
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
            street_address: 'Street address is required',
            city: 'City is required',
            postcode: 'Postal code is required',
            zone_id: 'State is required',
            country: 'Country is required',
            email_address: 'Email address is required',
            password: 'Password is required',
            confirmation: 'Password confirmation is required',
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

        // Check password match
        if (form['password'].value !== form['confirmation'].value) {
            valid = false;
            document.querySelector('.password-confirm').style.display = 'block';
            document.querySelector('.password-confirm').innerHTML = `<strong>Info!</strong> Passwords do not match.`;
        } else {
            document.querySelector('.password-confirm').style.display = 'none';
        }

        return valid;
    }
</script>
@endsection
