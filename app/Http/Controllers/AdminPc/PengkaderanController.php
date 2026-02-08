<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPengkaderan;
use App\Models\OrganisasiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengkaderanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $pcUnit = $user->organisasiUnit;

        // Get all PAC units under this PC
        $pacUnits = OrganisasiUnit::where('parent_id', $pcUnit->id)
            ->where('level', 'PAC')
            ->orderBy('nama')
            ->get();

        // Get all PR units under this PC
        $prUnits = OrganisasiUnit::where('level', 'PR')
            ->whereIn('parent_id', $pacUnits->pluck('id'))
            ->orderBy('nama')
            ->get();

        // Build query
        $query = RiwayatPengkaderan::with(['anggota.organisasiUnit', 'anggota.jabatan'])
            ->whereHas('anggota.organisasiUnit', function ($q) use ($pcUnit) {
                $q->where(function ($query) use ($pcUnit) {
                    // PC level
                    $query->where('id', $pcUnit->id)
                        // Or PAC level under this PC
                        ->orWhere('parent_id', $pcUnit->id)
                        // Or PR level under PACs of this PC
                        ->orWhereIn('parent_id', function ($subQuery) use ($pcUnit) {
                            $subQuery->select('id')
                                ->from('organisasi_units')
                                ->where('parent_id', $pcUnit->id)
                                ->where('level', 'PAC');
                        });
                });
            });

        // Filter by search (nama anggota or jenis pengkaderan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis_pengkaderan', 'like', "%{$search}%")
                    ->orWhereHas('anggota', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by PAC
        if ($request->filled('pac_id')) {
            $pacId = $request->pac_id;
            $query->whereHas('anggota.organisasiUnit', function ($q) use ($pacId) {
                $q->where('id', $pacId)
                    ->orWhere('parent_id', $pacId);
            });
        }

        // Filter by PR
        if ($request->filled('pr_id')) {
            $query->whereHas('anggota.organisasiUnit', function ($q) use ($request) {
                $q->where('id', $request->pr_id);
            });
        }

        // Filter by jenis pengkaderan
        if ($request->filled('jenis')) {
            $query->where('jenis_pengkaderan', 'like', "%{$request->jenis}%");
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_pelaksanaan', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_pelaksanaan', '<=', $request->tanggal_sampai);
        }

        $pengkaderans = $query->latest('tanggal_pelaksanaan')->paginate(15);

        // Get unique jenis pengkaderan for filter
        $jenisOptions = RiwayatPengkaderan::whereHas('anggota.organisasiUnit', function ($q) use ($pcUnit) {
            $q->where(function ($query) use ($pcUnit) {
                $query->where('id', $pcUnit->id)
                    ->orWhere('parent_id', $pcUnit->id)
                    ->orWhereIn('parent_id', function ($subQuery) use ($pcUnit) {
                        $subQuery->select('id')
                            ->from('organisasi_units')
                            ->where('parent_id', $pcUnit->id)
                            ->where('level', 'PAC');
                    });
            });
        })
            ->distinct()
            ->pluck('jenis_pengkaderan')
            ->filter()
            ->sort()
            ->values();

        return view('admin_pc.pengkaderan.index', compact(
            'pengkaderans',
            'pacUnits',
            'prUnits',
            'jenisOptions'
        ));
    }

    public function show(RiwayatPengkaderan $pengkaderan)
    {
        $user = Auth::user();
        $pcUnit = $user->organisasiUnit;

        // Verify access
        $anggotaUnit = $pengkaderan->anggota->organisasiUnit;
        $hasAccess = $anggotaUnit->id == $pcUnit->id
            || $anggotaUnit->parent_id == $pcUnit->id
            || optional($anggotaUnit->parent)->parent_id == $pcUnit->id;

        if (!$hasAccess) {
            abort(403);
        }

        return view('admin_pc.pengkaderan.show', compact('pengkaderan'));
    }
}
