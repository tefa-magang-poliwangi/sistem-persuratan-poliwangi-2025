@extends('adminlte::page')
@section('iframe', true)
@section('title', 'Show Surat Masuk')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
                    <div class="card-header">Surat {{$surat->pengirim}}</div>
                    <div class="card-body">

                        <a href="{{ url('/surat/surat-masuk') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                        <a href="{{ url('/surat/surat-masuk/' . $surat->id . '/edit') }}" title="Edit JenisLuaran"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>

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
                                    <tr><th>Induk</th><td>{{ $surat->induk }}</td></tr>
                                    <tr><th>Nomor Surat</th><td>{{ $surat->nomor }}</td></tr>
                                    <tr><th>Tanggal Surat</th><td>{{date('j F Y',strtotime($surat->tanggal_surat)) }}</td></tr>
                                    <tr><th>Tanggal Diterima</th><td>{{date('l, j F Y  H.i',strtotime($surat->tanggal_diterima)) }}</td></tr>
                                    <tr><th>Pengirim</th><td>{{ $surat->pengirim }}</td></tr>
                                    <tr><th>Perihal</th><td>{{ $surat->perihal }}</td></tr>
                                    <tr><th>Sifat</th><td>{{ $surat->sifat }}</td></tr>
                                    <tr><th>Catatan Sekretariat</th><td>{{ $surat->catatan_sekretariat }}</td></tr>
                                    <tr><th>Files</th><td><iframe src="{{ asset('storage/assets/img/surat').'/' . $surat->file }}"  width="100%" height="600"></iframe></td></tr>
                                    
                                    
                                    {{-- <tr><th>Induk</th><td>{{ $disposisi->induk }}</td></tr>
                                    <tr><th> Disposisi Singkat </th><td> {{ $disposisi->disposisi_singkat }} </td></tr>
                                    <tr><th> Disposisi Narasi </th><td> {{ $disposisi->disposisi_narasi }} </td></tr> --}}
                                </tbody>
                            </table>
                        </div>

                    </div>
                
        </div>
    </div>
</div>
@stop