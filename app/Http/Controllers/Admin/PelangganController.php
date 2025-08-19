<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar semua user dengan role 'pelanggan'.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'pelanggan')->latest();

        // Fitur pencarian sederhana
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%');
        }

        $pelanggans = $query->paginate(10);
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    /**
     * Menampilkan detail seorang pelanggan beserta riwayat transaksinya.
     */
    public function show(User $user)
    {
        // Pastikan user yang diakses adalah pelanggan
        if ($user->role !== 'pelanggan') {
            abort(404);
        }

        // Eager load riwayat transaksi
        $user->load(['transaksis' => function ($query) {
            $query->latest();
        }]);

        return view('admin.pelanggan.show', compact('user'));
    }
}
