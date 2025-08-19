<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
{
    return view('dashboard');
}
    
    public function charts()
    {
        return view('pages.charts'); 
    }

    public function tables()
    {
        return view('pages.tables');
    }

    public function guru()
    {
        return view('pages.guru');
    }

    public function siswa()
    {
        return view('pages.siswa');
    }

    public function kelas()
    {
        return view('pages.kelas');
    }

    public function mapel()
    {
        return view('pages.mapel');
    }

    public function jurusan()
    {
        return view('pages.jurusan');
    }
}