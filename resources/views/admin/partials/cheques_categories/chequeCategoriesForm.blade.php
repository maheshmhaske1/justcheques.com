<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <!-- Cheque Categories Modal -->
        <div class="modal fade" id="modalChequeCategories" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form
                    action="{{ isset($chequeCategoryData) ? route('admin.cheque_categories.update', $chequeCategoryData->id) : route('admin.chequeCategoriesStore') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($chequeCategoryData))
                        @method('PUT')
                    @endif
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ isset($chequeCategoryData) ? 'Edit Cheque Category' : 'Add Cheque Category' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <!-- Manual Cheque ID -->
                                <div class="mb-3">
                                    <label class="form-label" for="manual_cheque_id">Manual Cheque ID</label>
                                    <input type="text" class="form-control" name="manual_cheque_id" id="manual_cheque_id"
                                        value="{{ old('manual_cheque_id', $chequeCategoryData->manual_cheque_id ?? '') }}" required />
                                </div>

                                <!-- Laser Cheque ID -->
                                <div class="mb-3">
                                    <label class="form-label" for="laser_cheque_id">Laser Cheque ID</label>
                                    <input type="text" class="form-control" name="laser_cheque_id" id="laser_cheque_id"
                                        value="{{ old('laser_cheque_id', $chequeCategoryData->laser_cheque_id ?? '') }}" required />
                                </div>

                                <!-- Personal Cheque ID -->
                                <div class="mb-3">
                                    <label class="form-label" for="personal_cheque_id">Personal Cheque ID</label>
                                    <input type="text" class="form-control" name="personal_cheque_id" id="personal_cheque_id"
                                        value="{{ old('personal_cheque_id', $chequeCategoryData->personal_cheque_id ?? '') }}" required />
                                </div>

                                <!-- Cheque Name -->
                                <div class="mb-3">
                                    <label class="form-label" for="chequeName">Cheque Name</label>
                                    <input type="text" class="form-control" name="chequeName" id="chequeName"
                                        value="{{ old('chequeName', $chequeCategoryData->chequeName ?? '') }}" required />
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <label class="form-label" for="price">Price</label>
                                    <input type="number" step="0.01" class="form-control" name="price" id="price"
                                        value="{{ old('price', $chequeCategoryData->price ?? '') }}" required />
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label" for="img">Image</label>
                                    <input type="file" class="form-control" name="img" id="img" accept="image/*" />
                                    @if(isset($chequeCategoryData) && $chequeCategoryData->img)
                                        <a href="{{ asset('assets/front/img/' . $chequeCategoryData->img) }}" target="_blank">{{$chequeCategoryData->img}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
