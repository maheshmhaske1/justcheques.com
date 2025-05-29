<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <!-- Customer Modal -->
        <div class="modal fade" id="modalCustomer" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form
                    action="{{ isset($customerData) ? route('admin.customer.update', $customerData->id) : route('admin.customerStore') }}"
                    method="POST">
                    @csrf
                    @if (isset($customerData))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ isset($customerData) ? 'Edit Customer' : 'Add Customer' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <!-- Firstname 
                                <div class="mb-3">
                                    <label class="form-label" for="firstname">First Name</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname"
                                        value="{{ old('firstname', $customerData->firstname ?? '') }}"  />
                                </div> -->

                                <!-- Lastname 
                                <div class="mb-3">
                                    <label class="form-label" for="lastname">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname"
                                        value="{{ old('lastname', $customerData->lastname ?? '') }}"  />
                                </div> -->
 
                              
                                <!-- Company -->
                                <div class="mb-3">
                                    <label class="form-label" for="company">Company</label>
                                    <input type="text" class="form-control" name="company" id="company"
                                        value="{{ old('company', $customerData->company ?? '') }}" />
                                </div>
                              
                                <!-- Telephone -->
                                <div class="mb-3">
                                    <label class="form-label" for="telephone">Telephone</label>
                                    <input type="text" class="form-control" name="telephone" id="telephone"
                                        value="{{ old('telephone', $customerData->telephone ?? '') }}"  />
                                </div>

                               

                                <!-- Street Address -->
                                <div class="mb-3">
                                    <label class="form-label" for="street_address">Street Address</label>
                                    <input type="text" class="form-control" name="street_address" id="street_address"
                                        value="{{ old('street_address', $customerData->street_address ?? '') }}"
                                        required />
                                </div>

                                <!-- Suburb 
                                <div class="mb-3">
                                    <label class="form-label" for="suburb">Suburb</label>
                                    <input type="text" class="form-control" name="suburb" id="suburb"
                                        value="{{ old('suburb', $customerData->suburb ?? '') }}" /> 
                                </div> -->

                                <!-- Buzzer Code 
                                <div class="mb-3">
                                    <label class="form-label" for="buzzer_code">Buzzer Code</label>
                                    <input type="text" class="form-control" name="buzzer_code" id="buzzer_code"
                                        value="{{ old('buzzer_code', $customerData->buzzer_code ?? '') }}" />
                                </div>  -->

                                <!-- City -->
                                <div class="mb-3">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                        value="{{ old('city', $customerData->city ?? '') }}"  />
                                </div>

                                <!-- Postcode -->
                                <div class="mb-3">
                                    <label class="form-label" for="postcode">Postcode</label>
                                    <input type="text" class="form-control" name="postcode" id="postcode"
                                        value="{{ old('postcode', $customerData->postcode ?? '') }}"  />
                                </div>

                                <!-- State -->
                                <div class="mb-3">
                                    <label class="form-label" for="state">State</label>
                                    <input type="text" class="form-control" name="state" id="state"
                                        value="{{ old('state', $customerData->state ?? '') }}"  />
                                </div>

                                <!-- Country -->
                                <div class="mb-3">
                                    <label class="form-label" for="country">Country</label>
                                    <input type="text" class="form-control" name="country" id="country"
                                        value="{{ old('country', $customerData->country ?? '') }}"  />
                                </div>

                                <!-- Email
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ old('email', $customerData->email ?? '') }}"  />
                                </div>  -->
 
                                <!-- User ID 
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="user_id" id="user_id"
                                        value="{{ Auth::user()->id }}"  />
                                </div> -->

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" id="resetCustomer"  class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
