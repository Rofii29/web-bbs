<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_c45', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_perilaku', ['safe', 'at_risk']);
            $table->foreignId('kategori_id')->constrained('kategori_perilaku')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasi')->onDelete('cascade');
            $table->enum('tingkat_potensi_bahaya', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->enum('kepatuhan_prosedur', ['patuh', 'melanggar'])->default('patuh');
            $table->enum('tingkat_risiko', ['rendah', 'sedang', 'tinggi']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_c45');
    }
};
