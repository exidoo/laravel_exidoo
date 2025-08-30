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
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($hospitals as $hospital)
                        <tr>
                            <td>{{ $hospital->nama_rumah_sakit }}</td>
                            <td>{{ $hospital->alamat }}</td>
                            <td>{{ $hospital->email }}</td>
                            <td>{{ $hospital->telepon }}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="dropdown-item view-hospital" href="javascript:void(0);" data-id="{{ $hospital->id }}">
                                        <i class="bx bx-info-circle me-1 text-info"></i>
                                    </a>
                                    <a class="dropdown-item edit-hospital" href="javascript:void(0);" data-id="{{ $hospital->id }}">
                                        <i class="bx bx-edit-alt me-1 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item delete-hospital" href="javascript:void(0);" data-id="{{ $hospital->id }}">
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
<div class="modal fade" id="addHospitalModal" tabindex="-1" aria-labelledby="addHospitalModalLabel" aria-hidden="true" >
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
                        <input type="text" class="form-control" id="hospitalName" name="nama_rumah_sakit" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="hospitalAddress" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="hospitalEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="hospitalPhone" name="telepon" required>
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


<!-- Modal untuk Menampilkan Detail Rumah Sakit -->
<div class="modal fade" id="viewHospitalModal" tabindex="-1" aria-labelledby="viewHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewHospitalModalLabel">Detail Rumah Sakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="hospitalDetails">
                <p><strong>Name:</strong> <span id="hospitalNameDetail"></span></p>
                <p><strong>Address:</strong> <span id="hospitalAddressDetail"></span></p>
                <p><strong>Email:</strong> <span id="hospitalEmailDetail"></span></p>
                <p><strong>Phone:</strong> <span id="hospitalPhoneDetail"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editHospitalModal" tabindex="-1" aria-labelledby="editHospitalModalLabel" aria-hidden="true" >
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
                        <input type="text" class="form-control" id="hospitalNameEdit" name="nama_rumah_sakit" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalAddressEdit" class="form-label">Address</label>
                        <input type="text" class="form-control" id="hospitalAddressEdit" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalEmailEdit" class="form-label">Email</label>
                        <input type="email" class="form-control" id="hospitalEmailEdit" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalPhoneEdit" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="hospitalPhoneEdit" name="telepon" required>
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
            url: '{{ url('/hospitals') }}',
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
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function(xhr) {
                console.log('Error adding hospital:', xhr.responseText);
                Swal.fire('Error!', 'An error occurred while adding the hospital: ' + xhr.responseText, 'error');
            }
        });
    });

    $('.dropdown-item.view-hospital').on('click', function() {
        var hospitalId = $(this).data('id');
        $.ajax({
            url: '/hospitals/' + hospitalId,
            method: 'GET',
            success: function(data) {
                $('#hospitalNameDetail').text(data.data.nama_rumah_sakit);
                $('#hospitalAddressDetail').text(data.data.alamat);
                $('#hospitalEmailDetail').text(data.data.email);
                $('#hospitalPhoneDetail').text(data.data.telepon);
                $('#viewHospitalModal').modal('show');
            },
            error: function(xhr) {
                console.log('Error fetching hospital data:', xhr.responseText);
            }
        });
    });

    $('.dropdown-item.edit-hospital').on('click', function() {
        var hospitalId = $(this).data('id');
        $.ajax({
            url: '/hospitals/' + hospitalId,
            method: 'GET',
            success: function(data) {
                $('#hospitalIdEdit').val(data.data.id);
                $('#hospitalNameEdit').val(data.data.nama_rumah_sakit);
                $('#hospitalAddressEdit').val(data.data.alamat);
                $('#hospitalEmailEdit').val(data.data.email);
                $('#hospitalPhoneEdit').val(data.data.telepon);
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
            url: '/hospitals/' + hospitalId,
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
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function(xhr) {
                console.log('Error updating hospital:', xhr.responseText);
                Swal.fire('Error!', 'An error occurred while updating the hospital: ' + xhr.responseText, 'error');
            }
        });
    });

  // Updated delete confirmation using default alert
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
                    url: '/hospitals/' + hospitalId,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'Hospital has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.log('Error deleting hospital:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while deleting the hospital. Please try again.', 'error');
                    }
                });
            }
        });
    });

});
</script>
@endpush

