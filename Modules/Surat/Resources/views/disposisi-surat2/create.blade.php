@extends('adminlte::page')
@section('title', 'Tambah Disposisi Surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Tambah</div>
                <div class="card-body">
                    <form action="{{ url('surat/disposisi-surat') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Nomor Surat</label>
                                <select name="surat_masuk_id" class="form-control" id="">
                                    @foreach ($disposisi_surat as $item)
                                        <option value="{{ $item->id }}">{{ $item->nomor }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Induk</label>
                                <input class="form-control" type="text" name="induk">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="example-text-input" class="col-form-label">Waktu</label>
                            <input class="form-control" type="datetime-local" name="waktu">
                        </div>
                        <div class="mb-3">
                            <label for="">Disposisi Singkat</label>
                            <textarea type="" name="disposisi_singkat" id="" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">Disposisi Narasi</label>
                            <textarea type="" name="disposisi_narasi" id="" class="form-control"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Jenis</label>
                                <select name="jenis" class="form-control" id="">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="turun">Turun</option>
                                    <option value="kembali">Kembali</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Status</label>
                                <select name="status" class="form-control" id="">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="proses">proses</option>
                                    <option value="selesai">selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Lampiran</label>
                            <input type="file" name="lampiran_tindak_lanjut" id="" class="form-control">
                        </div>
                        <div class="row mb-3 mt-5">
                            <div class="col-md-8 d-flex">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                {{-- <div class="col-md-2" id="kirim" hidden>
                                    <button type="button" class="btn btn-primary">Kirim</button>
                                </div> --}}
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-dark">Kembali</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
