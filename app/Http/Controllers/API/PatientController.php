<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data pasien
        $patients = Patient::with('hospital')->get(); // Mengambil pasien dengan relasi rumah sakit
        return response()->json($patients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'hospital_id' => 'required|exists:hospitals,id', // Pastikan hospital_id valid
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Membuat pasien baru
        $patient = Patient::create([
            'nama_pasien' => $request->nama_pasien,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'hospital_id' => $request->hospital_id,
        ]);

        return response()->json($patient, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Menampilkan pasien berdasarkan ID
        $patient = Patient::with('hospital')->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'sometimes|required|string|max:255',
            'alamat' => 'sometimes|required|string|max:255',
            'telepon' => 'sometimes|required|string|max:20',
            'hospital_id' => 'sometimes|required|exists:hospitals,id', // Pastikan hospital_id valid
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Mencari pasien yang akan diperbarui
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        // Memperbarui data pasien
        $patient->update($request->all());

        return response()->json($patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari pasien yang akan dihapus
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        // Menghapus pasien
        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
