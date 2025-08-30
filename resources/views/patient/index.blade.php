@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4 order-0">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between">
                Patient List
                <div>
                    <select id="hospitalFilter" class="form-select" style="width: 200px; display: inline-block;">
                        <option value="">All Hospitals</option>
                        @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->nama_rumah_sakit }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                        Add New Patient
                    </button>
                </div>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" id="patientsTable">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Hospital</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="patientsTableBody">
                        @foreach ($patients as $patient)
                        <tr>
                            <td>{{$patient->nama_pasien}}</td>
                            <td>{{$patient->alamat}}</td>
                            <td>{{$patient->telepon}}</td>
                            <td>{{$patient->hospital ? $patient->hospital->nama_rumah_sakit : 'Unknown'}}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="dropdown-item view-patient" href="javascript:void(0);" data-id="{{ $patient->id }}">
                                        <i class="bx bx-info-circle me-1 text-info"></i>
                                    </a>
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


<!-- Modal untuk Menampilkan Detail Pasien -->
<div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPatientModalLabel">Detail Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="patientDetails">
                <p><strong>Name:</strong> <span id="patientNameDetail"></span></p>
                <p><strong>Address:</strong> <span id="patientAddressDetail"></span></p>
                <p><strong>Phone:</strong> <span id="patientPhoneDetail"></span></p>
                <p><strong>Hospital:</strong> <span id="patientHospitalDetail"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
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
        var formData = $(this).serialize();
        $.ajax({
            url: '{{ url('/patients') }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#addPatientModal').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: 'Patient has been added successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
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
                Swal.fire('Error!', 'An error occurred while adding the patient: ' + xhr.responseText, 'error');
            }
        });
    });

    // View Patient Details
    $('.dropdown-item.view-patient').on('click', function() {
        var patientId = $(this).data('id');
        $.ajax({
            url: '/patients/' + patientId,
            method: 'GET',
            success: function(data) {
                $('#patientNameDetail').text(data.data.nama_pasien);
                $('#patientAddressDetail').text(data.data.alamat);
                $('#patientPhoneDetail').text(data.data.telepon);
                $('#patientHospitalDetail').text(data.data.nama_rumah_sakit);
                $('#viewPatientModal').modal('show');
            },
            error: function(xhr) {
                console.log('Error fetching patient data:', xhr.responseText);
            }
        });
    });

    // Edit Patient
    $('.dropdown-item.edit-patient').on('click', function() {
        var patientId = $(this).data('id');
        $.ajax({
            url: '/patients/' + patientId,
            method: 'GET',
            success: function(data) {
                $('#patientIdEdit').val(data.data.id);
                $('#patientNameEdit').val(data.data.nama_pasien);
                $('#patientAddressEdit').val(data.data.alamat);
                $('#patientPhoneEdit').val(data.data.telepon);
                $('#hospitalIdEdit').val(data.data.hospital_id);
                $('#editPatientModal').modal('show');
            },
            error: function(xhr) {
                console.log('Error fetching patient data:', xhr.responseText);
            }
        });
    });

    $('#editPatientForm').on('submit', function(e) {
        e.preventDefault();
        var patientId = $('#patientIdEdit').val();
        var formData = $(this).serialize();
        console.log(patientId, formData)
        $.ajax({
            url: '/patients/' + patientId,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#editPatientModal').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: 'Patient has been updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
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
                Swal.fire('Error!', 'An error occurred while updating the patient: ' + xhr.responseText, 'error');
            }
        });
    });

   // Delete Patient
$('.dropdown-item.delete-patient').on('click', function() {
    var patientId = $(this).data('id');

    // SweetAlert for confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
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
                    Swal.fire(
                        'Deleted!',
                        'Patient has been deleted successfully.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    console.log('Error deleting patient:', xhr.responseText);
                    Swal.fire('Error!', 'An error occurred while deleting the patient. Please try again.', 'error');
                }
            });
        }
    });
});



    $(document).ready(function() {
    // Filter berdasarkan Rumah Sakit
        $('#hospitalFilter').on('change', function() {
            var hospitalId = $(this).val();

            if (hospitalId === "") {
                // Reset ke data awal dari Blade
                location.reload(); // cara paling simpel
                return;
            }

            var url = '/patients/filter/' + hospitalId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var patientsTableBody = $('#patientsTableBody');
                    patientsTableBody.empty();

                    $.each(response.patients, function(index, patient) {
                        var hospitalName = patient.hospital ? patient.hospital.nama_rumah_sakit : 'Unknown';

                        var patientRow = '<tr>' +
                            '<td>' + patient.nama_pasien + '</td>' +
                            '<td>' + patient.alamat + '</td>' +
                            '<td>' + patient.telepon + '</td>' +
                            '<td>' + hospitalName + '</td>' +
                            '<td>' +
                                '<div class="d-flex">' +
                                    '<a class="dropdown-item view-patient" href="javascript:void(0);" data-id="' + patient.id + '">' +
                                        '<i class="bx bx-info-circle me-1 text-info"></i>' +
                                    '</a>' +
                                    '<a class="dropdown-item edit-patient" href="javascript:void(0);" data-id="' + patient.id + '">' +
                                        '<i class="bx bx-edit-alt me-1 text-primary"></i>' +
                                    '</a>' +
                                    '<a class="dropdown-item delete-patient" href="javascript:void(0);" data-id="' + patient.id + '">' +
                                        '<i class="bx bx-trash me-1 text-danger"></i>' +
                                    '</a>' +
                                '</div>' +
                            '</td>' +
                        '</tr>';

                        patientsTableBody.append(patientRow);
                    });
                },
                error: function(xhr) {
                    console.log('Error fetching patients:', xhr.responseText);
                }
            });
        });
});
});
</script>
@endpush
