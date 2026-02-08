<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = [
        'user_id', 'organisasi_unit_id', 'jabatan_id',
        'nik', 'nia_ansor', 'nama', 'tempat_lahir', 'tanggal_lahir',
        'kelamin', 'status_kawin', 'notelp', 'url_foto',
        'alamat', 'kecamatan_id', 'desa_id',
        'last_education', 'job_title', 'job_address'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi Utama
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organisasiUnit()
    {
        return $this->belongsTo(OrganisasiUnit::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    // Relasi Alamat Domisili
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    // Relasi Riwayat
    public function riwayatPengkaderans()
    {
        return $this->hasMany(RiwayatPengkaderan::class);
    }
}