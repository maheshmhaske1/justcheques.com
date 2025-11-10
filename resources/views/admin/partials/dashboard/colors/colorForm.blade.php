<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <div class="modal fade" id="modalColor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('admin.colorsStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Add Color</h5>
                            <button type="button" id="resetColor" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label" for="name">Color Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="e.g., Burgundy, Blue, Green" value="{{ old('name') }}"
                                        required />
                                    <small class="text-muted">Display name for the color</small>
                                </div>

                                <!-- Value -->
                                <div class="mb-3">
                                    <label class="form-label" for="value">Color Value</label>
                                    <input type="text" class="form-control" name="value" id="value"
                                        placeholder="e.g., burgundy, blue, green" value="{{ old('value') }}"
                                        required />
                                    <small class="text-muted">Internal value used in forms (lowercase, no spaces)</small>
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label" for="image">Color Image</label>
                                    <input type="file" class="form-control" name="image" id="image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif" />
                                    <small class="text-muted">Upload an image showing this color (optional)</small>
                                </div>

                                <!-- Is Active -->
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                    <small class="text-muted">Only active colors will be displayed to users</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
