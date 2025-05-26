<?php

namespace Modules\Surat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Modules\Surat\Entities\SuratMasuk;

class ArsipSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::where('status', 5);

        // Jika tidak ada filter, default ke bulan ini
        if (!$request->has('start_date') && !$request->has('end_date')) {
            $now = Carbon::now();
            $query->whereMonth('tanggal_surat', $now->month)
                ->whereYear('tanggal_surat', $now->year);
        }

        // Kalau ada filter dari user, pakai itu
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_surat', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_surat', '<=', $request->end_date);
        }

        $surat = $query->orderBy('tanggal_surat', 'desc')->get();

        return view('surat::arsip.index', compact('surat'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
            $surat = SuratMasuk::findOrFail($id);
            return view('surat::arsip.show', compact('surat'));
        
    }
}
