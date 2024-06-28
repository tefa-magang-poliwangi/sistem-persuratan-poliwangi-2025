<?php

namespace Modules\Surat\Http\Controllers;

use App\Models\Core\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Surat\Entities\SuratMasuk;
use Modules\Surat\Entities\SuratDisposisi;
use Illuminate\Contracts\Support\Renderable;

class WadirController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $surat = DB::table('surat_disposisis')
            ->join('surat_masuks', 'surat_disposisis.surat_masuk_id', '=', 'surat_masuks.id')
            ->whereRaw('FIND_IN_SET(?, surat_disposisis.tujuan_disposisi)', auth()->user()->name)
            ->whereIn('surat_masuks.status', ['3','4'])
            ->select('surat_disposisis.*', 'surat_masuks.*') 
            ->get();

        // $surat = SuratDisposisi::with('surat_masuk')->where('tujuan_disposisi', auth()->user()->name)->where('status', 3)->get();
        // $arsip = SuratMasuk::where('status',3)->get();
        // dd($surat);
        return view('surat::wadir.index', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('surat::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $user = User::all();
        $user_direktur = User::where('name', 'Direktur')->first();
        $disposisi = SuratDisposisi::where('surat_masuk_id', $id)->where('user_id', $user_direktur->id)->first();
        return view('surat::wadir.show', compact('surat', 'user','disposisi'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function detail($id){
        $surat = SuratMasuk::findOrFail($id);
        $user = User::all();
        $surat_dispo = SuratDisposisi::with('surat_masuk')->where('surat_masuk_id',$id)->where('user_id', auth()->user()->id)->first();
        return view('surat::wadir.detail',compact('surat','user','surat_dispo'));
    }
    public function edit($id)
    {
        $surat = SuratDisposisi::where('surat_masuk_id',$id)->where('user_id',auth()->user()->id)->first();
        $user = User::all();
        // dd($surat);
        return view('surat::wadir.edit', compact('surat','user'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $surat_masuk = SuratMasuk::findOrFail($id);
        $data = [
            'disposisi' => implode(',', $request->disposisi),
            'status' => 4,
            ];
        $surat_masuk->update($data);
        $disposisi = [
            'surat_masuk_id' => $id,
            'user_id' => auth()->user()->id,
            'tujuan_disposisi' => implode(',', $request->disposisi),
            'induk' => $request->induk,
            'waktu' => $request->waktu,
            'disposisi_singkat' => $request->disposisi_singkat,
            'disposisi_narasi' => $request->disposisi_narasi,
            ];
        SuratDisposisi::create($disposisi);
        return redirect('/surat/wadir')->with('sukses','Berhasil Tambah Disposisi Surat');
    }
    public function updateDisposisi(Request $request, $id)
    {
        // dd($request->all());
        $disposisi_edit = SuratDisposisi::findOrFail($id);
        
        $disposisi = [
            'user_id' => auth()->user()->id,
            'tujuan_disposisi' =>implode(',', $request->tujuan_disposisi),
            'induk' => $request->induk,
            'waktu' => $request->waktu,
            'disposisi_singkat' => $request->disposisi_singkat,
            'disposisi_narasi' => $request->disposisi_narasi,
        ];
        $disposisi_edit->update($disposisi);
        $surat = SuratMasuk::where('id',$disposisi_edit->surat_masuk_id)->firstOrFail();
        $data = [
            'disposisi' => implode(',', $request->tujuan_disposisi),
        ];
        $surat->update($data);
        return redirect('/surat/wadir')->with('sukses','berhasil edit data !!!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
