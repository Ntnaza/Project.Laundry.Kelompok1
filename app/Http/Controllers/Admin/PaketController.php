<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Menampilkan daftar semua paket laundry.
     */
    public function index()
    {
        $pakets = Paket::latest()->paginate(10); // Ambil data terbaru dengan paginasi
        return view('admin.paket.index', compact('pakets'));
    }

    /**
     * Menampilkan form untuk membuat paket baru.
     */
    public function create()
    {
        return view('admin.paket.create');
    }

    /**
     * Menyimpan paket baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis' => 'required|in:Kiloan,Satuan',
            'harga' => 'required|numeric|min:0',
            'estimasi_hari' => 'required|integer|min:1',
        ]);

        // Buat data baru
        Paket::create($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('admin.paket.index')
                         ->with('success', 'Paket laundry berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dari sebuah paket (opsional, jarang dipakai di admin).
     */
    public function show(Paket $paket)
    {
        return view('admin.paket.show', compact('paket'));
    }

    /**
     * Menampilkan form untuk mengedit paket.
     */
    public function edit(Paket $paket)
    {
        return view('admin.paket.edit', compact('paket'));
    }

    /**
     * Mengupdate data paket di database.
     */
    public function update(Request $request, Paket $paket)
    {
        // Validasi input
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis' => 'required|in:Kiloan,Satuan',
            'harga' => 'required|numeric|min:0',
            'estimasi_hari' => 'required|integer|min:1',
        ]);

        // Update data
        $paket->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('admin.paket.index')
                         ->with('success', 'Paket laundry berhasil diperbarui.');
    }

    /**
     * Menghapus paket dari database.
     */
    public function destroy(Paket $paket)
    {
        // Hapus data
        $paket->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.paket.index')
                         ->with('success', 'Paket laundry berhasil dihapus.');
    }
}
