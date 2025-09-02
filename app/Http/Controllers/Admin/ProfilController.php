<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil admin.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.profil.index', compact('user'));
    }

    /**
     * Memperbarui data profil admin.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_hp'       => 'required|string|max:15',
            'alamat'      => 'required|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
        ]);

        $dataToUpdate = $request->only(['name', 'email', 'no_hp', 'alamat']);

        // Logika untuk upload foto profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Simpan foto baru
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $dataToUpdate['foto_profil'] = $path;
        }

        $user->update($dataToUpdate);

        return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
}

