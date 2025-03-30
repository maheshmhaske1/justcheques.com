@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header text-white" style="background-color: rgb(179, 146, 122); color: white;">
                        <h1 class="mb-0">Add New Customer</h1>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('customer.store') }}" method="post" id="create-form-inline">
                            @csrf
                            <input type="hidden" name="action" value="process">
                            <input type="hidden" name="email_pref_html" value="email_format">

                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="mb-4">Personal Details</h2>

                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">First Name *</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control" required>
                                        <div class="alert alert-info mt-2 firstname" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Last Name *</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control" required>
                                        <div class="alert alert-info mt-2 lastname" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email ID *</label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                        <div class="alert alert-info mt-2 email" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Telephone *</label>
                                        <input type="text" name="telephone" id="telephone" class="form-control" required>
                                        <div class="alert alert-info mt-2 telephone" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="company" class="form-label">Company Name</label>
                                        <input type="text" name="company" id="company" class="form-control">
                                        <div class="alert alert-info mt-2 company" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="street-address" class="form-label">Street Address *</label>
                                        <input type="text" name="street_address" id="street-address" class="form-control" required>
                                        <div class="alert alert-info mt-2 street-address" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="suburb" class="form-label">Apt/Suite/Unit</label>
                                        <input type="text" name="suburb" id="suburb" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="buzzerCode" class="form-label">Buzzer Code</label>
                                        <input type="text" name="buzzer" id="buzzerCode" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City *</label>
                                        <input type="text" name="city" id="city" class="form-control" required>
                                        <div class="alert alert-info mt-2 city" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="postcode" class="form-label">Postal Code *</label>
                                        <input type="text" name="postcode" id="postcode" class="form-control" required>
                                        <div class="alert alert-info mt-2 postcode" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stateZone" class="form-label">Province/Territory *</label>
                                        <select name="zone_id" id="stateZone" class="form-select" required>
                                            <option value="">Please select ...</option>
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
                                        <div class="alert alert-info mt-2 stateZone" style="display:none"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country *</label>
                                        <select name="zone_country_id" id="country" class="form-select" required>
                                            <option value="">Please Choose Your Country</option>
                                            <option value="Canada">Canada</option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                                    <button type="submit" class="btn btn-primary">Add Customer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    document.querySelector(`.${field}`).innerHTML = alertMessages[field];
                } else {
                    document.querySelector(`.${field}`).style.display = 'none';
                }
            }
            return valid;
        }
    </script>
@endsection