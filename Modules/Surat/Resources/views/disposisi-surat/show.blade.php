@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'Disposisi')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Surat {{ $surat->pengirim }}</div>
                <div class="card-body">
                    <a href="{{ url('/surat/disposisi-surat') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nomor Surat</th>
                                    <td>{{ $surat->nomor }}</td>
                                    <th>Tanggal Surat</th>
                                    <td>{{ date('j F Y', strtotime($surat->tanggal_surat)) }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Diterima</th>
                                    <td>{{ date('l, j F Y  H.i', strtotime($surat->tanggal_diterima)) }}</td>
                                    <th>Pengirim</th>
                                    <td>{{ $surat->pengirim }}</td>
                                </tr>
                                <tr>
                                    <th>Perihal</th>
                                    <td>{{ $surat->perihal }}</td>
                                    <th>Sifat</th>
                                    <td>{{ $surat->sifat }}</td>
                                </tr>
                                <tr>
                                    <th>File</th>
                                    <td><a href="{{ asset('storage/assets/img/surat/' . $surat->file) }}" title="Lihat File"
                                            target="_blank"><button class="btn btn-primary btn-sm"><i class="fas fa-eye"
                                                    aria-hidden="true"></i> Lihat File</button></a>
                                        <a href="{{ asset('storage/assets/img/surat/' . $surat->file) }}"
                                            title="Download file" download="Surat dari {{ $surat->pengirim }}"><button
                                                class="btn btn-success btn-sm"><i class="fas fa-cloud-download-alt"
                                                    aria-hidden="true"></i> Download</button></a>

                                    </td>
                                    <th>Catatan Sekretariat</th>
                                    <td>{{ $surat->catatan_sekretariat }}</td>
                                </tr>
                                {{-- @if (pathinfo($surat->file, PATHINFO_EXTENSION) === 'pdf')
                                        <th>File</th>
                                        <td colspan="3"><embed src="{{ asset('storage/assets/img/surat/' . $surat->file) }}" type="application/pdf" width="100%" height="600"></td>
                                    @else
                                        <th>File</th>
                                        <td colspan="3"><img src="{{ asset('storage/assets/img/surat') . '/' . $surat->file }}" alt=""></td>
                                    @endif --}}
                                {{-- </tr> --}}
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
                <div class="card-header">Tulis Disposisi Surat {{ $surat->pengirim }}</div>
                <div class="card-body">
                    <form action="{{ url('surat/disposisi-surat/' . $surat->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="tujuan_disposisi" class="col-form-label">Tujuan Disposisi <span
                                        class="text-danger fw-bold">*</span></label>
                                <select class="form-control" name="disposisi" id="tujuan_disposisi" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->jabatan }}">{{ $item->jabatan }}</option>
                                    @endforeach
                                    <option value="Sekretaris">Kembali ke Sekretaris</option>
                                </select>
                            </div>
                            <div class="col-md-6" hidden>
                                <label for="example-text-input">Tujuan Disposisi</label>
                                <select name="tujuan_disposisi" class="form-control">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="waktu" class="col-form-label">Waktu <span
                                        class="text-danger fw-bold">*</span></label>
                                <input class="form-control" type="datetime-local" name="waktu" id="waktu"
                                    value="{{ (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i') }}"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-2" hidden>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Induk</label>
                                <input class="form-control" type="text" name="induk" value="{{ $surat->id }}">
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="disposisi_singkat">Disposisi Singkat
                                <span class="text-danger fw-bold">*</span>
                            </label>
                            <textarea type="text" name="disposisi_singkat" id="disposisi_singkat" class="form-control"
                                placeholder="Masukkan pesan disposisi singkat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="disposisi_narasi">Disposisi Narasi
                                <span class="text-primary fw-bold">* (opsional)</span>
                            </label>
                            <textarea type="text" name="disposisi_narasi" id="disposisi_narasi" class="form-control"
                                placeholder="Masukkan pesan disposisi narasi"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
