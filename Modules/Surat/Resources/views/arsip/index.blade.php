{{-- @extends('surat::layouts.master') --}}
@extends('adminlte::page')
@section('title', 'Arsip Surat')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card">
                    <div class="card-header">
                        Data Arsip Surat
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" style="color: white;" data-bs-toggle="modal" data-bs-target="#modalFilter">
                            <i class="fas fa-filter"> Filter</i>
                        </button>
                    </div>
                </div>
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
                                        <td class="tanggal-surat" data-tanggal="{{ $item->tanggal_surat }}">
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

    <!-- Modal Filter -->
<div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="GET" action="{{ url('/surat/arsip') }}">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFilterLabel">Filter Laporan</h5>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="filterStartDate" class="form-label">Dari Tanggal :</label>
                <input type="date" name="start_date" id="filterStartDate" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="mb-3">
                <label for="filterEndDate" class="form-label">Sampai Tanggal :</label>
                <input type="date" name="end_date" id="filterEndDate" class="form-control" value="{{ request('end_date') }}">
            </div>
        </div>
        <div class="modal-footer">
          <a href="{{ url('/surat/arsip') }}" class="btn btn-secondary">Reset Filter</a>
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </form>
    </div>
  </div>
</div>


    @push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            let table = new DataTable('#tabel_surat');

            function arsip(id) {
            $('#arsip_surat').attr('action', "{{ url('/surat/surat-masuk/arsip') }}" + "/" + id);
        }
            function hapus(id) {
            $('#hapus_surat').attr('action', "{{ url('/surat/surat-masuk/') }}" + "/" + id);
        }

        // document.getElementById('filterStartDate').addEventListener('change', applyLiveFilter);
        // document.getElementById('filterEndDate').addEventListener('change', applyLiveFilter);

        // function applyLiveFilter() {
        //     const startDate = document.getElementById('filterStartDate').value;
        //     const endDate = document.getElementById('filterEndDate').value;

        //     const rows = document.querySelectorAll('#tabel_surat tbody tr');

        //     rows.forEach(row => {
        //         const tanggalCell = row.querySelector('.tanggal-surat');
        //         const tanggalSurat = tanggalCell.getAttribute('data-tanggal'); // format: YYYY-MM-DD
        //         const tanggal = new Date(tanggalSurat);

        //         let show = true;

        //         if (startDate) {
        //             const start = new Date(startDate + 'T00:00:00');
        //             if (tanggal < start) show = false;
        //         }

        //         if (endDate) {
        //             const end = new Date(endDate + 'T23:59:59');
        //             if (tanggal > end) show = false;
        //         }

        //         if (show) {
        //             row.style.display = '';
        //         } else {
        //             row.style.display = 'none';
        //         }
        //     });
        //     document.getElementById('tidakAdaHasil').classList.toggle('d-none', count !== 0);
        // }

        // document.getElementById('resetFilter').addEventListener('click', () => {
        //     document.getElementById('filterStartDate').value = '';
        //     document.getElementById('filterEndDate').value = '';
        //     applyLiveFilter();
        // });
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
