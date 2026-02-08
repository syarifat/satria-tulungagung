<?php

namespace App\Http\Controllers\AdminPac;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\OrganisasiUnit;
use App\Models\Surat;
use App\Models\Agenda;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil ID Unit PAC milik user yang login
        $unitId = Auth::user()->organisasi_unit_id;

        // 2. Ambil semua ID Ranting (PR) yang parent_id-nya adalah PAC ini
        $rantingIds = OrganisasiUnit::where('parent_id', $unitId)->pluck('id');
        
        // 3. Gabungkan ID PAC dan ID Ranting untuk memfilter data anggota
        $allUnitIds = $rantingIds->push($unitId);

        $stats = [
            // Total Anggota di PAC tersebut dan seluruh Ranting di bawahnya
            'total_anggota' => Anggota::whereIn('organisasi_unit_id', $allUnitIds)->count(),
            // Jumlah Pimpinan Ranting (Desa) yang terdaftar
            'total_ranting' => OrganisasiUnit::where('parent_id', $unitId)->where('level', 'pr')->count(),
            // Surat PAC yang dikirim ke PC dan masih berstatus pending
            'surat_pending' => Surat::where('organisasi_unit_id', $unitId)->where('status', 'pending')->count(),
            // Agenda di wilayah PAC/PR yang sudah disetujui
            'agenda_aktif'  => Agenda::whereIn('organisasi_unit_id', $allUnitIds)->where('status', 'diterima')->count(),
        ];

        // 4. Ambil 5 Anggota terbaru yang diinput di wilayah PAC ini
        $latest_members = Anggota::with('organisasiUnit')
                            ->whereIn('organisasi_unit_id', $allUnitIds)
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin_pac.dashboard', compact('stats', 'latest_members'));
    }
}