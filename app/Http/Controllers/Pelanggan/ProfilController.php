<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <-- BARU: Untuk mengelola file
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        return view('pelanggan.profil.index', compact('user'));
    }

    /**
     * Memperbarui data profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_hp'       => 'required|string|max:15',
            'alamat'      => 'required|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // <-- BARU: Aturan validasi untuk foto
        ]);

        // Ambil data teks dari request
        $userData = $request->only('name', 'email', 'no_hp', 'alamat');

        // =============================================================
        // BARU: Logika untuk menangani upload foto profil
        // =============================================================
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Simpan foto baru dan dapatkan path-nya
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $userData['foto_profil'] = $path;
        }

        // Update data pengguna dengan data teks dan foto baru (jika ada)
        $user->update($userData);

        return redirect()->route('pelanggan.profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
}

