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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WadirController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // mengambil user yang sedang login saat ini
        $user = Auth()->user();

        // dd($user->getRoleNames());

        // hanya mengizinkan user dengan role pejabat: wadir1, wadir2, wadir3
        if (
            $user->getRoleNames()->contains('wadir1') ||
            $user->getRoleNames()->contains('wadir2') ||
            $user->getRoleNames()->contains('wadir3')
        ) {
            // get data jabatan berdasarkan user pegawai
            $jabatan = DB::table('users')
                ->join('pegawais', 'users.username', '=', 'pegawais.username') // diubah
                ->join('pejabats', 'pegawais.id', '=', 'pejabats.pegawai_id')
                ->where('users.id', auth()->id())
                ->select('pejabats.jabatan')
                ->first();

            // dd($jabatan);

            // $surat = DB::table('surat_disposisis')
            //     ->join('surat_masuks', 'surat_disposisis.surat_masuk_id', '=', 'surat_masuks.id')
            //     ->whereRaw('FIND_IN_SET(?, surat_disposisis.tujuan_disposisi)', [$jabatan->jabatan])
            //     ->whereIn('surat_masuks.status', ['3', '4', '6', '7'])
            //     ->select('surat_disposisis.*', 'surat_masuks.*')
            //     ->orderBy('surat_masuks.created_at', 'DESC')
            //     ->get();

            $latestDisposisis = DB::table('surat_disposisis as sd1')
                ->join('surat_masuks as sm', 'sd1.surat_masuk_id', '=', 'sm.id')
                ->whereRaw('FIND_IN_SET(?, sd1.tujuan_disposisi)', [$jabatan->jabatan])
                ->whereIn('sm.status', ['3', '4', '6', '7'])
                ->whereRaw('sd1.created_at = (SELECT MAX(sd2.created_at) FROM surat_disposisis sd2 WHERE sd2.surat_masuk_id = sd1.surat_masuk_id)')
                ->select('sd1.*', 'sm.*')
                ->orderBy('sm.created_at', 'DESC')
                ->get();

            // dd($latestDisposisis);

            $data = [
                'surat' => $latestDisposisis
            ];

            return view('surat::wadir.index', $data);
        } else {
            return redirect('/dashboard')->with('sukses', 'Pengguna tidak di-izinkan');
        }
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

        // menolak jika surat adalah arsip (dengan status 5)
        if ($surat->status === 5) {
            return redirect('/surat/wadir')->with('warning', 'Surat Arsip tidak diperbolehkan');
        } else {
            $user = DB::table('pejabats')
                ->select('pejabats.jabatan')
                ->where(function ($query) {
                    $query->where('pejabats.jabatan', 'not like', 'Direktur%')
                        ->where('pejabats.jabatan', 'not like', 'Wakil Direktur%');
                })->get();

            $user_direktur = User::where('name', 'Direktur')->first();

            $disposisi = SuratDisposisi::where('surat_masuk_id', $id)->where('user_id', $user_direktur->id)->orderBy('created_at', 'DESC')->first();

            return view('surat::wadir.show', compact('surat', 'user', 'disposisi'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function detail($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        // menolak jika surat adalah arsip (dengan status 5)
        if ($surat->status === 5) {
            return redirect('/surat/wadir')->with('warning', 'Surat Arsip tidak diperbolehkan');
        } else {
            $user = User::all();
            $surat_dispo = SuratDisposisi::with('surat_masuk')->where('surat_masuk_id', $id)->where('user_id', auth()->user()->id)->first();
            $bukti = BuktiTugas::with('surat_masuk')->where('surat_id', $id)->first();
            return view('surat::wadir.detail', compact('surat', 'user', 'surat_dispo', 'bukti'));
        }
    }

    public function edit($id)
    {
        $surat = SuratDisposisi::where('surat_masuk_id', $id)->where('user_id', auth()->user()->id)->first();

        if ($surat) {
            $user = DB::table('pejabats')
                ->select('pejabats.jabatan')
                ->where(function ($query) {
                    $query->where('pejabats.jabatan', 'not like', 'Direktur%')
                        ->where('pejabats.jabatan', 'not like', 'Wakil Direktur%');
                })->get();

            return view('surat::wadir.edit', compact('surat', 'user'));
        } else {
            return redirect('/surat/wadir')->with('sukses', 'Surat Disposisi Tidak ditemukan');
        }
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

        // Filter tujuan disposisi agar tidak ada null atau kosong
        $tujuan_disposisi = array_filter($request->tujuan_disposisi, function($value) {
            return !is_null($value) && $value !== '';
        });
        $tujuan_disposisi = array_values($tujuan_disposisi); // reset index

        $jumlah_tujuan = count($tujuan_disposisi);

        // Contoh logika status sederhana (bisa disesuaikan)
        if ($jumlah_tujuan === 1 && $tujuan_disposisi[0] === 'Sekdir') {
            $data = ['disposisi' => $jumlah_tujuan, 'status' => 6];
        } elseif ($jumlah_tujuan === 1 && $tujuan_disposisi[0] === 'Direktur') {
            $data = ['disposisi' => $jumlah_tujuan, 'status' => 2];
        } else {
            $data = ['disposisi' => $jumlah_tujuan, 'status' => 4];
        }

        $surat_masuk->update($data);


        // Proses buat disposisi
        foreach ($tujuan_disposisi as $tujuan) {
            SuratDisposisi::create([
                'surat_masuk_id' => $id,
                'user_id' => auth()->user()->id,
                'tujuan_disposisi' => $tujuan,
                'induk' => $request->induk,
                'waktu' => $request->waktu,
                'disposisi_singkat' => $request->disposisi_singkat,
                'disposisi_narasi' => $request->disposisi_narasi,
            ]);
        }

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
        if ($request->tujuan_disposisi == ['Sekdir']) {
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
        $suratDisposisis = SuratDisposisi::where('surat_masuk_id', $id)->get();

        // Validasi file
        $rules = ['foto' => config('custom.validasi_file_rules')]; // langsung dari .env
        $messages = config('custom.validasi_file_messages'); // dari config/custom.php

        $request->validate($rules, $messages);

        $data = [
            'status' => 7,
        ];

        $surat->update($data);

        // update status milik data surat disposisi (agar menjadi 1) yang berkaitan dengan surat masuk
        foreach ($suratDisposisis as $disposisi) {
            $disposisi->update(['status' => 1]);
        }

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
