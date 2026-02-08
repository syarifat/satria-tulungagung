<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Mengambil daftar desa berdasarkan ID Kecamatan.
     * Digunakan untuk dropdown dinamis via AJAX/Fetch.
     */
    public function getDesaByKecamatan($kecamatan_id)
    {
        // Ambil desa yang memiliki kecamatan_id sesuai parameter
        $desas = Desa::where('kecamatan_id', $kecamatan_id)
                     ->orderBy('nama', 'asc')
                     ->get(['id', 'nama']); // Hanya ambil id dan nama agar ringan

        return response()->json($desas);
    }
}