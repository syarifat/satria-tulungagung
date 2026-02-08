<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\OrganisasiUnit;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::with(['user', 'organisasiUnit', 'jabatan']);

        // Filter Pencarian Nama/NIK
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('nik', 'like', "%{$request->search}%");
            });
        }

        // Filter PAC (Menampilkan anggota PAC tersebut + semua anggota PR di bawahnya)
        if ($request->pac_id && !$request->pr_id) {
            $pacId = $request->pac_id;
            // Ambil semua unit ID yang terkait (PAC itu sendiri + PR di bawahnya)
            $unitIds = OrganisasiUnit::where('id', $pacId)
                ->orWhere('parent_id', $pacId)
                ->pluck('id');

            $query->whereIn('organisasi_unit_id', $unitIds);
        }

        // Filter PR (Spesifik satu ranting)
        if ($request->pr_id) {
            $query->where('organisasi_unit_id', $request->pr_id);
        }

        // Handle Export PDF
        if ($request->has('export') && $request->export == 'pdf') {
            $anggotas = $query->latest()->get(); // Get all data for export
            $pdf = Pdf::loadView('admin_pc.anggota.pdf', compact('anggotas'));
            return $pdf->download('laporan-anggota.pdf');
        }

        $anggotas = $query->latest()->paginate(10)->withQueryString();

        // Data untuk Dropdown Filter
        $allPacs = OrganisasiUnit::where('level', 'pac')->orderBy('nama', 'asc')->get();

        // Data PR (tergantung PAC yang dipilih)
        $prs = [];
        if ($request->pac_id) {
            $prs = OrganisasiUnit::where('parent_id', $request->pac_id)
                ->where('level', 'pr')
                ->orderBy('nama', 'asc')
                ->get();
        }

        return view('admin_pc.anggota.index', compact('anggotas', 'allPacs', 'prs'));
    }

    public function create()
    {
        $jabatans = Jabatan::whereIn('level_akses', ['pc', 'all'])->orderBy('nama', 'asc')->get();
        $units = OrganisasiUnit::orderBy('level', 'asc')->get();
        return view('admin_pc.anggota.create', compact('jabatans', 'units'));
    }

    public function show(Anggota $anggota)
    {
        return view('admin_pc.anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota)
    {
        $jabatans = Jabatan::orderBy('nama', 'asc')->get();
        $units = OrganisasiUnit::orderBy('level', 'asc')->get();
        return view('admin_pc.anggota.edit', compact('anggota', 'jabatans', 'units'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16|unique:anggotas,nik,' . $anggota->id,
            'jabatan_id' => 'required|exists:jabatans,id',
            'organisasi_unit_id' => 'required|exists:organisasi_units,id',
            'kelamin' => 'required|in:L,P',
        ]);

        $anggota->update($request->all());

        // Update nama di tabel Users juga agar sinkron
        $anggota->user->update(['nama' => $request->nama]);

        return redirect()->route('admin_pc.anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        // Hapus User-nya juga (Cascade)
        $user = $anggota->user;
        $anggota->delete();
        $user->delete();

        return redirect()->route('admin_pc.anggota.index')
            ->with('success', 'Anggota dan akun login berhasil dihapus.');
    }

    /**
     * Jadikan Anggota sebagai Admin Unit
     */
}
