<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{

    public function getHospitalPage()
{
    // Mengambil semua data rumah sakit untuk ditampilkan di halaman
    $hospitals = Hospital::all();

    // Mengembalikan view dengan data rumah sakit
    return view('hospitals.index', compact('hospitals'));
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data rumah sakit
        $hospitals = Hospital::all();
        return response()->json($hospitals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Membuat rumah sakit baru
        $hospital = Hospital::create([
            'nama_rumah_sakit' => $request->nama_rumah_sakit,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon,
        ]);

        return response()->json($hospital, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Menampilkan rumah sakit berdasarkan ID
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        return response()->json($hospital);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_rumah_sakit' => 'sometimes|required|string|max:255',
            'alamat' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'telepon' => 'sometimes|required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Mencari rumah sakit yang akan diperbarui
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        // Memperbarui data rumah sakit
        $hospital->update($request->all());

        return response()->json($hospital);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari rumah sakit yang akan dihapus
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        // Menghapus rumah sakit
        $hospital->delete();

        return response()->json(['message' => 'Hospital deleted successfully']);
    }
}
