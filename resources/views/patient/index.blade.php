@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4 order-0">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between">
                Patient List
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                    Add New Patient
                </button>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Hospital</th> <!-- Nama Rumah Sakit -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($patients as $patient)
                        <tr>
                            <td>{{$patient->nama_pasien}}</td>
                            <td>{{$patient->alamat}}</td>
                            <td>{{$patient->telepon}}</td>
                            <td>{{$patient->hospital ? $patient->hospital->nama_rumah_sakit : 'Unknown'}}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="dropdown-item edit-patient" href="javascript:void(0);" data-id="{{$patient->id}}">
                                        <i class="bx bx-edit-alt me-1 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item delete-patient" href="javascript:void(0);" data-id="{{$patient->id}}">
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

<!-- Modal for Adding New Patient -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addPatientForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patientName" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="patientName" name="nama_pasien" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="patientAddress" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="patientPhone" name="telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospitalId" class="form-label">Hospital</label>
                        <select class="form-select" id="hospitalId" name="hospital_id" required>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->nama_rumah_sakit }}</option>
                            @endforeach
                        </select>
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
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editPatientForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="patientIdEdit" name="patientId">
                    <div class="mb-3">
                        <label for="patientNameEdit" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="patientNameEdit" name="nama_pasien">
                    </div>
                    <div class="mb-3">
                        <label for="patientAddressEdit" class="form-label">Address</label>
                        <input type="text" class="form-control" id="patientAddressEdit" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="patientPhoneEdit" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="patientPhoneEdit" name="telepon">
                    </div>
                    <div class="mb-3">
                        <label for="hospitalIdEdit" class="form-label">Hospital</label>
                        <select class="form-select" id="hospitalIdEdit" name="hospital_id">
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->nama_rumah_sakit }}</option>
                            @endforeach
                        </select>
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
            // Add Patient
            $('#addPatientForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/patients',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                'Patient has been added.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to add patient.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error adding patient:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while adding the patient.', 'error');
                    }
                });
            });

            // Edit Patient
            $('.edit-patient').on('click', function() {
                var patientId = $(this).data('id');
                $.ajax({
                    url: '/patients/' + patientId + '/edit',
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            var patient = response.patient;
                            $('#patientIdEdit').val(patient.id);
                            $('#patientNameEdit').val(patient.nama_pasien);
                            $('#patientAddressEdit').val(patient.alamat);
                            $('#patientPhoneEdit').val(patient.telepon);
                            $('#hospitalIdEdit').val(patient.hospital_id);
                            $('#editPatientModal').modal('show');
                        } else {
                            Swal.fire('Error!', 'Failed to fetch patient details.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error fetching patient details:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while fetching patient details.', 'error');
                    }
                });
            });

            $('#editPatientForm').on('submit', function(e) {
                e.preventDefault();
                var patientId = $('#patientIdEdit').val();
                $.ajax({
                    url: '/patients/' + patientId,
                    method: 'PUT',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                'Patient has been updated.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to update patient.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error updating patient:', xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while updating the patient.', 'error');
                    }
                });
            });

            // Delete Patient
            $('.delete-patient').on('click', function() {
                var patientId = $(this).data('id');
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
                            url: '/patients/' + patientId,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Patient has been deleted.',
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire('Error!', 'Failed to delete patient.', 'error');
                                }
                            },
                            error: function(xhr) {
                                console.log('Error deleting patient:', xhr.responseText);
                                Swal.fire('Error!', 'An error occurred while deleting the patient.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
