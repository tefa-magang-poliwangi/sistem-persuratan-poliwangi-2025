@extends('adminlte::page')
@section('title', 'Tambah Surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Tambah Surat</div>
                <div class="card-body">

                    <a href="{{ url('surat/surat-masuk') }}" title="Kembali"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <br>
                    <form action="{{ url('surat/surat-masuk') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="nomor" class="col-form-label">Nomor Surat
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <input class="form-control" type="text" name="nomor" id="nomor"
                                    value="{{ old('nomor') }}" placeholder="Masukkan nomor surat yang valid" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_surat" class="col-form-label">Tanggal Surat
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <input class="form-control" type="date" name="tanggal_surat" id="tanggal_surat"
                                    value="{{ old('tanggal_surat') }}" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="perihal" class="col-form-label">Perihal
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <input class="form-control" type="text" name="perihal" id="perihal"
                                    value="{{ old('perihal') }}"
                                    placeholder="Masukkan perihal surat masuk, tanpa simbol dan angka" required>
                            </div>
                            <div class="col-md-6">
                                <label for="pengirim" class="col-form-label">Pengirim
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <input class="form-control" type="text" name="pengirim" id="pengirim"
                                    value="{{ old('pengirim') }}" placeholder="Masukkan pengirim, tanpa simbol dan angka"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="diterima_dari" class="col-form-label">Diterima dari
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <input class="form-control" type="text" name="diterima_dari" id="diterima_dari"
                                    value="{{ old('diterima_dari') }}"
                                    placeholder="Masukkan diterima dari, tanpa simbol dan angka" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_diterima" class="col-form-label">Tanggal Diterima
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <input class="form-control" type="datetime-local" name="tanggal_diterima"
                                    id="tanggal_diterima" value="{{ old('tanggal_diterima') }}" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="sifat">Sifat
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <select name="sifat" class="form-control" id="sifat" value="{{ old('sifat') }}"
                                    required>
                                    <option value="" disabled {{ old('sifat') == '' ? 'selected' : '' }}>--Pilih--
                                    </option>
                                    <option value="biasa">Biasa</option>
                                    <option value="segera">segera</option>
                                    <option value="penting">penting</option>
                                    <option value="penting segera">penting segera</option>
                                    <option value="rahasia">rahasia</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status_surat">Pilih Tindakan <span class="text-danger fw-bold">*</span></label>
                                <select id="status_surat" name="status" class="form-control" required>
                                    <option value="" disabled {{ old('status') == '' ? 'selected' : '' }}>--Pilih--
                                    </option>
                                    <option value="5" {{ old('status') == '5' ? 'selected' : '' }}>Arsipkan</option>
                                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Ajukan Ke Pimpinan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="catatan_sekretariat">Catatan Sekretariat
                                <span class="text-primary fw-bold">* (opsional)</span>
                            </label>
                            <textarea type="text" name="catatan_sekretariat" id="catatan_sekretariat" class="form-control"
                                placeholder="Masukkan catatan sekretariat">{{ old('catatan_sekretariat') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="file" class="col-form-label">File <span
                                    class="text-danger fw-bold">*</span></label>
                            <input class="form-control" type="file" name="file" id="file"
                                value="{{ old('file') }}" required>
                            @if ($errors->has('file'))
                                <div style="width:auto; color:#dc4c64; margin-top:0.25rem;">
                                    {{ $errors->first('file') }}
                                </div>
                            @endif
                        </div>
                        {{-- <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Surat</label>
                                <input class="form-control" type="file" name="foto_surat">
                            </div>
                            <div class="col-md-6" id="lembar_disposisi" hidden>
                                <label for="example-text-input" class="col-form-label">Lembar Disposisi</label>
                                <input class="form-control" type="file" name="foto_disposisi">
                            </div>
                        </div> --}}
                        {{-- <div class="mb-2" id="tujuan" hidden>
                            <label for="">Tujuan Disposisi</label>
                            <select name="tujuan_disposisi" class="form-control" id="">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="Direktur">Direktur</option>
                                <option value="Wadir I">Wakil Direktur I</option>
                                <option value="Wadir II">Wakil Direktur II</option>
                            </select>
                        </div> --}}
                        <div class="row mb-2 mt-3">
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
