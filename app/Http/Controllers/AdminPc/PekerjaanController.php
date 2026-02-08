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

        // Filter Pencarian (Bisa cari Nama Anggota ATAU Nama Pekerjaan)
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('job_title', 'like', "%{$request->search}%");
            });
        }

        // Filter Spesifik Dropdown Pekerjaan
        if ($request->job_title) {
            $query->where('job_title', $request->job_title);
        }

        // Ambil data paginasi
        $anggotas = $query->whereNotNull('job_title') // Hanya yang sudah isi pekerjaan
                          ->latest()
                          ->paginate(10)
                          ->withQueryString();

        // Data Statistik: Top 5 Pekerjaan Terbanyak
        $topJobs = Anggota::select('job_title', DB::raw('count(*) as total'))
                    ->whereNotNull('job_title')
                    ->groupBy('job_title')
                    ->orderByDesc('total')
                    ->limit(5)
                    ->get();

        // Data untuk Dropdown Filter (Ambil semua jenis pekerjaan unik)
        $allJobs = Anggota::whereNotNull('job_title')
                    ->distinct()
                    ->orderBy('job_title')
                    ->pluck('job_title');

        return view('admin_pc.pekerjaan.index', compact('anggotas', 'topJobs', 'allJobs'));
    }
}