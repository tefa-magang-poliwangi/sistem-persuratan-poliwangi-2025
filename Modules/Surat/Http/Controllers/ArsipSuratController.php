<?php

namespace Modules\Surat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Surat\Entities\SuratMasuk;

class ArsipSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $surat = SuratMasuk::where('status',5)->get();
        return view('surat::arsip.index',compact('surat'));
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
