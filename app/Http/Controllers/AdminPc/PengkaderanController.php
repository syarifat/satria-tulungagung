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
        $query = RiwayatPengkaderan::with(['anggota.organisasiUnit', 'anggota.jabatan']);

        // Since this is Admin PC, they can see ALL pengkaderan within the system (PC Tulungagung scope)
        // We might want to filter only valid members, but generally, all recorded pengkaderan should be visible.

        // Since this is Admin PC, they can see ALL pengkaderan within the system (PC Tulungagung scope)
        // We remove strict filtering to ensure all data is visible regardless of potentially missing hierarchy links.
        // If specific scope is needed later, we can re-add it, but for now, global visibility is requested.
        // $query->whereHas('anggota.organisasiUnit', function ($q) use ($pcUnit) { ... });

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

        // Filter by PAC (Allow "PC" selection which is a specific Unit ID)
        if ($request->filled('pac_id')) {
            $pacId = $request->pac_id;
            // Filter anggota that belongs to this Unit ID, OR belongs to a unit whose parent is this Unit ID
            // This covers: 
            // 1. Members of the specific unit (e.g. PC members if PC ID is selected)
            // 2. Members of direct child units (e.g. PAC members if PC ID selected, or PR members if PAC ID selected)
            // To cover grandchildren (PR members if PC ID selected), we need more depth.
            // Let's simplify: If "PC" is selected (id == pcUnit->id), we want PC members + PAC members + PR members? 
            // The dropdown says "Pengurus Cabang (PC)". Usually implies ONLY PC members.
            // If user selects "Semua PAC", request('pac_id') is empty.

            // Refined Logic:
            // If ID matches PC Unit -> Show only members of PC Unit.
            // If ID matches a PAC Unit -> Show members of that PAC + members of PRs under that PAC.

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

        $pengkaderans = $query->latest('id')->paginate(15);

        // Get unique jenis pengkaderan for filter (Global scope)
        $jenisOptions = RiwayatPengkaderan::distinct()
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
