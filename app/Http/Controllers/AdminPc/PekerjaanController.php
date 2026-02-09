<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PekerjaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::with(['organisasiUnit']);

        // Filter Pencarian (Bisa cari Nama Anggota, Bidang, atau Jenis Usaha)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('business_sector', 'like', "%{$request->search}%")
                    ->orWhere('business_type', 'like', "%{$request->search}%");
            });
        }

        // Filter Spesifik Dropdown Bidang Usaha
        if ($request->business_sector) {
            $query->where('business_sector', $request->business_sector);
        }

        // Ambil data paginasi
        $anggotas = $query->whereNotNull('business_sector') // Hanya yang sudah isi bidang usaha
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Data Statistik: Top 5 Bidang Usaha Terbanyak
        $topJobs = Anggota::select('business_sector', DB::raw('count(*) as total'))
            ->whereNotNull('business_sector')
            ->groupBy('business_sector')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Data untuk Dropdown Filter (Ambil semua bidang usaha unik)
        $allJobs = Anggota::whereNotNull('business_sector')
            ->distinct()
            ->orderBy('business_sector')
            ->pluck('business_sector');

        return view('admin_pc.pekerjaan.index', compact('anggotas', 'topJobs', 'allJobs'));
    }
}
