@extends('admin.admin')
@section('content')
<!-- <div style="display: flex; justify-content: flex-start;">
    <a class="btn btn-primary my-4" href="{{ url('admin/manualcheques') }}" role="button">Back</a>
</div> -->
<div class="row">
    <div id="navBreadCrumb"> <a href="{{ url('admin') }}">Home</a>&nbsp;<span class="separator">//</span>&nbsp;
        <a href="{{ url('admin/manualcheques') }}">Manual Cheques</a>&nbsp;<span class="separator">
        </span>&nbsp;
    </div>
    <div class="col-3"></div>
    <div class="col-6">
        <h3 class="text-center my-4">Edit Manual Cheques</h3>
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" action="{{ route('update.manual.cheque', $chequesCategory->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Categories Name</label>
                        <input type="text" class="form-control" name="categoriesName" placeholder="Enter Here" value="{{ $chequesCategory->categoriesName }}" />
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Current Image</label>
                        <br>
                        <img class="mt-2" src="{{ asset('assets/front/img/' . $chequesCategory->img) }}" alt="Current Image"  style="max-width: 300px; max-height: 250px;">
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">New Image</label>
                        <input class="form-control" name="image" type="file">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3"></div>
</div>
@endsection