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
        return view('patient.index', compact('patients', 'hospitals'));
    }

    // Menampilkan form untuk menambah pasien baru
    public function create()
    {
        $hospitals = Hospital::all(); // Mengambil semua rumah sakit untuk dropdown pilihan
        return view('patient.create', compact('hospitals')); // Pastikan view 'patient.create' tersedia
    }

    // Menyimpan data pasien baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
            'hospital_id' => 'required|exists:hospitals,id', // Validasi bahwa ID rumah sakit harus ada di tabel hospitals
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menyimpan data ke database
        Patient::create([
            'nama_pasien' => $request->nama_pasien,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'hospital_id' => $request->hospital_id,
        ]);

        return redirect()->route('patients.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    // Menampilkan detail pasien
    public function show($id)
    {
        $patient = Patient::with('hospital')->findOrFail($id);
        return view('patient.show', compact('patient')); // Pastikan view 'patient.show' tersedia
    }

    // Menampilkan form untuk mengedit pasien
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        $hospitals = Hospital::all(); // Ambil daftar rumah sakit untuk dropdown
        return view('patient.edit', compact('patient', 'hospitals')); // Pastikan view 'patient.edit' tersedia
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mengupdate data di database
        $patient = Patient::findOrFail($id);
        $patient->update([
            'nama_pasien' => $request->nama_pasien,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'hospital_id' => $request->hospital_id,
        ]);

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    // Menghapus pasien
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Pasien berhasil dihapus.');
    }
}
