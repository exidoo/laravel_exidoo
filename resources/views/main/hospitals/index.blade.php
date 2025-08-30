@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4 order-0">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between">
                Data Hospitals
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHospitalModal">
                    Add New
                </button>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($hospitals as $hospital)
                        <tr>
                            <td>{{$hospital->name}}</td>
                            <td>{{$hospital->location}}</td>
                            <td>{{$hospital->type}}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="dropdown-item edit-hospital" href="javascript:void(0);" data-id="{{$hospital->id}}">
                                        <i class="bx bx-edit-alt me-1 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item delete-hospital" href="javascript:void(0);" data-id="{{$hospital->id}}">
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

<!-- Modal for Adding New Hospital -->
<div class="modal fade" id="addHospitalModal" tabindex="-1" aria-labelledby="addHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addHospitalForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHospitalModalLabel">Add New Hospital</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="hospitalName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="hospitalName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalLocation" class="form-label">Location</label>
                        <input type="text" class="form-control" id="hospitalLocation" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalType" class="form-label">Type</label>
                        <input type="text" class="form-control" id="hospitalType" name="type" required>
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
<div class="modal fade" id="editHospitalModal" tabindex="-1" aria-labelledby="editHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editHospitalForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHospitalModalLabel">Edit Hospital</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hospitalIdEdit" name="hospitalId">
                    <div class="mb-3">
                        <label for="hospitalNameEdit" class="form-label">Name</label>
                        <input type="text" class="form-control" id="hospitalNameEdit" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalLocationEdit" class="form-label">Location</label>
                        <input type="text" class="form-control" id="hospitalLocationEdit" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalTypeEdit" class="form-label">Type</label>
                        <input type="text" class="form-control" id="hospitalTypeEdit" name="type" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <style>
        table .dropdown-item {
            width: auto !important;
            padding: .5rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#addHospitalForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{{url('/hospital')}}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#addHospitalModal').modal('hide');
                            Swal.fire({
                                title: 'Success!',
                                text: 'Hospital added successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to add hospital.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error adding hospital:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while adding the hospital.', 'error');
                    }
                });
            });

            $('.dropdown-item.edit-hospital').on('click', function() {
                var hospitalId = $(this).data('id');
                $.ajax({
                    url: `{{url('/hospital/${hospitalId}')}}`,
                    method: 'GET',
                    success: function(data) {
                        $('#hospitalIdEdit').val(data.id);
                        $('#hospitalNameEdit').val(data.name);
                        $('#hospitalLocationEdit').val(data.location);
                        $('#hospitalTypeEdit').val(data.type);
                        $('#editHospitalModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('Error fetching hospital data:', xhr.responseText);
                    }
                });
            });

            $('#editHospitalForm').on('submit', function(e) {
                e.preventDefault();
                var hospitalId = $('#hospitalIdEdit').val();
                var formData = $(this).serialize();
                $.ajax({
                    url: '/hospital/' + hospitalId,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#editHospitalModal').modal('hide');
                            Swal.fire({
                                title: 'Success!',
                                text: 'Hospital updated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to update hospital.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error updating hospital:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while updating the hospital.', 'error');
                    }
                });
            });

            $('.dropdown-item.delete-hospital').on('click', function() {
                var hospitalId = $(this).data('id');
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
                            url: '/hospital/' + hospitalId,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your hospital has been deleted.',
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire('Error!', 'Failed to delete hospital.', 'error');
                                }
                            },
                            error: function(xhr) {
                                console.log('Error deleting hospital:', xhr.responseText);
                                Swal.fire('Error!', 'An error occurred while deleting the hospital.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
