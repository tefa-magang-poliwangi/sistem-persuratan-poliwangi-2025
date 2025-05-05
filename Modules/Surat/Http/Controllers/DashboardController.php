<?php

namespace Modules\Surat\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Surat\Entities\SuratMasuk;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $jumlahSuratMasuk = SuratMasuk::count();
        $selesai = SuratMasuk::where('status',7)->count();
        $arsip = SuratMasuk::where('status','5')->count();
        $disposisi = SuratMasuk::whereNotIn('status', [5, 7])->count();
        return view('surat::home', compact('jumlahSuratMasuk','selesai','arsip','disposisi'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
}
