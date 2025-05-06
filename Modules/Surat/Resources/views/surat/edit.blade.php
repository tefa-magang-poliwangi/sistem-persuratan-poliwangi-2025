@extends('adminlte::page')
@section('title', 'Edit Surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Edit Surat</div>
                <div class="card-body">
                <a href="{{ url( 'surat/surat-masuk' ) }}" title="Kembali"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <form action="{{ url('/surat/surat-masuk/' . $suratmasuk->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Nomor Surat</label>
                                <input class="form-control" type="text" name="nomor" value="{{ $suratmasuk->nomor }}">
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Tanggal Surat</label>
                                <input class="form-control" type="date" name="tanggal_surat" value="{{ $suratmasuk->tanggal_surat }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Perihal</label>
                                <input type="text" class="form-control" name="perihal" value="{{ $suratmasuk->perihal }}">
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Pengirim</label>
                                <input class="form-control" type="text" name="pengirim" value="{{ $suratmasuk->pengirim }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Diterima dari</label>
                                <input class="form-control" type="text" name="diterima_dari" value="{{ $suratmasuk->diterima_dari }}">
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Tanggal Diterima</label>
                                <input class="form-control" type="datetime-local" name="tanggal_diterima" value="{{ $suratmasuk->tanggal_diterima }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Sifat</label>
                            <select name="sifat" class="form-control" id="sifat">
                                <option value="" disabled>--Pilih--</option>
                                <option value="Biasa" {{ isset($suratmasuk) && $suratmasuk->sifat == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                <option value="Segera" {{ isset($suratmasuk) && $suratmasuk->sifat == 'Segera' ? 'selected' : '' }}>Segera</option>
                                <option value="Penting" {{ isset($suratmasuk) && $suratmasuk->sifat == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Penting Segera" {{ isset($suratmasuk) && $suratmasuk->sifat == 'Penting Segera' ? 'selected' : '' }}>Penting Segera</option>
                                <option value="Rahasia" {{ isset($suratmasuk) && $suratmasuk->sifat == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Catatan Sekretariat</label>
                            <textarea type="" name="catatan_sekretariat" id="" class="form-control">{{ $suratmasuk->catatan_sekretariat }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="example-text-input" class="col-form-label">File</label>
                            <input class="form-control" type="file" name="file" value="{{ old('file') }}">
                            @if ($errors->has('file'))
                                    <div style="width:auto; color:#dc4c64; margin-top:0.25rem;">
                                        {{ $errors->first('file') }}
                                    </div>
                            @endif
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Surat</label>
                                <input class="form-control" type="file" name="foto_surat">
                            </div>
                            <div class="col-md-6" id="lembar_disposisi" hidden>
                                <label for="example-text-input" class="col-form-label">Lembar Disposisi</label>
                                <input class="form-control" type="file" name="foto_disposisi">
                            </div>
                        </div> --}}
                        {{-- <div class="mb-3" id="tujuan" hidden>
                            <label for="">Tujuan Disposisi</label>
                            <select name="tujuan_disposisi" class="form-control" id="">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="Direktur">Direktur</option>
                                <option value="Wadir I">Wakil Direktur I</option>
                                <option value="Wadir II">Wakil Direktur II</option>
                            </select>
                        </div> --}}
                        <div class="row mb-3 mt-3">
                            <div class="col-md-8 d-flex">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('status_surat').addEventListener('change', function() {
            var statusSurat = this.value;
            var lembarDisposisi = document.getElementById('lembar_disposisi');
            var tujuan = document.getElementById('tujuan');
            // var kirim = document.getElementById('kirim');
            if (statusSurat == '1') {
                lembarDisposisi.removeAttribute('hidden');
                tujuan.removeAttribute('hidden');
                // kirim.removeAttribute('hidden');
            } else if (statusSurat == '2') {
                lembarDisposisi.setAttribute('hidden', 'hidden');
                tujuan.setAttribute('hidden', 'hidden');
                // kirim.setAttribute('hidden', 'hidden');
            }
        });
    </script>
@endsection
