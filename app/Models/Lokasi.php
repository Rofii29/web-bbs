<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';

    protected $fillable = [
        'nama_lokasi',
        'area',
    ];

    public function observasi()
    {
        return $this->hasMany(ObservasiBbs::class, 'lokasi_id');
    }
}
