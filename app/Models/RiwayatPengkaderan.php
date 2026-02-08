<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPengkaderan extends Model
{
    protected $fillable = [
        'anggota_id', 'jenis_pengkaderan', 'tanggal_pelaksanaan',
        'pelaksana', 'nomor_sertifikat', 'url_dokumen'
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}