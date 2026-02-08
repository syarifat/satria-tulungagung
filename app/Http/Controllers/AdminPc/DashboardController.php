<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\OrganisasiUnit;
use App\Models\Surat;
use App\Models\Agenda;
use App\Models\Jabatan;
use App\Models\IndexSurat;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_anggota' => Anggota::count(),
            'total_pac'     => OrganisasiUnit::where('level', 'pac')->count(),
            'total_pr'      => OrganisasiUnit::where('level', 'pr')->count(),
            'total_jabatan' => Jabatan::count(),
            'total_index'   => IndexSurat::count(),
            'surat_pending' => Surat::where('status', 'pending')->count(),
            'agenda_pending'=> Agenda::where('status', 'pending')->orWhere('status', 'permintaan')->count(),
        ];

        // Ambil 5 Anggota Terbaru
        $latest_members = Anggota::with('organisasiUnit')->latest()->take(5)->get();

        return view('admin_pc.dashboard', compact('stats', 'latest_members'));
    }
}