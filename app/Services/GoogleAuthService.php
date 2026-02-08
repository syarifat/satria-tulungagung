<?php

namespace App\Services;

use App\Models\User;
use App\Models\Anggota;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Illuminate\Support\Facades\Auth;

class GoogleAuthService
{
    /**
     * Find user by Google ID or email, or create new user
     */
    public function findOrCreateUser(SocialiteUser $googleUser): User
    {
        // Cari user berdasarkan google_id terlebih dahulu
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Update avatar jika ada perubahan
            $user->update(['avatar' => $googleUser->getAvatar()]);
            return $user;
        }

        // Cari user berdasarkan email (untuk user existing yang belum punya google_id)
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Link akun Google ke user existing
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
            return $user;
        }

        // User baru - buat akun baru
        return User::create([
            'nama' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
            'password' => null, // Tidak ada password untuk Google auth
            'role' => 'anggota', // Default role
            'is_active' => true,
        ]);
    }

    /**
     * Check if user has completed their profile (Anggota data)
     */
    public function isProfileComplete(User $user): bool
    {
        $anggota = Anggota::where('user_id', $user->id)->first();

        if (!$anggota) {
            return false;
        }

        // Cek field wajib yang harus diisi
        return !empty($anggota->nik)
            && !empty($anggota->tempat_lahir)
            && !empty($anggota->tanggal_lahir)
            && !empty($anggota->organisasi_unit_id);
    }

    /**
     * Get redirect route based on user role and profile status
     */
    public function getRedirectRoute(User $user): string
    {
        // Jika profil belum lengkap, redirect ke complete-profile
        if (!$this->isProfileComplete($user)) {
            return route('complete-profile');
        }

        // Redirect berdasarkan role
        return match ($user->role) {
            'super_admin', 'admin_pc' => route('admin_pc.dashboard'),
            'admin_pac' => route('admin_pac.dashboard'),
            'admin_pr' => route('admin_pr.dashboard'),
            default => route('anggota.dashboard'),
        };
    }
}
