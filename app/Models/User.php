<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'organisasi_unit_id',
        'role',
        'is_active',
        'google_id',
        'avatar',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    // Relasi
    public function organisasiUnit()
    {
        return $this->belongsTo(OrganisasiUnit::class);
    }

    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }

    // Cek apakah user adalah Admin PC
    public function isAdminPc()
    {
        return $this->role === 'admin_pc';
    }

    // Cek apakah user adalah Admin PAC
    public function isAdminPac()
    {
        return $this->role === 'admin_pac';
    }

    // Cek apakah user adalah Admin PR
    public function isAdminPr()
    {
        return $this->role === 'admin_pr';
    }
}
