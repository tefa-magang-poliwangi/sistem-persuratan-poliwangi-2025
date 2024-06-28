@extends('adminlte::page')
@section('plugins.Select2', true)
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

                    <a href="{{ url('/surat/disposisi-surat') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    
                    {{-- <form method="POST" action="{{ url('/kepegawaian/pegawai' . '/' . $pegawai->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete JenisLuaran" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</button>
                        </form> --}}
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
                                @if (pathinfo($surat->file, PATHINFO_EXTENSION) === 'pdf')
                                    <tr>
                                        <th>File</th>
                                        <td><embed src="{{ asset('storage/assets/img/surat/' . $surat->file) }}" type="application/pdf" width="100%" height="600"></td>
                                    </tr>
                                @else
                                    <tr>
                                        <th>File</th>
                                        <td><img src="{{ asset('storage/assets/img/surat') . '/' . $surat->file }}" alt=""></td>
                                    </tr>
                                @endif
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Surat {{ $surat->pengirim }}</div>
                <div class="card-body">
                    <form action="{{ url('surat/disposisi-surat/' . $surat->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Tujuan Disposisi</label>
                                <select class="form-control" 
								name="disposisi" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6" hidden>
                                <label for="example-text-input">Tujuan Disposisi</label>
                                <select name="tujuan_disposisi" class="form-control">
                                    {{-- <option value="" selected disabled>--Pilih--</option> --}}
                                    {{-- @foreach ($user as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Induk</label>
                                <input class="form-control" type="text" name="induk">
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Waktu</label>
                                <input class="form-control" type="datetime-local" name="waktu">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Disposisi Singkat</label>
                            <textarea type="" name="disposisi_singkat" id="" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">Disposisi Narasi</label>
                            <textarea type="" name="disposisi_narasi" id="" class="form-control"></textarea>
                        </div>
                        {{-- <div class="mb-3">
                                <label for="">Lampiran</label>
                                <input type="file" name="lampiran_tindak_lanjut" id="" class="form-control">
                            </div> --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
