<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <!-- Modal -->
        <div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form
                    action="{{ isset($userData) ? route('admin.users.update', $userData->id) : route('adminUser.userStore') }}"
                    method="POST">
                    @csrf
                    @if (isset($userData))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">
                                {{ isset($userData) ? 'Edit User' : 'Add User' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label class="form-label" for="firstname">First Name</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname"
                                        placeholder="John" value="{{ old('firstname', $userData->firstname ?? '') }}"
                                        required />
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label class="form-label" for="lastname">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname"
                                        placeholder="Doe" value="{{ old('lastname', $userData->lastname ?? '') }}"
                                        required />
                                </div>

                                <!-- Telephone -->
                                <div class="mb-3">
                                    <label class="form-label" for="telephone">Telephone</label>
                                    <input type="text" name="telephone" id="telephone"
                                        class="form-control phone-mask" placeholder="658 799 8941"
                                        value="{{ old('telephone', $userData->telephone ?? '') }}" />
                                </div>

                                <!-- Company -->
                                <div class="mb-3">
                                    <label class="form-label" for="company">Company</label>
                                    <input type="text" class="form-control" name="company" id="company"
                                        placeholder="ACME Inc."
                                        value="{{ old('company', $userData->company ?? '') }}" />
                                </div>

                                <!-- Street Address -->
                                <div class="mb-3">
                                    <label class="form-label" for="street_address">Street Address</label>
                                    <textarea name="street_address" id="street_address" class="form-control" required>{{ old('street_address', $userData->street_address ?? '') }}</textarea>
                                </div>

                                <!-- Suburb -->
                                <div class="mb-3">
                                    <label class="form-label" for="suburb">Suburb</label>
                                    <input type="text" class="form-control" name="suburb" id="suburb"
                                        placeholder="Apt., suite, unit, etc."
                                        value="{{ old('suburb', $userData->suburb ?? '') }}" />
                                </div>

                                <!-- Buzzer Code -->
                                <div class="mb-3">
                                    <label class="form-label" for="buzzer_code">Buzzer Code</label>
                                    <input type="text" class="form-control" name="buzzer_code" id="buzzer_code"
                                        placeholder="Buzzer Code"
                                        value="{{ old('buzzer_code', $userData->buzzer_code ?? '') }}" />
                                </div>

                                <!-- City -->
                                <div class="mb-3">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                        placeholder="City" value="{{ old('city', $userData->city ?? '') }}" />
                                </div>

                                <!-- Postal Code -->
                                <div class="mb-3">
                                    <label class="form-label" for="postcode">Postal Code</label>
                                    <input type="text" class="form-control" name="postcode" id="postcode"
                                        placeholder="123456"
                                        value="{{ old('postcode', $userData->postcode ?? '') }}" />
                                </div>

                                <!-- State -->
                                <div class="mb-3">
                                    <label class="form-label" for="state">State</label>
                                    @php
                                        $states = [
                                            'Alberta',
                                            'British Columbia',
                                            'Manitoba',
                                            'New Brunswick',
                                            'Newfoundland and Labrador',
                                            'Nova Scotia',
                                            'Ontario',
                                            'Prince Edward Island',
                                            'Quebec',
                                            'Saskatchewan',
                                            'Northwest Territories',
                                            'Nunavut',
                                            'Yukon',
                                        ];
                                    @endphp
                                    <select class="form-control" name="state" id="state">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state }}"
                                                {{ old('state', $userData->state ?? '') == $state ? 'selected' : '' }}>
                                                {{ $state }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Country -->
                                <div class="mb-3">
                                    <label class="form-label" for="country">Country</label>
                                    <select class="form-control" id="country" name="country">
                                        <option value="{{ old('country', $userData->country ?? '') }}">Canada</option>
                                    </select>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="john@example.com"
                                        value="{{ old('email', $userData->email ?? '') }}" required />
                                </div>

                                <!-- Email Verified At -->
                                <div class="mb-3">
                                    <label class="form-label" for="email_verified_at">Email Verified At</label>
                                    <input type="text" class="form-control" name="email_verified_at"
                                        id="email_verified_at" placeholder="e.g., 2023-01-01"
                                        value="{{ old('email_verified_at', $userData->email_verified_at ?? '') }}" />
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        {{ isset($userData) ? '' : 'required' }} />
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label class="form-label" for="role">Role</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value="vendor"
                                            {{ old('role', $userData->role ?? '') == 'vendor' ? 'selected' : '' }}>
                                            Vendor</option>
                                        <option value="admin"
                                            {{ old('role', $userData->role ?? '') == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="resetUser" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
