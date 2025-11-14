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
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="heading-text mb-0"><strong>Manage Items: {{ $subcategory->name }}</strong></h5>
                    <small class="text-muted">Add and manage items for this subcategory</small>
                </div>
                <div>
                    <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Back to Subcategories</a>
                </div>
            </div>

            <div class="card-body">
                <!-- Add New Item Form -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3"><strong>Add New Item</strong></h6>
                    <form action="{{ route('admin.subcategories.store-item', $subcategory->id) }}" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <label class="form-label" for="new_item_name">Item Name</label>
                                <input type="text" class="form-control" name="name" id="new_item_name"
                                    placeholder="Enter item name" required />
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="new_is_active"
                                        value="1" checked>
                                    <label class="form-check-label" for="new_is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bx bx-plus"></i> Add Item
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Items List -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">Sr No.</th>
                                <th width="45%">Item Name</th>
                                <th width="15%">Status</th>
                                <th width="15%">Created At</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr id="item-row-{{ $item->id }}">
                                    <td class="text-center"><strong>{{ $loop->iteration }}</strong></td>
                                    <td>
                                        <span id="item-name-{{ $item->id }}">{{ $item->name }}</span>
                                        <div id="edit-form-{{ $item->id }}" style="display: none;">
                                            <form action="{{ route('admin.subcategories.update-item', [$subcategory->id, $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ $item->name }}" required>
                                                    <input type="hidden" name="is_active" value="{{ $item->is_active }}">
                                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        onclick="toggleEdit({{ $item->id }})">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
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
                                        <button type="button" class="btn btn-sm btn-primary"
                                            onclick="toggleEdit({{ $item->id }})">
                                            <i class="bx bx-edit-alt"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.subcategories.toggle-item', [$subcategory->id, $item->id]) }}"
                                            method="POST" style="display: inline-block;"
                                            onsubmit="return confirm('Are you sure you want to {{ $item->is_active ? 'disable' : 'enable' }} this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-{{ $item->is_active ? 'warning' : 'success' }}">
                                                <i class="bx bx-{{ $item->is_active ? 'hide' : 'show' }}"></i>
                                                {{ $item->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No items found. Add your first item using the form above.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleEdit(itemId) {
            const nameSpan = document.getElementById('item-name-' + itemId);
            const editForm = document.getElementById('edit-form-' + itemId);

            if (editForm.style.display === 'none') {
                nameSpan.style.display = 'none';
                editForm.style.display = 'block';
            } else {
                nameSpan.style.display = 'inline';
                editForm.style.display = 'none';
            }
        }
    </script>
@endsection
