<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\OrganisasiUnit;
use App\Models\Kecamatan;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    protected GoogleAuthService $googleAuthService;

    public function __construct(GoogleAuthService $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Redirect ke Google OAuth untuk register
     */
    public function redirectRegister(Request $request)
    {
        // Store registration type: 'anggota' or 'admin'
        $registerType = $request->query('type', 'anggota');
        session([
            'google_auth_type' => 'register',
            'register_type' => $registerType, // 'anggota' or 'admin'
        ]);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect ke Google OAuth untuk login
     */
    public function redirect()
    {
        session(['google_auth_type' => 'login']);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google (unified for both register and login)
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $authType = session('google_auth_type', 'login');
            session()->forget('google_auth_type');

            // Cek apakah user sudah terdaftar
            $existingUser = \App\Models\User::where('email', $googleUser->getEmail())->first();

            if ($authType === 'register') {
                // REGISTER FLOW
                if ($existingUser) {
                    // User sudah ada, arahkan ke login
                    return redirect()->route('login')
                        ->withErrors(['google' => 'Email sudah terdaftar. Silakan gunakan halaman login.']);
                }

                // Preserve register_type for complete-profile
                $registerType = session('register_type', 'anggota');

                // Buat user baru
                $user = $this->googleAuthService->findOrCreateUser($googleUser);
                Auth::login($user, true);

                // Store register_type untuk complete-profile
                session(['register_type' => $registerType]);

                // User baru selalu diarahkan ke complete-profile
                return redirect()->route('complete-profile');
            } else {
                // LOGIN FLOW
                if (!$existingUser) {
                    // User belum terdaftar, arahkan ke register
                    return redirect()->route('register')
                        ->withErrors(['google' => 'Akun belum terdaftar. Silakan daftar terlebih dahulu.']);
                }

                // Cek apakah user sudah punya data anggota
                $anggota = Anggota::where('user_id', $existingUser->id)->first();

                if (!$anggota) {
                    // User ada tapi belum lengkap profil
                    Auth::login($existingUser, true);
                    return redirect()->route('complete-profile');
                }

                Auth::login($existingUser, true);

                $existingUser->refresh();

                // Redirect sesuai role menggunakan service
                $redirectUrl = $this->googleAuthService->getRedirectRoute($existingUser);
                return redirect($redirectUrl);
            }
        } catch (\Exception $e) {
            $route = session('google_auth_type') === 'register' ? 'register' : 'login';
            return redirect()->route($route)
                ->withErrors(['google' => 'Gagal autentikasi dengan Google. Silakan coba lagi.']);
        }
    }


    /**
     * Tampilkan form lengkapi profil
     */
    /**
     * Tampilkan form lengkapi profil
     */
    public function showCompleteProfile()
    {
        $user = Auth::user();

        // Jika sudah lengkap, redirect ke dashboard
        if ($this->googleAuthService->isProfileComplete($user)) {
            return redirect($this->googleAuthService->getRedirectRoute($user));
        }

        $kecamatans = Kecamatan::orderBy('nama')->get();
        // Default register as anggota

        return view('auth.complete-profile', compact('user', 'kecamatans'));
    }

    /**
     * Simpan data profil lengkap
     */
    public function storeCompleteProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Hardcode role ke anggota
        $userRole = 'anggota';

        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:anggotas,nik',
            'nia_ansor' => 'nullable|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'kelamin' => 'required|in:L,P',
            'status_kawin' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            'notelp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'desa_id' => 'required|exists:desas,id',

            // Kaderisasi (Unit Organisasi tempat dia bernaung)
            'tingkatan_organisasi' => 'required|in:pac,pr',
            'unit_kecamatan_id' => 'required|exists:kecamatans,id',
            'unit_desa_id' => 'nullable|exists:desas,id|required_if:tingkatan_organisasi,pr',

            'last_education' => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:100',
            'job_address' => 'nullable|string|max:255',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
            'notelp.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'kecamatan_id.required' => 'Kecamatan domisili wajib dipilih',
            'desa_id.required' => 'Desa domisili wajib dipilih',
            'tingkatan_organisasi.required' => 'Tingkatan organisasi wajib dipilih',
            'unit_kecamatan_id.required' => 'PAC (Kecamatan) wajib dipilih',
            'unit_desa_id.required_if' => 'PR (Desa) wajib dipilih untuk tingkat Ranting',
        ]);

        // Cari organisasi unit berdasarkan pilihan (Tempat Kaderisasi)
        if ($validated['tingkatan_organisasi'] === 'pac') {
            $organisasiUnit = OrganisasiUnit::where('level', 'pac')
                ->where('kecamatan_id', $validated['unit_kecamatan_id'])
                ->first();
        } else {
            $organisasiUnit = OrganisasiUnit::where('level', 'pr')
                ->where('desa_id', $validated['unit_desa_id'])
                ->first();
        }

        if (!$organisasiUnit) {
            return back()->withErrors(['tingkatan_organisasi' => 'Unit organisasi tidak ditemukan.'])
                ->withInput();
        }

        // Update user dengan organisasi unit dan role
        $user->update([
            'organisasi_unit_id' => $organisasiUnit->id,
            'role' => $userRole,
        ]);

        // Buat data anggota
        Anggota::create([
            'user_id' => $user->id,
            'organisasi_unit_id' => $organisasiUnit->id,
            'jabatan_id' => 10, // Default: Anggota (sesuaikan ID-nya jika perlu, misal ambil dari DB)
            'nik' => $validated['nik'],
            'nia_ansor' => $validated['nia_ansor'],
            'nama' => $user->nama,
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'kelamin' => $validated['kelamin'],
            'status_kawin' => $validated['status_kawin'],
            'notelp' => $validated['notelp'],
            'alamat' => $validated['alamat'],
            'kecamatan_id' => $validated['kecamatan_id'],
            'desa_id' => $validated['desa_id'],
            'last_education' => $validated['last_education'],
            'job_title' => $validated['job_title'],
            'job_address' => $validated['job_address'],
        ]);

        // Clear session (just in case)
        session()->forget('register_type');

        // Refresh user untuk mendapatkan role terbaru
        $user->refresh();

        $redirectUrl = $this->googleAuthService->getRedirectRoute($user);

        return redirect($redirectUrl)
            ->with('success', 'Profil berhasil dilengkapi! Selamat bergabung.');
    }
}
