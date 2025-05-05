<?php

namespace Modules\Surat\Http\Controllers;

use App\Models\Core\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Surat\Entities\BuktiTugas;
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
        $jabatan = DB::table('users')
            ->join('pegawai', 'users.id', '=', 'pegawai.user_id')
            ->join('pejabats', 'pegawai.id', '=', 'pejabats.pegawai_id')
            ->where('users.id', auth()->id())
            ->select('pejabats.jabatan')
            ->first();
        $surat = DB::table('surat_disposisis')
            ->join('surat_masuks', 'surat_disposisis.surat_masuk_id', '=', 'surat_masuks.id')
            ->whereRaw('FIND_IN_SET(?, surat_disposisis.tujuan_disposisi)', [$jabatan->jabatan])
            ->whereIn('surat_masuks.status', ['3', '4', '6', '7'])
            ->select('surat_disposisis.*', 'surat_masuks.*')
            ->orderBy('surat_masuks.created_at', 'DESC')
            ->get();
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
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $user = DB::table('pejabats')
        ->select('pejabats.jabatan')
        ->where(function($query) {
            $query->where('pejabats.jabatan', 'not like', 'Direktur%')
            ->where('pejabats.jabatan', 'not like', 'Wakil Direktur%');
        })->get();
        $user_direktur = User::where('name', 'Direktur')->first();
        $disposisi = SuratDisposisi::where('surat_masuk_id', $id)->where('user_id', $user_direktur->id)->orderBy('created_at','DESC')->first();
        return view('surat::wadir.show', compact('surat', 'user', 'disposisi'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function detail($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $user = User::all();
        $surat_dispo = SuratDisposisi::with('surat_masuk')->where('surat_masuk_id', $id)->where('user_id', auth()->user()->id)->first();
        $bukti = BuktiTugas::with('surat_masuk')->where('surat_id', $id)->first();
        return view('surat::wadir.detail', compact('surat', 'user', 'surat_dispo', 'bukti'));
    }
    public function edit($id)
    {
        $surat = SuratDisposisi::where('surat_masuk_id', $id)->where('user_id', auth()->user()->id)->first();
        $user = DB::table('pejabats')
        ->select('pejabats.jabatan')
        ->where(function($query) {
            $query->where('pejabats.jabatan', 'not like', 'Direktur%')
            ->where('pejabats.jabatan', 'not like', 'Wakil Direktur%');
        })->get();
        return view('surat::wadir.edit', compact('surat', 'user'));
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
        if ($request->disposisi == ['Sekretaris']) {
            $data = [
                'disposisi' => implode(',', $request->disposisi),
                'status' => 6,
            ];
        }elseif ($request->disposisi == ['Direktur']) {
            $data = [
                'disposisi' => implode(',', $request->disposisi),
                'status' => 2,
            ];
        } else {
            $data = [
                'disposisi' => implode(',', $request->disposisi),
                'status' => 4,
            ];
        }
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
        return redirect('/surat/wadir')->with('sukses', 'Berhasil Tambah Disposisi Surat');
    }
    public function updateDisposisi(Request $request, $id)
    {
        $disposisi_edit = SuratDisposisi::findOrFail($id);

        $disposisi = [
            'user_id' => auth()->user()->id,
            'tujuan_disposisi' => implode(',', $request->tujuan_disposisi),
            'induk' => $request->induk,
            'waktu' => $request->waktu,
            'disposisi_singkat' => $request->disposisi_singkat,
            'disposisi_narasi' => $request->disposisi_narasi,
        ];
        $disposisi_edit->update($disposisi);
        $surat = SuratMasuk::where('id', $disposisi_edit->surat_masuk_id)->firstOrFail();
        if ($request->tujuan_disposisi == ['Sekretaris']) {
            $data = [
                'disposisi' => implode(',', $request->tujuan_disposisi),
                'status' => 6
            ];
        } else {
            $data = [
                'disposisi' => implode(',', $request->tujuan_disposisi),
                'status' => 4
            ];
        }
        $surat->update($data);
        return redirect('/surat/wadir')->with('sukses', 'berhasil edit data !!!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function acc(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $data = [
            'status' => 7,
        ];

        $surat->update($data);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $file_name = Str::random(20) . '.' . $extension;
            $file->storeAs('/assets/img/bukti', $file_name, 'public');

            $bukti = [
                'surat_id' => $surat->id,
                'user_id' => auth()->user()->id,
                'foto' => $file_name
            ];
            BuktiTugas::create($bukti);
        }
        return back();
    }
}
