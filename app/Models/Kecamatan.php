<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    // Konfigurasi karena ID bukan Auto Increment (Integer)
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nama'];

    // Relasi
    public function desas()
    {
        return $this->hasMany(Desa::class);
    }
}