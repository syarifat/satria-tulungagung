<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'organisasi_unit_id', 'nama', 'deskripsi',
        'tanggal_mulai', 'tanggal_selesai', 'lokasi',
        'status', 'catatan_ditolak'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function organisasiUnit()
    {
        return $this->belongsTo(OrganisasiUnit::class);
    }
}