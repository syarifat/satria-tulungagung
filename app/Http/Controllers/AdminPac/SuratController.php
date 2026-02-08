<?php

namespace App\Http\Controllers\AdminPac;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\IndexSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    public function index()
    {
        // Hanya ambil surat milik unit PAC yang sedang login
        $surats = Surat::with('indexSurat')
                    ->where('organisasi_unit_id', Auth::user()->organisasi_unit_id)
                    ->latest()
                    ->paginate(10);

        return view('admin_pac.surat.index', compact('surats'));
    }

    public function create()
    {
        $indexes = IndexSurat::orderBy('kode', 'asc')->get();
        return view('admin_pac.surat.create', compact('indexes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perihal' => 'required|string|max:255',
            'index_surat_id' => 'required|exists:index_surats,id',
            'penerima' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
        ]);

        Surat::create([
            'organisasi_unit_id' => Auth::user()->organisasi_unit_id,
            'index_surat_id' => $request->index_surat_id,
            'perihal' => $request->perihal,
            'penerima' => $request->penerima,
            'tanggal_surat' => $request->tanggal_surat,
            'jenis_surat' => 'keluar',
            'status' => 'pending', // Otomatis pending untuk di-approve PC
            'dibuat_oleh' => Auth::id(),
        ]);

        return redirect()->route('admin_pac.surat.index')
                         ->with('success', 'Surat berhasil diajukan ke Pimpinan Cabang.');
    }

    public function show(Surat $surat)
    {
        // Proteksi akses
        if ($surat->organisasi_unit_id !== Auth::user()->organisasi_unit_id) {
            abort(403);
        }

        return view('admin_pac.surat.show', compact('surat'));
    }

    public function destroy(Surat $surat)
    {
        if ($surat->status !== 'pending') {
            return back()->with('error', 'Surat yang sudah diproses tidak bisa dihapus.');
        }

        $surat->delete();
        return redirect()->route('admin_pac.surat.index')->with('success', 'Draf surat dibatalkan.');
    }
}