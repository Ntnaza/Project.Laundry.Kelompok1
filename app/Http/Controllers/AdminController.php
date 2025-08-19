<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    return view('dashboard');
}
    
    public function charts()
    {
        return view('admin.charts'); 
    }

    public function tables()
    {
        return view('admin.tables');
    }

    public function guru()
    {
        return view('admin.guru');
    }

    public function siswa()
    {
        return view('admin.siswa');
    }

    public function kelas()
    {
        return view('admin.kelas');
    }

    public function mapel()
    {
        return view('admin.mapel');
    }

    public function jurusan()
    {
        return view('admin.jurusan');
    }
}