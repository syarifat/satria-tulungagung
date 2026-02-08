<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\IndexSurat;
use Illuminate\Http\Request;

class IndexSuratController extends Controller
{
    public function index()
    {
        $indexes = IndexSurat::orderBy('kode', 'asc')->get();
        return view('admin_pc.index_surat.index', compact('indexes'));
    }

    public function create()
    {
        return view('admin_pc.index_surat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:index_surats,kode',
            'deskripsi' => 'required|string|max:255',
        ]);

        IndexSurat::create($request->all());

        return redirect()->route('admin_pc.index-surat.index')
                         ->with('success', 'Index Surat berhasil ditambahkan.');
    }

    public function edit(IndexSurat $indexSurat)
    {
        return view('admin_pc.index_surat.edit', compact('indexSurat'));
    }

    public function update(Request $request, IndexSurat $indexSurat)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:index_surats,kode,' . $indexSurat->id,
            'deskripsi' => 'required|string|max:255',
        ]);

        $indexSurat->update($request->all());

        return redirect()->route('admin_pc.index-surat.index')
                         ->with('success', 'Index Surat berhasil diperbarui.');
    }

    public function destroy(IndexSurat $indexSurat)
    {
        // Proteksi jika index sudah dipakai di tabel surat
        if ($indexSurat->surats()->count() > 0) {
            return back()->with('error', 'Index ini tidak bisa dihapus karena sudah digunakan dalam arsip surat.');
        }

        $indexSurat->delete();
        return redirect()->route('admin_pc.index-surat.index')
                         ->with('success', 'Index Surat berhasil dihapus.');
    }
}