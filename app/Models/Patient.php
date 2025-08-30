<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Menentukan atribut yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama_pasien',
        'alamat',
        'telepon',
        'hospital_id', // Menyimpan ID rumah sakit yang terkait
    ];

    // Relasi ke model Hospital
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
