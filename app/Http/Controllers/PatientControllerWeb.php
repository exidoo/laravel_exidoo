<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Support\Facades\Validator;

class PatientControllerWeb extends Controller
{
    // Menampilkan daftar semua pasien
    public function index()
    {
        $patients = Patient::with('hospital')->get();
        $hospitals = Hospital::all();
        return view('patient.index', compact('patients', 'hospitals')); // Pastikan view tersedia
    }


    // Menampilkan form untuk menambah pasien baru
    public function create()
    {
        $hospitals = Hospital::all(); // Mengambil semua rumah sakit untuk dropdown
        return view('patient.create', compact('hospitals')); // Pastikan view tersedia
    }

    // Menyimpan data pasien baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Menyimpan data ke database
        try {
            Patient::create([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'hospital_id' => $request->hospital_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Patient successfully added.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add patient.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

// Menampilkan detail pasien
public function show($id)
{
    $patient = Patient::with('hospital')->find($id);  
    return response()->json([
        'data' => $patient
    ]);
}


public function filterByHospital($hospitalId = null)
{
    $patients = $hospitalId
        ? Patient::with('hospital')->where('hospital_id', $hospitalId)->get()
        : Patient::with('hospital')->get();

    return response()->json(['patients' => $patients]);
}


    // Menampilkan form untuk mengedit pasien
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        $hospitals = Hospital::all(); // Ambil daftar rumah sakit untuk dropdown
        return view('patient.edit', compact('patient', 'hospitals')); // Pastikan view tersedia
    }

    // Memperbarui data pasien
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Mengupdate data di database
        try {
            $patient = Patient::findOrFail($id);
            $patient->update([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'hospital_id' => $request->hospital_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Patient successfully updated.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update patient.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Menghapus pasien
    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();

            return response()->json([
                'success' => true,
                'message' => 'Patient successfully deleted.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete patient.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
