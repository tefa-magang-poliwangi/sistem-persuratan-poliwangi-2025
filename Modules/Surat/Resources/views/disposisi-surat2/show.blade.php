@extends('adminlte::page')
@section('title', 'Show Disposisi surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
                    <div class="card-header">Disposisi Surat {{$disposisi->surat_masuk->pengirim}}</div>
                    <div class="card-body">

                        <a href="{{ url('/surat/disposisi-surat') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                        <a href="{{ url('/surat/disposisi-surat/' . $disposisi->id . '/edit') }}" title="Edit JenisLuaran"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>

                        {{-- <form method="POST" action="{{ url('/kepegawaian/pegawai' . '/' . $pegawai->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete JenisLuaran" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</button>
                        </form> --}}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th>Pengirim</th><td>{{ $disposisi->surat_masuk->pengirim }}</td></tr>
                                    <tr><th>Perihal</th><td>{{ $disposisi->surat_masuk->perihal }}</td></tr>
                                    <tr><th>Sifat</th><td>{{ $disposisi->surat_masuk->sifat }}</td></tr>
                                    <tr><th>Induk</th><td>{{ $disposisi->induk }}</td></tr>
                                    <tr><th> Disposisi Singkat </th><td> {{ $disposisi->disposisi_singkat }} </td></tr>
                                    <tr><th> Disposisi Narasi </th><td> {{ $disposisi->disposisi_narasi }} </td></tr>
                                    @if (pathinfo($disposisi->lampiran_tindak_lanjut, PATHINFO_EXTENSION) === 'pdf')
                                    <tr><th>Lampiran Disposisi</th><td><embed src="{{ asset('storage/assets/img/disposisi/' . $disposisi->lampiran_tindak_lanjut) }}" type="application/pdf" width="100%" height="600"></td></tr>
                                    @else
                                    <tr><th>Lampiran Disposisi</th><td><img src="{{asset('storage/assets/img/disposisi/' . $disposisi->lampiran_tindak_lanjut) }}" alt="" width="600" height="600"></td></tr>
                                    @endif
                                    @if (pathinfo($disposisi->surat_masuk->file, PATHINFO_EXTENSION) === 'pdf')
                                    <tr><th>Surat</th><td><embed src="{{ asset('storage/assets/img/surat/' . $disposisi->surat_masuk->file) }}" type="application/pdf" width="100%" height="600"></td></tr>
                                    @else
                                        
                                    <tr><th>Surat</th><td><img src="{{asset('storage/assets/img/surat/' . $disposisi->surat_masuk->file) }}" alt="" width="600" height="600"></td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                
        </div>
    </div>
</div>
@stop