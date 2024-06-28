{{-- @extends('surat::layouts.main') --}}
@extends('adminlte::page')
@section('title', 'Surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Informasi Surat</div>
                <div class="card-body">
                    <a href="{{ url('/surat/surat-masuk/create') }}" type="button" class="btn btn-sm btn-primary waves-effect waves-light mb-3">
                        <i class="fa fa-plus me-2"></i> Tambah Surat</a>

                    <div class="table-responsive table-striped">
                        <table class="table align-middle table-nowrap mb-0 datatables" id="tabel_surat">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 20px;">No</th>
                                    <th class="align-middle text-center">Nomor Surat</th>
                                    <th class="align-middle text-center">Tanggal Surat</th>
                                    <th class="align-middle text-center">Pengirim</th>
                                    <th class="align-middle text-center">Perihal</th>
                                    <th class="align-middle text-center">Sifat</th>
                                    <th class="align-middle text-center">Status</th>
                                    <th class="align-middle text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surat as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td><a href="javascript: void(0);" class="text-body fw-bold">{{ $item->nomor }}</a> </td>
                                        <td>
                                            {{ date('d F Y', strtotime($item->tanggal_surat)) }}
                                        </td>
                                        <td>{{ $item->pengirim }}</td>
                                        <td>
                                            {{ $item->perihal }}
                                        </td>
                                        <td>
                                            {{ $item->sifat }}
                                        </td>

                                        {{-- <td class="text-center">
                                        @if ($item->tujuan_disposisi != null)   
                                        {{ $item->tujuan_disposisi }}
                                        @else
                                            -
                                        @endif
                                    </td> --}}
                                        <td class="text-center">
                                            @if ($item->status == 2)
                                                <span class="badge bg-primary font-size-11">Dikirim ke pimpinan</span>
                                            @elseif ($item->status == 3)
                                                <span class="badge bg-warning font-size-11">Dikirim ke Wadir</span>
                                            @elseif ($item->status == 4)
                                                <span class="badge bg-success font-size-11">Dikirim ke Pegawai</span>
                                            @else
                                                <span class="badge bg-secondary font-size-11">Arsip</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Button trigger modal -->
                                            <a href="{{ url('surat/surat-masuk/' . $item->id . '/edit') }}"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button></a>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus" onclick="hapus({{$item->id}})"><i class="fas fa-trash"></i></button>
                                            <a href="{{ url('surat/surat-masuk/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#arsip" onclick="arsip({{$item->id}})"><i class="fas fa-file-archive"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal fade" id="arsip" dtabindex="-1" aria-labelledby="modalIcon" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Arsipkan Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    Apa Anda Yakin ingin Mengarsipkan Surat ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
                    <form id="arsip_surat" method="POST">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-secondary">Arsipkan</button>
                    </form>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hapus" dtabindex="-1" aria-labelledby="modalIcon" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Hapus Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    Apa Anda Yakin ingin Menghapus Surat ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
                    <form id="hapus_surat" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            let table = new DataTable('#tabel_surat');

            function arsip(id) {
            $('#arsip_surat').attr('action', "{{ url('/surat/surat-masuk/arsip') }}" + "/" + id);
        }
            function hapus(id) {
            $('#hapus_surat').attr('action', "{{ url('/surat/surat-masuk/') }}" + "/" + id);
        }
        </script>
    @endpush
    @push('css')
        <style type="text/css">
            #tabel_surat tr td,
            #tabel_surat tr th {
                vertical-align: middle;
                text-align: center;
            }
        </style>
    @endpush
@endsection
