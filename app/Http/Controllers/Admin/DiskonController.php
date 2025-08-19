<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $diskons = Diskon::latest()->paginate(10);
        return view('admin.diskon.index', compact('diskons'));
    }

    public function create()
    {
        return view('admin.diskon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_diskon' => 'required|string|unique:diskons,kode_diskon',
            'keterangan' => 'required|string',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|numeric|min:0',
            'minimum_belanja' => 'required|numeric|min:0',
            'berlaku_dari' => 'required|date',
            'berlaku_sampai' => 'required|date|after_or_equal:berlaku_dari',
        ]);

        Diskon::create($request->all());

        return redirect()->route('admin.diskon.index')
                         ->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function edit(Diskon $diskon)
    {
        return view('admin.diskon.edit', compact('diskon'));
    }

    public function update(Request $request, Diskon $diskon)
    {
        $request->validate([
            'kode_diskon' => 'required|string|unique:diskons,kode_diskon,' . $diskon->id,
            'keterangan' => 'required|string',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|numeric|min:0',
            'minimum_belanja' => 'required|numeric|min:0',
            'berlaku_dari' => 'required|date',
            'berlaku_sampai' => 'required|date|after_or_equal:berlaku_dari',
        ]);

        $diskon->update($request->all());

        return redirect()->route('admin.diskon.index')
                         ->with('success', 'Diskon berhasil diperbarui.');
    }

    public function destroy(Diskon $diskon)
    {
        $diskon->delete();

        return redirect()->route('admin.diskon.index')
                         ->with('success', 'Diskon berhasil dihapus.');
    }
}
