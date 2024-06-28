{{-- @extends('surat::layouts.master') --}}
@extends('adminlte::page')
@section('title', 'Disposisi Surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4 class="card-title mb-4">Disposisi Surat</h4>
                    </div>
                    <div class="d-flex flex-wrap gap-2 col-md-6 justify-content-end">
                        <a href="{{url('/surat/disposisi-surat/create')}}" type="button" class="btn btn-primary waves-effect waves-light">
                            <i class="bx bx-plus label-icon"></i>Tambah Surat</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0" id="tabel_surat">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 20px;">No</th>
                                <th class="align-middle text-center">Nomor Surat</th>
                                <th class="align-middle text-center">Induk</th>
                                <th class="align-middle text-center">Waktu</th>
                                <th class="align-middle text-center">Disposisi Singkat</th>
                                <th class="align-middle text-center">Jenis</th>
                                <th class="align-middle text-center">Status</th>
                                <th class="align-middle text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($disposisi as $item)
                                <tr>
                                    <td class="text-center">
                                        {{$loop->iteration}}
                                    </td>
                                    <td><a href="javascript: void(0);" class="text-body fw-bold">{{ $item->surat_masuk->nomor }}</a> </td>
                                    <td class="text-center">{{ $item->induk }}</td>
                                    <td class="text-center">
                                        {{ date('j F Y H:i', strtotime($item->waktu)) }}
                                    </td>
                                    <td>
                                        {{ $item->disposisi_singkat }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->jenis }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->status }}
                                    </td>
                                    {{-- <td>
                                        {{ date('d F Y', strtotime($item->tanggal_surat)) }}
                                    </td> --}}
                                    <td class="text-center">
                                        <a href="{{url('surat/disposisi-surat/' .$item->id. '/edit')}}"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button></a>
                                        <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        <a href="{{url('surat/disposisi-surat/' .$item->id)}}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
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
<script>
    let table = new DataTable('#tabel_surat');
</script>
@endsection
