<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use Illuminate\Support\Facades\Validator;

class HospitalControllerWeb extends Controller
{
    // Menampilkan daftar rumah sakit
    public function index()
    {
        $hospitals = Hospital::all();
        return view('hospital.index', compact('hospitals')); 
    }


    // Menampilkan form untuk membuat rumah sakit baru
    public function create()
    {
        return view('hospital.create'); 
    }

    // Menyimpan data rumah sakit baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
        ]);

        try {
            Hospital::create($request->all());
            return response()->json(['success' => true, 'message' => 'Hospital added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to add hospital.', 'error' => $e->getMessage()], 500);
        }
    }



    // Menampilkan detail rumah sakit
    public function show($id)
    {
        $hospital = Hospital::findOrFail($id);
        return response()->json(['data'=> $hospital  ]);
    }

    // Menampilkan form edit rumah sakit
    public function edit($id)
    {
        $hospital = Hospital::findOrFail($id);
        return view('hospital.edit', compact('hospital')); // Pastikan view 'hospital.edit' tersedia
    }

    // Memperbarui data rumah sakit
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email,' . $id,
            'telepon' => 'required|string|max:20',
        ]);

        // Jika validasi gagal, return error response dalam format JSON
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        // Mengupdate data di database
        try {
            $hospital = Hospital::findOrFail($id);
            $hospital->update([
                'nama_rumah_sakit' => $request->nama_rumah_sakit,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'telepon' => $request->telepon,
            ]);

            // Jika berhasil, return success response dalam format JSON
            return response()->json([
                'success' => true,
                'message' => 'Hospital updated successfully.'
            ]);

        } catch (\Exception $e) {
            // Menangani error dan mengembalikan response error
            return response()->json([
                'success' => false,
                'message' => 'Failed to update hospital.',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }


    public function destroy($id)
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            return response()->json(['success' => false, 'message' => 'Hospital not found.'], 404);
        }

        $hospital->delete();

        return response()->json(['success' => true, 'message' => 'Hospital deleted successfully.']);
    }

}
