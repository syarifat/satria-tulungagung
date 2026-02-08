<?php

namespace App\Http\Controllers\AdminPr;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\IndexSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    public function index()
    {
        // Hanya ambil surat milik unit Ranting (PR) ini
        $surats = Surat::with('indexSurat')
                    ->where('organisasi_unit_id', Auth::user()->organisasi_unit_id)
                    ->latest()
                    ->paginate(10);

        return view('admin_pr.surat.index', compact('surats'));
    }

    public function create()
    {
        $indexes = IndexSurat::orderBy('kode', 'asc')->get();
        return view('admin_pr.surat.create', compact('indexes'));
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
            'status' => 'pending', 
            'dibuat_oleh' => Auth::id(),
        ]);

        return redirect()->route('admin_pr.surat.index')
                         ->with('success', 'Surat Ranting berhasil diajukan.');
    }

    public function show($id)
    {
        $surat = Surat::with('indexSurat')->findOrFail($id);

        if ($surat->organisasi_unit_id != Auth::user()->organisasi_unit_id) {
            abort(403);
        }

        return view('admin_pr.surat.show', compact('surat'));
    }
}