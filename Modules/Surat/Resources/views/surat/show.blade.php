@extends('adminlte::page')
@section('iframe', true)
@section('title', 'Detail Surat Masuk')
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
                    <a href="{{ url('/surat/surat-masuk/' . $surat->id . '/edit') }}" title="Edit JenisLuaran"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
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
                                    <th>Files</th>
                                    <td><iframe src="{{ asset('storage/assets/img/surat') . '/' . $surat->file }}" width="100%" height="600"></iframe></td>
                                </tr>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @if ($disposisi->count() != null)
        @foreach ($disposisi as $item)
            <div class="row" id="isi_disposisi">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Isi Disposisi {{ $item->user->name }}</div>
                        <div class="card-body">
                            <br>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Disposisi Singkat</th>
                                            <td>{{ $item->disposisi_singkat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Disposisi Narasi</th>
                                            <td>{{ $item->disposisi_narasi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tujuan Disposisi</th>
                                            <td>{{ $item->tujuan_disposisi }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@stop
