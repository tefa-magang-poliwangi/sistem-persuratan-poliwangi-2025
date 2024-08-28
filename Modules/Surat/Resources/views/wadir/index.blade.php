{{-- @extends('surat::layouts.master') --}}
@extends('adminlte::page')
@section('title', 'Surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Informasi Surat {{ auth()->user()->name }}</div>
                <div class="card-body">
                    <div class="table-responsive table-striped">
                        <table class="table align-middle table-nowrap  mb-0" id="tabel_surat">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 20px;">No</th>
                                    <th class="align-middle text-center">Nomor Surat</th>
                                    <th class="align-middle text-center">Tanggal</th>
                                    <th class="align-middle text-center">Pengirim</th>
                                    <th class="align-middle text-center">Perihal</th>
                                    <th class="align-middle text-center">Sifat</th>
                                    <th class="align-middle text-center">Status</th>
                                    <th class="align-middle text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($surat)
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
                                            <td class="text-center">
                                                @if ($item->status == 2)
                                                    <span class="badge bg-primary font-size-11">Menunggu Pimpinan</span>
                                                @elseif ($item->status == 3)
                                                    <span class="badge bg-warning font-size-11">Menunggu Disposisi</span>
                                                @elseif ($item->status == 4)
                                                    <span class="badge bg-success font-size-11">Dikirim Ke Pegawai</span>
                                                @elseif ($item->status == 6)
                                                    <span class="badge bg-secondary font-size-11">Kembali ke Sekretaris</span>
                                                @elseif ($item->status == 7)
                                                    <span class="badge bg-dark font-size-11">Selesai</span>
                                                @else
                                                    <span class="badge bg-secondary font-size-11">Arsip</span>
                                                @endif
                                            </td>
                                            <td class="text-center">@if ($item->status == '3')
                                                    <a href="{{ url('surat/wadir/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#acc" onclick="acc({{ $item->id }})"><i class="fas fa-check"></i></button>
                                                @elseif ($item->status == '4')
                                                    <a href="{{ url('surat/wadir/' . $item->id . '/edit') }}"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button></a>
                                                    <a href="{{ url('surat/wadir/detail/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                                @elseif ($item->status == '6')
                                                    <a href="{{ url('surat/wadir/' . $item->id . '/edit') }}"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button></a>
                                                    <a href="{{ url('surat/wadir/detail/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                                @elseif ($item->status == '7')
                                                    <a href="{{ url('surat/wadir/detail/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p>Data Kosong</p>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="acc" dtabindex="-1" aria-labelledby="modalIcon" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Approve Disposisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="acc_surat" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div>
                            <div class="dropzone">
                                <div class="fallback">
                                    <label for="" style="font-weight: 500">Bukti Tugas <span style="font-weight: 800"> (*Opsional)</span></label>
                                    <input name="foto" type="file" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Selesai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            let table = new DataTable('#tabel_surat');

            function acc(id){
                $('#acc_surat').attr('action', "{{ url('/surat/wadir/acc') }}" + "/" + id);
            }
        </script>
    @endpush
@endsection
