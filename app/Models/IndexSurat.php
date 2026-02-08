<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexSurat extends Model
{
    protected $fillable = ['kode', 'deskripsi'];

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }
}