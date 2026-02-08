<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisasiUnit extends Model
{
    protected $fillable = [
        'nama', 'level', 'parent_id', 
        'kecamatan_id', 'desa_id', 
        'alamat_sekretariat', 'email', 'notelp'
    ];

    // Relasi ke Induk (Contoh: PAC ke PC)
    public function parent()
    {
        return $this->belongsTo(OrganisasiUnit::class, 'parent_id');
    }

    // Relasi ke Anak (Contoh: PC ke banyak PAC)
    public function children()
    {
        return $this->hasMany(OrganisasiUnit::class, 'parent_id');
    }

    // Wilayah
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    // User Admin di Unit ini
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Kader di Unit ini
    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }
}