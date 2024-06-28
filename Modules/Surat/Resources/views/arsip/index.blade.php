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
                <div class="card-header">Informasi Surat</div>
                <div class="card-body">

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
                                        <td class="text-center">
                                            <a href="{{ url('surat/arsip/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
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
