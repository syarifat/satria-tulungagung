<?php

namespace App\Http\Controllers\AdminPr;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Surat;
use App\Models\Agenda;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $unitId = Auth::user()->organisasi_unit_id;

        $stats = [
            'total_anggota' => Anggota::where('organisasi_unit_id', $unitId)->count(),
            'surat_aktif'   => Surat::where('organisasi_unit_id', $unitId)->count(),
            'agenda_pending'=> Agenda::where('organisasi_unit_id', $unitId)->where('status', 'pending')->count(),
        ];

        $latest_members = Anggota::where('organisasi_unit_id', $unitId)->latest()->take(5)->get();

        return view('admin_pr.dashboard', compact('stats', 'latest_members'));
    }
}