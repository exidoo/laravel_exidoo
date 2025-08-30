<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // Primary key dengan auto-increment
            $table->string('nama_pasien');
            $table->text('alamat');
            $table->string('telepon');
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade'); // Foreign key, bukan auto_increment
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
