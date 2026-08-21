<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingC45 extends Model
{
    use HasFactory;

    protected $table = 'training_c45';

    protected $fillable = [
        'jenis_perilaku',
        'kategori_id',
        'lokasi_id',
        'tingkat_potensi_bahaya',
        'kepatuhan_prosedur',
        'tingkat_risiko',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPerilaku::class, 'kategori_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}
