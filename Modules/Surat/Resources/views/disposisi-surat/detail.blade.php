@extends('adminlte::page')
@section('title', 'Detail')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Surat {{ $surat_dispo->surat_masuk->pengirim }}</div>
                <div class="card-body">
                    <a href="{{ url('/surat/disposisi-surat') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nomor Surat</th>
                                    <td>{{ $surat_dispo->surat_masuk->nomor }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Surat</th>
                                    <td>{{ date('j F Y', strtotime($surat_dispo->surat_masuk->tanggal_surat)) }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Diterima</th>
                                    <td>{{ date('l, j F Y  H.i', strtotime($surat_dispo->surat_masuk->tanggal_diterima)) }}</td>
                                </tr>
                                <tr>
                                    <th>Pengirim</th>
                                    <td>{{ $surat_dispo->surat_masuk->pengirim }}</td>
                                </tr>
                                <tr>
                                    <th>Perihal</th>
                                    <td>{{ $surat_dispo->surat_masuk->perihal }}</td>
                                </tr>
                                <tr>
                                    <th>Sifat</th>
                                    <td>{{ $surat_dispo->surat_masuk->sifat }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan Sekretariat</th>
                                    <td>{{ $surat_dispo->surat_masuk->catatan_sekretariat }}</td>
                                </tr>
                                <tr>
                                    <th>Surat</th>
                                    <td><a href="{{asset('storage/assets/img/surat/' . $surat_dispo->surat_masuk->file)}}" title="Download file" download="Surat dari {{$surat_dispo->surat_masuk->pengirim}}"><button class="btn btn-warning btn-sm"><i class="fas fa-cloud-download-alt" aria-hidden="true"></i> Download</button></a>
                                        <a href="{{asset('storage/assets/img/surat/' . $surat_dispo->surat_masuk->file)}}" title="Lihat File" target="_blank"><button class="btn btn-primary btn-sm"><i class="fas fa-eye" aria-hidden="true"></i> Lihat File</button></a></td>
                                </tr>
                                <tr>
                                    <th>Tujuan Disposisi</th>
                                    <td>{{ $surat_dispo->tujuan_disposisi }}</td>
                                </tr>
                                <tr>
                                    <th>Disposisi Singkat</th>
                                    <td>{{ $surat_dispo->disposisi_singkat }}</td>
                                </tr>
                                <tr>
                                    <th>Disposisi Narasi</th>
                                    <td>{{ $surat_dispo->disposisi_narasi }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
