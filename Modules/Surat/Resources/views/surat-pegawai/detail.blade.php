@extends('adminlte::page')
@section('title', 'Show Surat Masuk')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Surat {{ $surat->pengirim }}</div>
                <div class="card-body">

                    <a href="{{ url('/surat/surat-masuk') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nomor Surat</th>
                                    <td>{{ $surat->nomor }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Surat</th>
                                    <td>{{ date('j F Y', strtotime($surat->tanggal_surat)) }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Diterima</th>
                                    <td>{{ date('l, j F Y  H.i', strtotime($surat->tanggal_diterima)) }}</td>
                                </tr>
                                <tr>
                                    <th>Pengirim</th>
                                    <td>{{ $surat->pengirim }}</td>
                                </tr>
                                <tr>
                                    <th>Perihal</th>
                                    <td>{{ $surat->perihal }}</td>
                                </tr>
                                <tr>
                                    <th>Sifat</th>
                                    <td>{{ $surat->sifat }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan Sekretariat</th>
                                    <td>{{ $surat->catatan_sekretariat }}</td>
                                </tr>
                                <tr>
                                    <th>Surat</th>
                                    <td><a href="{{ asset('storage/assets/img/surat/' . $surat->file) }}" title="Download file" download="Surat dari {{ $surat->pengirim }}"><button class="btn btn-warning btn-sm"><i class="fas fa-cloud-download-alt" aria-hidden="true"></i> Download</button></a>
                                        <a href="{{ asset('storage/assets/img/surat/' . $surat->file) }}" title="Lihat File" target="_blank"><button class="btn btn-primary btn-sm"><i class="fas fa-eye" aria-hidden="true"></i> Lihat File</button></a>
                                    </td>
                                </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>Selesai</td>
                                    </tr>
                                    <tr>
                                        <th>Bukti</th>
                                        <td>
                                            @if($bukti && $bukti->foto)
                                            <img src="{{ asset('storage/assets/img/bukti') . '/' . $bukti->foto }}" width="50" height="50" alt="">
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
@stop
