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
                <a href="{{ url('/surat/wadir') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <br><br>
                <form action="{{ url('surat/wadir/updateDisposisi/' . $surat->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="example-text-input">Tujuan Disposisi</label>
                            <select name="tujuan_disposisi[]" class="form-control select2" multiple="multiple">
                                @foreach ($user as $item)
                                    <option value="{{ $item->name }}"{{ in_array($item->name, explode(',', $surat->tujuan_disposisi)) ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="example-text-input" class="col-form-label">Induk</label>
                            <input class="form-control" type="text" name="induk" value="{{$surat->induk}}">
                        </div>
                        <div class="col-md-6">
                            <label for="example-text-input" class="col-form-label">Waktu</label>
                            <input class="form-control" type="datetime-local" name="waktu" value="{{$surat->waktu}}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Disposisi Singkat</label>
                        <textarea type="" name="disposisi_singkat" id="" class="form-control">{{$surat->disposisi_singkat}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="">Disposisi Narasi</label>
                        <textarea type="" name="disposisi_narasi" id="" class="form-control">{{$surat->disposisi_narasi}}</textarea>
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
         $(function () {
            $('.select2').select2();
         });
    </script>
@endpush