<?php

namespace Modules\Surat\Http\Controllers;

use App\Models\Core\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Surat\Entities\BuktiTugas;
use Modules\Surat\Entities\SuratMasuk;
use Modules\Surat\Entities\SuratDisposisi;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $userRole = auth()->user()->getRoleNames()[0];

        if ($userRole == "pegawai") {
            // Ambil jabatan user, beri fallback jika tidak ditemukan
            $jabatan = DB::table('users')
                ->join('pegawais', 'users.username', '=', 'pegawais.username')
                ->join('pejabats', 'pegawais.id', '=', 'pejabats.pegawai_id')
                ->where('users.id', auth()->id())
                ->select('pejabats.jabatan')
                ->first();

            if (!$jabatan) {
                return redirect()->back()->with('error', 'Jabatan tidak ditemukan!');
            }

            // Query surat disposisi untuk pegawai
            $surat_pegawai = DB::table('surat_disposisis')
                ->join('surat_masuks', 'surat_disposisis.surat_masuk_id', '=', 'surat_masuks.id')
                ->whereRaw('FIND_IN_SET(?, surat_disposisis.tujuan_disposisi)', [$jabatan->jabatan])
                ->whereIn('surat_masuks.status', ['4', '7'])
                ->select(
                    'surat_disposisis.id as disposisi_id',
                    'surat_disposisis.status as status_disposisi',
                    'surat_masuks.id as surat_masuk_id',
                    'surat_masuks.*'
                )
                ->orderBy('surat_masuks.created_at', 'DESC')
                ->get();

            return view('surat::surat-pegawai.index', compact('surat_pegawai', 'jabatan'));
        } elseif ($userRole == "admin" || $userRole == "sekdir") {
            $surat = SuratMasuk::whereIn('status', ['1', '2', '3', '4', '6', '7'])
                ->orderBy('created_at', 'DESC')
                ->get();

                 foreach ($surat as $s) {
                $totalDisposisi = DB::table('surat_disposisis')
                    ->where('surat_masuk_id', $s->id)
                    ->count();

                $selesaiDisposisi = DB::table('surat_disposisis')
                    ->where('surat_masuk_id', $s->id)
                    ->where('status', 1)
                    ->count();

                $s->persentase_disposisi = ($totalDisposisi > 0)
                    ? round(($selesaiDisposisi / $totalDisposisi) * 100)
                    : 0;
            }

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
        $request->validate([
            'pengirim' => 'regex:/^[a-zA-Z\s]+$/',
            'diterima_dari' => 'regex:/^[a-zA-Z\s]+$/',
            'perihal' => 'regex:/^[a-zA-Z\s]+$/',
            'file' => 'required|mimes:pdf|max:5048', // hanya izinkan PDF, maksimal 2MB
        ], [
            'pengirim' => 'Nama Pengirim tidak boleh menggunakan simbol atau angka',
            'perihal' => 'Perihal tidak boleh menggunakan simbol atau angka',
            'diterima_dari' => 'Nama Penerima tidak boleh menggunakan simbol atau angka',
        ]);
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
    public function detail($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $bukti = BuktiTugas::with('surat_masuk')->where('surat_id', $id)->first();
        return view('surat::surat-pegawai.detail', compact('surat', 'bukti'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */

    public function show($id)
    {
        if (auth()->user()->getRolenames()[0] == "admin" || auth()->user()->getRolenames()[0] == "sekdir") {
            $surat = SuratMasuk::findOrFail($id);
            $disposisi = SuratDisposisi::where('surat_masuk_id', $id)->get();
            return view('surat::surat.show', compact('surat', 'disposisi'));
        } elseif (auth()->user()->getRolenames()[0] == "pegawai") {
            $surat = SuratMasuk::findOrFail($id);
            $user = DB::table('pejabats')
                ->select('pejabats.jabatan')
                ->where(function ($query) {
                    $query->where('pejabats.jabatan', 'not like', 'Direktur%')
                        ->where('pejabats.jabatan', 'not like', 'Wakil Direktur%');
                })->get();
            $disposisi = SuratDisposisi::where('surat_masuk_id', $id)->orderBy('created_at', 'desc')->first();
            $user_disposisi = DB::table('users')
                ->join('pegawais', 'users.username', '=', 'pegawais.username')
                ->join('pejabats', 'pegawais.id', '=', 'pejabats.pegawai_id')
                ->where('users.id', $disposisi->user_id)
                ->select('pejabats.jabatan')
                ->first();
            return view('surat::surat-pegawai.show', compact('surat', 'user', 'disposisi', 'user_disposisi'));
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

        // jika surat arsip, maka tidak diperbolehkan untuk diedit
        if ($suratmasuk->status === 5) {
            return redirect('/surat/surat-masuk')->with('warning', 'Surat adalah arsip');
        }

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
        $request->validate([
            'pengirim' => 'regex:/^[a-zA-Z\s]+$/',
            'diterima_dari' => 'regex:/^[a-zA-Z\s]+$/',
            'perihal' => 'regex:/^[a-zA-Z\s]+$/',
            'file' => 'mimes:pdf|max:5048', // hanya izinkan PDF, maksimal 2MB
        ], [
            'pengirim' => 'Nama Pengirim tidak boleh menggunakan simbol atau angka',
            'perihal' => 'Perihal tidak boleh menggunakan simbol atau angka',
            'diterima_dari' => 'Nama Penerima tidak boleh menggunakan simbol atau angka',
        ]);
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
            $destination = `/storage/app/public/assets/img/surat/$Surat_masuk->file`;
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
        return redirect('/surat/surat-masuk')->with('success_message', 'Surat Updated!');
    }
    public function arsip($id)
    {
        $arsip = SuratMasuk::findOrFail($id);
        $arsip->update(['status' => 5]);

        return back()->with('sukses', 'Berhasil Arsipkan Surat');
    }
    public function selesai($id)
    {
        $arsip = SuratMasuk::findOrFail($id);
        $suratDisposisis = SuratDisposisi::where('surat_masuk_id', $id)->get();

        // update status surat masuk
        $arsip->update(['status' => 7]);

        // update status milik data surat disposisi (agar menjadi 1) yang berkaitan dengan surat masuk
        foreach ($suratDisposisis as $disposisi) {
            $disposisi->update(['status' => 1]);
        }

        return back()->with('sukses', 'Berhasil Menyelesaikan Surat');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function disposisi($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        // tidak mengizinkan jika berkas berstatus arsip (5)
        if ($surat->status === 5) {
            return redirect('/surat/surat-masuk')->with('sukses', 'Surat Jenis Arsip tidak Di izinkan');
        } else {
            $disposisi = SuratDisposisi::where('surat_masuk_id', $id)->get();
            $bukti = BuktiTugas::with('surat_masuk')->where('surat_id', $id)->first();

            return view('surat::surat.lembar-disposisi', compact('surat', 'disposisi', 'bukti'));
        }
    }

    public function disposisiSurat(Request $request, $id)
    {
        $surat_masuk = SuratMasuk::findOrFail($id);
        if ($request->disposisi == ['Sekdir']) {
            $data = [
                'disposisi' => implode(',', $request->disposisi),
                'status' => 6,
            ];
        } else {
            $data = [
                'disposisi' => implode(',', $request->disposisi),
            ];
        }
        $surat_masuk->update($data);
        $disposisi = [
            'surat_masuk_id' => $id,
            'user_id' => auth()->user()->id,
            'tujuan_disposisi' => implode(',', $request->disposisi),
            'induk' => $request->induk,
            'waktu' => $request->waktu,
            'status' => 1,
            'disposisi_singkat' => $request->disposisi_singkat,
            'disposisi_narasi' => $request->disposisi_narasi,
        ];
        SuratDisposisi::create($disposisi);
        return redirect('/surat/surat-masuk')->with('sukses', 'Berhasil Tambah Disposisi Surat');
    }

    // acc surat untuk pegawai / unit
    public function acc(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        // Ambil jabatan user yang login
        $jabatan = DB::table('users')
            ->join('pegawais', 'users.username', '=', 'pegawais.username')
            ->join('pejabats', 'pegawais.id', '=', 'pejabats.pegawai_id')
            ->where('users.id', auth()->id())
            ->select('pejabats.jabatan')
            ->first();

        if (!$jabatan) {
            return back()->with('error', 'Jabatan tidak ditemukan.');
        }

        // ✅ Gunakan ValidasiFileService
        $validasi = new ValidasiFileService();
        $validationData = $validasi->validateFile();

        $request->validate(
            $validationData['rules'],
            $validationData['messages']
        );

        // Lanjut proses
        SuratDisposisi::where('surat_masuk_id', $id)
            ->whereRaw('FIND_IN_SET(?, tujuan_disposisi)', [$jabatan->jabatan])
            ->update(['status' => 1]);

        $jumlah_disposisi = SuratDisposisi::where('surat_masuk_id', $id)->count();
        $jumlah_selesai = SuratDisposisi::where('surat_masuk_id', $id)->where('status', 1)->count();

        if ($jumlah_disposisi > 0 && $jumlah_disposisi == $jumlah_selesai) {
            $surat->update(['status' => 7]);
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

    public function destroy($id)
    {
        $hapus = SuratMasuk::findOrFail($id);
        $hapus->delete();
        $disposisi = SuratDisposisi::where('surat_masuk_id', $id);
        $disposisi->delete();
        return back()->with('sukses', 'Berhasil Hapus Surat');
    }
    public function diagram($id)
    {
        // $surat_masuk = SuratMasuk::findOrFail($id);
        $disposisi = SuratDisposisi::where('surat_masuk_id', $id)->get();

        $nodes = [];
        $links = [];
        $direkturExists = false;

        $nodes[] = [
            'key' => 'Direktur',
            'name' => 'Direktur',
            'status' => 'king',
            'parent' => 'Sekdir'
        ];

        foreach ($disposisi as $item) {
            $jabatan = DB::table('users')
                ->join('pegawais', 'users.username', '=', 'pegawais.username')
                ->join('pejabats', 'pegawais.id', '=', 'pejabats.pegawai_id')
                ->where('users.id', $item->user_id)
                ->select('pejabats.jabatan')
                ->first();

            $node = [
                'key' => $item->tujuan_disposisi,
                'name' => $item->tujuan_disposisi,
                'status_disposisi' => $item->status,
                'status' => 'king',
                'parent' => $jabatan->jabatan
            ];

            // Menambahkan node hanya jika belum ada
            if (!array_filter($nodes, fn($n) => $n['key'] === $node['key'])) {
                $nodes[] = $node;
            }

            // Link dari jabatan ke tujuan disposisi
            $links[] = [
                'from' => $jabatan->jabatan,
                'to' => $item->tujuan_disposisi,
            ];

            // Kondisi untuk panah kembali ke Direktur
            if ($item->isReturning) {
                $links[] = [
                    'from' => $item->tujuan_disposisi,
                    'to' => 'Direktur',
                    'isReturning' => true
                ];
                $direkturExists = true;
            }
        }
        // Menambahkan Direktur ke nodes jika belum ada
        if ($direkturExists && !array_filter($nodes, fn($n) => $n['key'] === 'Direktur')) {
            $nodes[] = [
                'key' => 'Direktur',
                'name' => 'Direktur',
                'status' => 'king',
                'parent' => 'Sekdir'
            ];
        }

        return view('surat::surat.diagram', [
            'diagramNodes' => $nodes,
            'diagramLinks' => $links,
            'id' => $id
        ]);
    }
}

class ValidasiFileService
{
    private function getValidasiFileRules()
    {
        return env('VALIDASI_FILE_RULES');
    }

    private function getValidasiFileMessages()
    {
        return [
            'foto.file' => 'File yang dikirimkan tidak valid.',
            'foto.mimes' => 'Format file harus PDF.',
            'foto.max' => 'Ukuran file maksimal 5MB.',
        ];
    }

    public function validateFile()
    {
        return [
            'rules' => ['foto' => $this->getValidasiFileRules()],
            'messages' => $this->getValidasiFileMessages()
        ];
    }
}
