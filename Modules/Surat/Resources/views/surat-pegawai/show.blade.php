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
                <div class="card-header">Surat dari {{ $surat->pengirim }}</div>
                <div class="card-body">
                    <a href="{{ url('/surat/surat-masuk') }}" title="Back"><button class="btn btn-warning btn-sm"><i
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
                                    <th>Perihal</th>
                                    <td>{{ $surat->perihal }}</td>
                                    {{-- <th>Tanggal Diterima</th>
                                    <td>{{ date('l, j F Y  H.i', strtotime($surat->tanggal_diterima)) }}</td> --}}
                                    <th>Pengirim</th>
                                    <td>{{ $surat->pengirim }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan Sekretariat</th>
                                    <td>{{ $surat->catatan_sekretariat }}</td>
                                    <th>Sifat</th>
                                    <td>{{ $surat->sifat }}</td>
                                </tr>
                                <tr>
                                    <th>Surat</th>
                                    <td>
                                        <a href="{{ asset('storage/assets/img/surat/' . $surat->file) }}" title="Lihat File"
                                            target="_blank">
                                            <button class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye" aria-hidden="true"></i> Lihat File
                                            </button>
                                        </a>
                                        <a href="{{ asset('storage/assets/img/surat/' . $surat->file) }}"
                                            title="Download file" download="Surat dari {{ $surat->pengirim }}">
                                            <button class="btn btn-warning btn-sm">
                                                <i class="fas fa-cloud-download-alt" aria-hidden="true"></i> Download
                                            </button>
                                        </a>
                                    </td>
                                    <th>Isi Disposisi</th>
                                    <td colspan="3">
                                        <button id="button_lihat" class="btn btn-sm btn-success">Lihat</button>
                                    </td>
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
                <div class="card-header">Disposisi</div>
                <div class="card-body">
                    <br>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Dari</th>
                                    <td>{{ $user_disposisi->jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Disposisi Singkat</th>
                                    <td>{{ $disposisi->disposisi_singkat }}</td>
                                </tr>
                                <tr>
                                    <th>Disposisi Narasi</th>
                                    <td>{{ $item->disposisi_narasi ?? '(tidak ditambahkan)' }}</td>
                                </tr>
                                <tr>
                                    <th>Tujuan Disposisi</th>
                                    <td>{{ $disposisi->tujuan_disposisi }}</td>
                                </tr>
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
                    <form action="{{ url('surat/surat-masuk/disposisi/' . $surat->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Tujuan Disposisi</label>
                                <select name="disposisi[]" class="form-control select2" id="" multiple="multiple">
                                    @foreach ($user as $item)
                                        <option value="{{ $item->jabatan }}">{{ $item->jabatan }}</option>
                                    @endforeach
                                    <option value="Sekdir">Kembali Ke Sekdir</option>
                                </select>
                            </div>
                            <div class="col-md-6" hidden>
                                <label for="example-text-input">Tujuan Disposisi</label>
                                <input name="tujuan_disposisi[]" class="form-control select2" multiple="multiple">

                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input">Waktu</label>
                                <input class="form-control" type="datetime-local" name="waktu"
                                    value="{{ (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i') }}">
                            </div>
                        </div>
                        <div class="row mb-3" hidden>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Induk</label>
                                <input class="form-control" type="text" name="induk" value="{{ $surat->id }}">
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
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script>
        $(function() {
            $('.select2').select2({
                placeholder: "--Pilih--",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#button_lihat').click(function() {
                $('#isi_disposisi').toggle();
            });
        });
    </script>
@endpush
