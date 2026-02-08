<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data anggota berdasarkan User yang login
        $anggota = Anggota::with(['organisasiUnit', 'jabatan'])
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        return view('anggota.dashboard', compact('anggota'));
    }
}