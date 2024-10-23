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
        return view('hospital.index', compact('hospitals')); // Pastikan view 'hospital.index' tersedia
    }

    // Menampilkan form untuk membuat rumah sakit baru
    public function create()
    {
        return view('hospital.create'); // Pastikan view 'hospital.create' tersedia
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
        return view('hospital.show', compact('hospital')); // Pastikan view 'hospital.show' tersedia
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
            'alamat' => 'required|string',
            'email' => 'required|email|unique:hospitals,email,' . $id,
            'telepon' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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

            return redirect()->route('hospitals.index')->with('success', 'Data rumah sakit berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data rumah sakit: ' . $e->getMessage());
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
