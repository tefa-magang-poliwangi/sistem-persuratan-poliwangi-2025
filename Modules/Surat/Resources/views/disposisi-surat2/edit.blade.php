@extends('adminlte::page')
@section('title', 'Edit Disposisi Surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Edit</div>
                <div class="card-body">
                    <form action="{{ url('surat/disposisi-surat/'. $disposisi->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Nomor Surat</label>
                                <select name="surat_masuk_id" class="form-control" id="">
                                    @foreach ($surat_masuk as $item)
                                        <option value="{{ $item->id }}"  {{ $disposisi->surat_masuk->nomor == $item->nomor ? 'selected' : '' }}>{{ $item->nomor }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Induk</label>
                                <input class="form-control" type="text" name="induk" value="{{$disposisi->induk}}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="example-text-input" class="col-form-label">Waktu</label>
                            <input class="form-control" type="datetime-local" name="waktu" value="{{$disposisi->waktu}}">
                        </div>
                        <div class="mb-3">
                            <label for="">Disposisi Singkat</label>
                            <textarea type="" name="disposisi_singkat" id="" class="form-control">{{$disposisi->disposisi_singkat}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">Disposisi Narasi</label>
                            <textarea type="" name="disposisi_narasi" id="" class="form-control">{{$disposisi->disposisi_narasi}}</textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Jenis</label>
                                <select name="jenis" class="form-control" id="">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="turun"  {{ isset($disposisi) && $disposisi->jenis == 'turun' ? 'selected' : '' }}>Turun</option>
                                    <option value="kembali"  {{ isset($disposisi) && $disposisi->jenis == 'kembali' ? 'selected' : '' }}>Kembali</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Status</label>
                                <select name="status" class="form-control" id="">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="proses"  {{ isset($disposisi) && $disposisi->status == 'proses' ? 'selected' : '' }}>proses</option>
                                    <option value="selesai"  {{ isset($disposisi) && $disposisi->status == 'selesai' ? 'selected' : '' }}>selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Lampiran</label>
                            <input type="file" name="lampiran_tindak_lanjut" id="" class="form-control" value="{{$disposisi->lampiran_tindak_lanjut}}">
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
