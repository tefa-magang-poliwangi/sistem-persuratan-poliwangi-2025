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

                    <a href="{{ url('/surat/wadir') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Induk</th>
                                    <td>{{ $surat->induk }}</td>
                                </tr>
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
                                    <td><a href="{{asset('storage/assets/img/surat/' . $surat->file)}}" title="Download file" download="Surat dari {{$surat->pengirim}}"><button class="btn btn-warning btn-sm"><i class="fas fa-cloud-download-alt" aria-hidden="true"></i> Download</button></a>
                                        <a href="{{asset('storage/assets/img/surat/' . $surat->file)}}" title="Lihat File" target="_blank"><button class="btn btn-primary btn-sm"><i class="fas fa-eye" aria-hidden="true"></i> Lihat File</button></a></td>
                                </tr>
                                <tr>
                                    <th>Isi Disposisi Direktur</th>
                                    <td><button id="button_lihat" class="btn btn-sm btn-success">Lihat</button></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row" style="display: none" id="isi_disposisi">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Disposisi Dari Direktur</div>
                <div class="card-body">
                    <br>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Disposisi Singkat</th>
                                    <td>{{$disposisi->disposisi_singkat}}</td>
                                </tr>
                                <tr>
                                    <th>Disposisi Narasi</th>
                                    <td>{{$disposisi->disposisi_narasi}}</td>
                                </tr>
                                <tr>
                                    <th>Tujuan Disposisi</th>
                                    <td>{{$disposisi->tujuan_disposisi}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script>
        $(document).ready(function() {
            $('#button_lihat').click(function() {
                $('#isi_disposisi').toggle();
            });
        });
    </script>
@endpush
