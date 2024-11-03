@extends('admin.admin')
@section('content')
<div class="card mb-4">
    <h5 class="card-header">Profile Details</h5>
    <!-- Account -->
    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
            <div class="avatar rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 80px; height:80px;">
                {{ $logoName }}
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card-body">
        <form id="formAccountSettings" method="POST" onsubmit="return false">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname"
                        placeholder="John" value="{{ old('firstname', $users->firstname ?? '') }}"
                        required readonly/>
                </div>

                <!-- Last Name -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname"
                        placeholder="Doe" value="{{ old('lastname', $users->lastname ?? '') }}"
                        required readonly/>
                </div>

                <!-- Telephone -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="telephone">Telephone</label>
                    <input type="text" name="telephone" id="telephone"
                        class="form-control phone-mask" placeholder="658 799 8941"
                        value="{{ old('telephone', $users->telephone ?? '') }}" readonly/>
                </div>

                <!-- Company -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="company">Company</label>
                    <input type="text" class="form-control" name="company" id="company"
                        placeholder="ACME Inc."
                        value="{{ old('company', $users->company ?? '') }}" readonly/>
                </div>

                <!-- Street Address -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="street_address">Street Address</label>
                    <textarea name="street_address" id="street_address" class="form-control" required readonly>{{ old('street_address', $users->street_address ?? '') }}</textarea>
                </div>

                <!-- Suburb -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="suburb">Suburb</label>
                    <input type="text" class="form-control" name="suburb" id="suburb"
                        placeholder="Apt., suite, unit, etc."
                        value="{{ old('suburb', $users->suburb ?? '') }}" readonly/>
                </div>

                <!-- Buzzer Code -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="buzzer_code">Buzzer Code</label>
                    <input type="text" class="form-control" name="buzzer_code" id="buzzer_code"
                        placeholder="Buzzer Code"
                        value="{{ old('buzzer_code', $users->buzzer_code ?? '') }}" readonly/>
                </div>

                <!-- City -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="city">City</label>
                    <input type="text" class="form-control" name="city" id="city"
                        placeholder="City" value="{{ old('city', $users->city ?? '') }}" readonly />
                </div>

                <!-- Postal Code -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="postcode">Postal Code</label>
                    <input type="text" class="form-control" name="postcode" id="postcode"
                        placeholder="123456"
                        value="{{ old('postcode', $users->postcode ?? '') }}" readonly/>
                </div>

                <!-- State -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="state">State</label>
                    @php
                    $states = [
                    'Andhra Pradesh',
                    'Arunachal Pradesh',
                    'Assam',
                    'Bihar',
                    'Chhattisgarh',
                    'Goa',
                    'Gujarat',
                    'Haryana',
                    'Himachal Pradesh',
                    'Jharkhand',
                    'Karnataka',
                    'Kerala',
                    'Madhya Pradesh',
                    'Maharashtra',
                    'Manipur',
                    'Meghalaya',
                    'Mizoram',
                    'Nagaland',
                    'Odisha',
                    'Punjab',
                    'Rajasthan',
                    'Sikkim',
                    'Tamil Nadu',
                    'Telangana',
                    'Tripura',
                    'Uttar Pradesh',
                    'Uttarakhand',
                    'West Bengal',
                    'Andaman and Nicobar Islands',
                    'Chandigarh',
                    'Dadra and Nagar Haveli and Daman and Diu',
                    'Lakshadweep',
                    'Delhi',
                    'Puducherry',
                    'Jammu and Kashmir',
                    'Ladakh',
                    ];
                    @endphp
                    <select class="form-control" name="state" id="state" disabled>
                        <option value="" >Select State</option>
                        @foreach ($states as $state)
                        <option readonly value="{{ $state }}"
                            {{ old('state', $users->state ?? '') == $state ? 'selected' : '' }}>
                            {{ $state }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Country -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="country">Country</label>
                    <input type="text" class="form-control" name="country" id="country"
                        placeholder="India" value="{{ old('country', $users->country ?? '') }}" readonly/>
                </div>

                <!-- Email -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="john@example.com"
                        value="{{ old('email', $users->email ?? '') }}" required readonly/>
                </div>

                <!-- Email Verified At -->
                <!-- <div class="mb-3 col-md-6">
                    <label class="form-label" for="email_verified_at">Email Verified At</label>
                    <input type="text" class="form-control" name="email_verified_at"
                        id="email_verified_at" placeholder="e.g., 2023-01-01"
                        value="{{ old('email_verified_at', $users->email_verified_at ?? '') }}" />
                </div> -->

                <!-- Password -->
                <!-- <div class="mb-3 col-md-6">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        {{ isset($users) ? '' : 'required' }} />
                </div> -->

                <!-- Role -->
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="role">Role</label>
                    <select class="form-control" name="role" id="role" readonly>
                        <option value="vendor"
                            {{ old('role', $users->role ?? '') == 'vendor' ? 'selected' : '' }}>
                            Vendor</option>
                        <option value="admin"
                            {{ old('role', $users->role ?? '') == 'admin' ? 'selected' : '' }}>Admin
                        </option>
                    </select>

                </div>
            </div>
            <!-- <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
            </div> -->
        </form>
    </div>
    <!-- /Account -->
</div>
@endsection