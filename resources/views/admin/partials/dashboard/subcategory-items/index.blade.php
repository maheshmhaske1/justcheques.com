@extends('admin.admin')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row px-2">
        <div class="card mt-2 mb-4">
            <div class="d-flex  align-items-center">
                <h5 class="card-header heading-text"><strong>Subcategory Items</strong></h5>
                <div class="search-box-css">
                    <input type="text" id="customSearch" class="form-control w-auto" placeholder="Search items..."
                        autocomplete="off">
                </div>
                <div>
                    <a href="{{ route('admin.subcategory-items.create') }}" class="btn btn-primary">
                        Add Item
                    </a>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="itemsTable">
                    <thead>
                        <tr>
                            <th><strong>Sr No.</strong></th>
                            <th><strong>Item Name</strong></th>
                            <th><strong>Subcategory</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Created At</strong></th>
                            <th><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($items as $item)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if($item->subcategory)
                                        <span class="badge bg-info">{{ $item->subcategory->name }}</span>
                                    @else
                                        <span class="text-muted">No subcategory</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.subcategory-items.edit', $item->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <form action="{{ route('admin.subcategory-items.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to {{ $item->is_active ? 'disable' : 'enable' }} this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item mb-0">
                                                    <i class="bx bx-{{ $item->is_active ? 'hide' : 'show' }} me-1"></i>
                                                    {{ $item->is_active ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#itemsTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "dom": "lrtip"
        });

        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>
