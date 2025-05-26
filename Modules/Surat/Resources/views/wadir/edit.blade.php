@extends('adminlte::page')
@section('title', 'Show Surat Masuk')
@section('plugins.Select2', true)
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Edit Lembar Disposisi</div>
                <div class="card-body">
                    <a href="{{ url('/surat/wadir') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <br><br>
                    <form action="{{ url('surat/wadir/updateDisposisi/' . $surat->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tujuan_disposisi" class="col-form-label">Tujuan Disposisi
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <select name="tujuan_disposisi[]" id="tujuan_disposisi" class="form-control select2"
                                    multiple="multiple" required>
                                    <option value="Sekdir"
                                        {{ 'Sekdir' == $surat->tujuan_disposisi ? 'selected' : '' }}>Kembali ke
                                        Sekdir</option>
                                    @foreach ($user as $item)
                                        <option
                                            value="{{ $item->jabatan }}"{{ in_array($item->jabatan, explode(',', $surat->tujuan_disposisi)) ? 'selected' : '' }}>
                                            {{ $item->jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Waktu
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <input class="form-control" type="datetime-local" name="waktu" value="{{ $surat->waktu }}"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3" hidden>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Induk</label>
                                <input class="form-control" type="text" name="induk" value="{{ $surat->induk }}">
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="disposisi_singkat">Disposisi Singkat
                                <span class="text-danger fw-bold">*</span>
                            </label>
                            <textarea type="text" name="disposisi_singkat" id="disposisi_singkat" class="form-control"
                                placeholder="Masukkan disposisi singkat" required>{{ $surat->disposisi_singkat }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="disposisi_narasi">Disposisi Narasi
                                <span class="text-primary fw-bold">* (opsional)</span>
                            </label>
                            <textarea type="text" name="disposisi_narasi" id="disposisi_narasi" class="form-control"
                                placeholder="Masukkan disposisi narasi">{{ $surat->disposisi_narasi }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
@endpush
