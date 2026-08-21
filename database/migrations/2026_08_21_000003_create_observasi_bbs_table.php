<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observasi_bbs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasi')->onDelete('cascade');
            $table->string('unit_departemen');
            $table->enum('jenis_perilaku', ['safe', 'at_risk']);
            $table->foreignId('kategori_id')->constrained('kategori_perilaku')->onDelete('cascade');
            $table->text('ketika')->nullable();
            $table->text('ditemukan');
            $table->text('sebab')->nullable();
            $table->text('saran')->nullable();
            $table->enum('tingkat_risiko', ['rendah', 'sedang', 'tinggi'])->default('rendah');
            $table->enum('status_tindak_lanjut', ['open', 'in_progress', 'closed'])->default('open');
            $table->text('catatan_tindak_lanjut')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observasi_bbs');
    }
};
