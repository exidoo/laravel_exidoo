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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:hospitals,email',
            'telepon' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menyimpan data ke database
        Hospital::create([
            'nama_rumah_sakit' => $request->nama_rumah_sakit,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('hospitals.index')->with('success', 'Rumah sakit berhasil ditambahkan.');
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
        $hospital = Hospital::findOrFail($id);
        $hospital->update([
            'nama_rumah_sakit' => $request->nama_rumah_sakit,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('hospitals.index')->with('success', 'Data rumah sakit berhasil diperbarui.');
    }

    // Menghapus rumah sakit
    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->delete();

        return redirect()->route('hospitals.index')->with('success', 'Rumah sakit berhasil dihapus.');
    }
}
