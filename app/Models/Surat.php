<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $fillable = [
        'organisasi_unit_id', 'index_surat_id', 
        'nomor_surat', 'perihal', 'jenis_surat',
        'pengirim', 'penerima', 'kategori_surat', 
        'tanggal_surat', 'url_dokumen',
        'status', 'catatan_ditolak', 
        'diterima_oleh', 'dibuat_oleh'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    // Relasi Organisasi & Master
    public function organisasiUnit()
    {
        return $this->belongsTo(OrganisasiUnit::class);
    }

    public function indexSurat()
    {
        return $this->belongsTo(IndexSurat::class);
    }

    // Relasi ke User (Tracking siapa yg buat & ACC)
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function penyetujui()
    {
        return $this->belongsTo(User::class, 'diterima_oleh');
    }
}