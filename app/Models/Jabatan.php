<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['nama', 'level_akses'];

    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }
}