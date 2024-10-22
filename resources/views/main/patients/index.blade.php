@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4 order-0">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between">
                Bill Categories
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    Add New
                </button>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Priority</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>{{$category->prioritas}}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="dropdown-item edit-category" href="javascript:void(0);" data-id="{{$category->id}}">
                                        <i class="bx bx-edit-alt me-1 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item delete-category" href="javascript:void(0);" data-id="{{$category->id}}">
                                        <i class="bx bx-trash me-1 text-danger"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding New Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addCategoryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryPriority" class="form-label">Priority</label>
                        <input type="number" class="form-control" id="categoryPriority" name="prioritas" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCategoryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="categoryIdEdit" name="categoryId">
                    <div class="mb-3">
                        <label for="categoryNameEdit" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryNameEdit" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="categoryPriorityEdit" class="form-label">Priority</label>
                        <input type="number" class="form-control" id="categoryPriorityEdit" name="prioritas">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Add Category
            $('#addCategoryForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/bill-categories',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                'Category has been added.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to add category.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error adding category:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while adding the category.', 'error');
                    }
                });
            });

            // Edit Category
            $('.edit-category').on('click', function() {
                var categoryId = $(this).data('id');
                $.ajax({
                    url: '/bill-categories/' + categoryId + '/edit',
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            var category = response.category;
                            $('#categoryIdEdit').val(category.id);
                            $('#categoryNameEdit').val(category.name);
                            $('#categoryPriorityEdit').val(category.prioritas);
                            $('#editCategoryModal').modal('show');
                        } else {
                            Swal.fire('Error!', 'Failed to fetch category details.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error fetching category details:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while fetching category details.', 'error');
                    }
                });
            });

            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();
                var categoryId = $('#categoryIdEdit').val();
                $.ajax({
                    url: '/bill-categories/' + categoryId,
                    method: 'PUT',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                'Category has been updated.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to update category.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error updating category:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while updating the category.', 'error');
                    }
                });
            });

            // Delete Category
            $('.delete-category').on('click', function() {
                var categoryId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/bill-categories/' + categoryId,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Category has been deleted.',
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire('Error!', 'Failed to delete category.', 'error');
                                }
                            },
                            error: function(xhr) {
                                console.log('Error deleting category:', xhr.responseText);
                                Swal.fire('Error!', 'An error occurred while deleting the category.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
