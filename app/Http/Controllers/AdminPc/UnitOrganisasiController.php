<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\OrganisasiUnit;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Http\Request;

class UnitOrganisasiController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganisasiUnit::with(['kecamatan', 'desa', 'parent'])
            ->whereIn('level', ['pac', 'pr']);

        // Filter by PAC (Parent-Children relationship)
        if ($request->has('pac_id') && $request->pac_id != '') {
            $query->where('parent_id', $request->pac_id);
        }

        $units = $query->orderBy('level', 'asc')
            ->orderBy('nama', 'asc')
            ->paginate(15);

        $totalPac = OrganisasiUnit::where('level', 'pac')->count();
        $totalPr = OrganisasiUnit::where('level', 'pr')->count();

        // List of PACs for dropdown filter
        $allPacs = OrganisasiUnit::where('level', 'pac')->orderBy('nama', 'asc')->get();

        return view('admin_pc.unit_organisasi.index', compact('units', 'totalPac', 'totalPr', 'allPacs'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::orderBy('nama', 'asc')->get();
        $pacs = OrganisasiUnit::where('level', 'pac')->orderBy('nama', 'asc')->get();

        return view('admin_pc.unit_organisasi.create', compact('kecamatans', 'pacs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'level' => 'required|in:pac,pr',
            'kecamatan_id' => 'required_if:level,pac,pr',
            'desa_id' => 'required_if:level,pr',
            'parent_id' => 'required_if:level,pr',
        ]);

        OrganisasiUnit::create($request->all());

        return redirect()->route('admin_pc.unit-organisasi.index')
            ->with('success', 'Unit Organisasi berhasil ditambahkan.');
    }
}
