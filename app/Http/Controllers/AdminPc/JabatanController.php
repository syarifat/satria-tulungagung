<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::orderBy('level_akses', 'asc')->get();
        return view('admin_pc.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('admin_pc.jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'level_akses' => 'required|in:pc,pac,pr,all',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('admin_pc.jabatan.index')
                         ->with('success', 'Jabatan baru berhasil ditambahkan.');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('admin_pc.jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'level_akses' => 'required|in:pc,pac,pr,all',
        ]);

        $jabatan->update($request->all());

        return redirect()->route('admin_pc.jabatan.index')
                         ->with('success', 'Data jabatan berhasil diperbarui.');
    }

    public function destroy(Jabatan $jabatan)
    {
        // Cek jika jabatan masih dipakai anggota
        if($jabatan->anggotas()->count() > 0) {
            return back()->with('error', 'Jabatan tidak bisa dihapus karena masih memiliki anggota.');
        }

        $jabatan->delete();
        return redirect()->route('admin_pc.jabatan.index')
                         ->with('success', 'Jabatan berhasil dihapus.');
    }
}