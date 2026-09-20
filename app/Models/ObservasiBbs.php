<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservasiBbs extends Model
{
    use HasFactory;

    protected $table = 'observasi_bbs';

    protected $fillable = [
        'tanggal',
        'user_id',
        'lokasi_id',
        'unit_departemen',
        'jenis_perilaku',
        'kategori_id',
        'item_states',
        'ketika',
        'ditemukan',
        'sebab',
        'saran',
        'tingkat_risiko',
        'status_tindak_lanjut',
        'catatan_tindak_lanjut',
    ];

    protected $casts = [
        'item_states' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPerilaku::class, 'kategori_id');
    }
}
