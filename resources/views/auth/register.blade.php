@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white p-2">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create an Account</li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Create an Account</h4>
                            <div>
                                <small>
                                    Already have an account? <a href="/login" class="text-white text-underline">Sign in
                                        now</a>
                                </small>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('register') }}" method="POST" onsubmit="return check_form(this);">
                                @csrf

                                <!-- Personal Details -->
                                <h5 class="mb-3">Personal Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" name="firstname" class="form-control"
                                            placeholder="First Name*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="lastname" class="form-control" placeholder="Last Name*"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="telephone" class="form-control" placeholder="Telephone*"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="company" class="form-control"
                                            placeholder="Company Name *" required>
                                    </div>
                                </div>

                                <!-- Address Details -->
                                <h5 class="mt-4 mb-3">Address Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" name="street_address" class="form-control"
                                            placeholder="Street Address*" required>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <input type="text" name="suburb" class="form-control"
                                            placeholder="Apt., suite, unit, etc.">
                                    </div> --}}
                                    {{-- <div class="col-md-6">
                                        <input type="text" name="buzzer" class="form-control" placeholder="Buzzer Code">
                                    </div> --}}
                                    <div class="col-md-6">
                                        <input type="text" name="city" class="form-control" placeholder="City*"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="postcode" class="form-control"
                                            placeholder="Postal Code*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="zone_id" class="form-select form-control" required>
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
                                    </div>
                                    <div class="col-md-6">
                                        <select name="zone_country_id" class="form-select form-control" required>
                                            <option value="canada" selected>Canada</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Account Info -->
                                <h5 class="mt-4 mb-3">Login Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="email" name="email_address" class="form-control" placeholder="Email*"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Password*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" name="confirmation" id="confirmation" class="form-control"
                                            placeholder="Confirm Password*" required>
                                        <small id="password-error" class="text-danger d-none">Passwords do not
                                            match.</small>
                                    </div>

                                    <input type="hidden" name="role" value="vendor">
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-100">Create Account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const password = document.getElementById('password');
            const confirmation = document.getElementById('confirmation');
            const errorMsg = document.getElementById('password-error');

            function validatePasswords() {
                if (password.value !== confirmation.value) {
                    errorMsg.classList.remove('d-none');
                } else {
                    errorMsg.classList.add('d-none');
                }
            }

            password.addEventListener('keyup', validatePasswords);
            confirmation.addEventListener('keyup', validatePasswords);
        });
    </script>

    <style>
        .bg-primary {
            background-color: rgb(179, 146, 122) !important;
        }
    </style>
@endsection
