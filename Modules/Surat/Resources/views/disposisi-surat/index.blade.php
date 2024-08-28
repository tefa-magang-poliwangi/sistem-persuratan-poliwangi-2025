@extends('adminlte::page')
@section('title', 'Disposisi Surat')
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
                        <table class="table align-middle table-nowrap mb-0" id="tabel_surat">
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
                                @foreach ($disposisi as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td><a href="javascript: void(0);" class="text-body fw-bold">{{ $item->nomor }}</a> </td>
                                        <td>
                                            {{ date('d F Y', strtotime($item->tanggal_surat)) }}
                                        </td>
                                        <td class="text-center">{{ $item->pengirim }}</td>
                                        <td>
                                            {{ $item->perihal }}
                                        </td>
                                        <td>
                                            {{ $item->sifat }}
                                        </td>
                                        <td class="text-center">
                                            @if ($item->status == 2)
                                                <span class="badge bg-warning font-size-11">Menunggu Disposisi</span>
                                            @elseif ($item->status == 3)
                                                <span class="badge bg-success font-size-11">Terkirim Ke Wadir</span>
                                            @elseif ($item->status == 6)
                                                <span class="badge bg-primary font-size-11">Kembali ke Sekretaris</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->status == '2')
                                                <a href="{{ url('surat/disposisi-surat/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                            @elseif ($item->status == '3')
                                                <a href="{{ url('surat/disposisi-surat/editDisposisi/' . $item->id) }}"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button></a>
                                                <a href="{{ url('surat/disposisi-surat/detail/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                            @elseif ($item->status == '6')
                                            <a href="{{ url('surat/disposisi-surat/editDisposisi/' . $item->id) }}"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button></a>
                                            <a href="{{ url('surat/disposisi-surat/detail/' . $item->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                            @endif
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
        </script>
    @endpush
@endsection
