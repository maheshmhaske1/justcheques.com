<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <!-- Modal -->
        <div class="modal fade" id="modalManualCheque" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form
                    action="{{ isset($chequesCategory) ? route('update.manual.cheque', $chequesCategory->id) : route('store.manual.cheque') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">
                                {{ isset($chequesCategory) ? 'Edit Manual Cheque' : 'Add Manual Cheque' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Categories Name</label>
                                    <input type="text" class="form-control" name="categoriesName" placeholder="Enter Here" value="{{ old('categoriesName', $chequesCategory->categoriesName ?? '')  }}" />
                                </div>

                                @if(isset($chequesCategory))
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Current Image</label>
                                    <br>
                                    <img class="mt-2" src="{{ asset('assets/front/img/' . $chequesCategory->img) }}" alt="Current Image" style="max-width: 300px; max-height: 250px;">
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label for="formFile" class="form-label">New Image</label>
                                    <input class="form-control" name="image" type="file">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>