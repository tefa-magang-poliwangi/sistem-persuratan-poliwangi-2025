<?php

namespace Modules\Surat\Http\Controllers;

use App\Models\Core\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Surat\Entities\SuratMasuk;
use Modules\Surat\Entities\SuratDisposisi;
use Illuminate\Contracts\Support\Renderable;

class DisposisiSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $disposisi = SuratMasuk::where('status', '2')
            ->orWhere('status', '3')
            ->orWhere('status', '6')
            ->orderBy('created_at','DESC')
            ->get();
        return view('surat::disposisi-surat.index', compact('disposisi'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $disposisi_surat = SuratMasuk::all();
        return view('surat::disposisi-surat.create', compact('disposisi_surat'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $user = DB::table('pejabats')->select('pejabats.jabatan')->where('pejabats.jabatan', 'like', 'Wakil Direktur%')->get();
        return view('surat::disposisi-surat.show', compact('surat', 'user'));
    }
    public function detail($id)
    {

        $surat_dispo = SuratDisposisi::with('surat_masuk')->where('surat_masuk_id', $id)->firstOrFail();
        return view('surat::disposisi-surat.detail', compact('surat_dispo'));
    }
    public function editDisposisi($id)
    {

        $surat = SuratDisposisi::where('surat_masuk_id', $id)->firstOrFail();
        $user = DB::table('pejabats')->select('pejabats.jabatan')->where('pejabats.jabatan', 'like', 'Wakil Direktur%')->get();
        // $user = User::where('username', 'wadir1')->orWhere('username', 'wadir2')->orWhere('username','wadir3')->get();
        return view('surat::disposisi-surat.edit', compact('surat', 'user'));
    }

    public function updateDisposisi(Request $request, $id)
    {
        $disposisi_edit = SuratDisposisi::findOrFail($id);

        $disposisi = [
            'user_id' => auth()->user()->id,
            'tujuan_disposisi' => $request->tujuan_disposisi,
            'induk' => $request->induk,
            'waktu' => $request->waktu,
            'disposisi_singkat' => $request->disposisi_singkat,
            'disposisi_narasi' => $request->disposisi_narasi,
        ];
        $disposisi_edit->update($disposisi);
        $surat = SuratMasuk::where('id', $disposisi_edit->surat_masuk_id)->firstOrFail();
        if ($request->tujuan_disposisi == 'Sekretaris') {
            $data = [
                'disposisi' => $request->tujuan_disposisi,
                'status' => 6,
            ];
        } else {
            $data = [
                'disposisi' => $request->tujuan_disposisi,
                'status' => 3
            ];
        }
        $surat->update($data);
        return redirect('/surat/disposisi-surat')->with('sukses', 'berhasil edit data !!!');
    }

    public function update(Request $request, $id)
    {
        $surat_masuk = SuratMasuk::findOrFail($id);
        if ($request->disposisi == 'Sekretaris') {
            $data = [
                'disposisi' => $request->disposisi,
                'status' => 6,
            ];
        } else {
            $data = [
                'disposisi' => $request->disposisi,
                'status' => 3,
            ];
        }
        $surat_masuk->update($data);
        $disposisi = [
            'user_id' => auth()->user()->id,
            'surat_masuk_id' => $id,
            'tujuan_disposisi' => $request->disposisi,
            'induk' => $request->induk,
            'waktu' => $request->waktu,
            'disposisi_singkat' => $request->disposisi_singkat,
            'disposisi_narasi' => $request->disposisi_narasi,
        ];
        SuratDisposisi::create($disposisi);
        return redirect('/surat/disposisi-surat')->with('sukses', 'berhasil edit data');
    }
}
