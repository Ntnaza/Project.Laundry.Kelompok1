<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    /**
     * Menampilkan form untuk mengedit pengaturan.
     */
    public function edit()
    {
        // Ambil data pengaturan pertama (dan satu-satunya)
        $pengaturan = Pengaturan::first();
        return view('admin.pengaturan.edit', compact('pengaturan'));
    }

    /**
     * Memperbarui data pengaturan.
     */
    public function update(Request $request)
    {
        $pengaturan = Pengaturan::first();

        $request->validate([
            'nama_laundry' => 'required|string|max:255',
            'alamat'       => 'nullable|string',
            'no_hp'        => 'nullable|string|max:15',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo)) {
                Storage::disk('public')->delete($pengaturan->logo);
            }

            // Simpan logo baru
            $path = $request->file('logo')->store('logo_laundry', 'public');
            $data['logo'] = $path;
        }

        $pengaturan->update($data);

        return redirect()->route('admin.pengaturan.edit')->with('success', 'Profil laundry berhasil diperbarui!');
    }
}
