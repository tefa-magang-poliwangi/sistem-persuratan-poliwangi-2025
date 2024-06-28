<?php

namespace Modules\Surat\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Surat\Entities\SuratDisposisi;
use Modules\Surat\Entities\SuratMasuk;
use Illuminate\Contracts\Support\Renderable;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // dd(auth()->user()->roles);
        if (auth()->user()->getRolenames()[0] == "Pegawai") {
            $surat = DB::table('surat_disposisis')
                ->join('surat_masuks', 'surat_disposisis.surat_masuk_id', '=', 'surat_masuks.id')
                ->whereRaw('FIND_IN_SET(?,surat_disposisis.tujuan_disposisi)', auth()->user()->name)
                ->where('surat_masuks.status', '4')
                ->select('surat_disposisis.*', 'surat_masuks.*')
                ->get();
            return view('surat::surat-pegawai.index', compact('surat'));
        } elseif (auth()->user()->getRoleNames()[0] == "admin") {
            $surat = SuratMasuk::whereIn('status', ['1', '2', '3', '4'])->orderBy('created_at','DESC')->get();
            return view('surat::surat.index', compact('surat'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('surat::surat.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = [
            'nomor' => $request->nomor,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_diterima' => $request->tanggal_diterima,
            'pengirim' => $request->pengirim,
            'diterima_dari' => $request->diterima_dari,
            'perihal' => $request->perihal,
            'sifat' => $request->sifat,
            'status' => $request->status,
            'user_id' => auth()->user()->id,
            'catatan_sekretariat' => $request->catatan_sekretariat,
        ];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = Str::random(20) . '.' . $extension;
            $file->storeAs('/assets/img/surat', $file_name, 'public');
            $data['file'] = $file_name;
        }
        SuratMasuk::create($data);
        return redirect('/surat/surat-masuk')->with('success_message', 'Surat added!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        if (auth()->user()->getRolenames()[0] == "admin") {
            $surat = SuratMasuk::findOrFail($id);
            return view('surat::surat.show', compact('surat'));
        } elseif (auth()->user()->getRolenames()[0] == "Pegawai") {
            $surat = SuratMasuk::findOrFail($id);
            return view('surat::surat-pegawai.show', compact('surat'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $suratmasuk = SuratMasuk::findOrFail($id);
        return view('surat::surat.edit', compact('suratmasuk'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $Surat_masuk = SuratMasuk::findOrFail($id);
        $data = [
            'nomor' => $request->nomor,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_diterima' => $request->tanggal_diterima,
            'pengirim' => $request->pengirim,
            'diterima_dari' => $request->diterima_dari,
            'perihal' => $request->perihal,
            'sifat' => $request->sifat,
            'user_id' => auth()->user()->id,
            'catatan_sekretariat' => $request->catatan_sekretariat,
        ];
        if (!empty($request->hasFile('file'))) {
            $destination = '/storage/app/public/assets/img/surat/' . $Surat_masuk->file;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = Str::random(20) . '.' . $extension;
            $file->storeAs('/assets/img/surat', $file_name, 'public');
            $data['file'] = $file_name;
        }

        $Surat_masuk->update($data);
        return back();
    }
    public function arsip($id)
    {
        $arsip = SuratMasuk::findOrFail($id);
        $arsip->update(['status' => 5]);

        return back()->with('sukses', 'Berhasil Arsipkan Surat');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function disposisi($id){
        $surat = SuratMasuk::findOrFail($id);
        return view('surat::surat-pegawai.lembar-disposisi',compact('surat'));
    }
    public function destroy($id)
    {
        $hapus = SuratMasuk::findOrFail($id);
        $hapus->delete();
        $disposisi = SuratDisposisi::where('surat_masuk_id', $id);
        $disposisi->delete();
        return back()->with('sukses', 'Berhasil Hapus Surat');
    }
}
