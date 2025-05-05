@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop
@section('content')
<div class="row mt-5">
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Surat Memerlukan Disposisi</div>
            <div class="card-body d-flex">
                <i class="fas fa-envelope fa-2x"></i>
                <h5 class="card-title" style="font-size: 25px;margin-left: 10px">{{ $disposisi }} Surat</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Surat Selesai</div>
            <div class="card-body d-flex">
                <i class="fas fa-envelope fa-2x"></i>
                <h5 class="card-title" style="font-size: 25px;margin-left: 10px">{{ $selesai }} Surat</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary mb-3">
            <div class="card-header">Surat Diarsipkan</div>
            <div class="card-body d-flex">
                <i class="fas fa-envelope fa-2x"></i>
                <h5 class="card-title" style="font-size: 25px;margin-left: 10px">{{ $arsip }} Surat</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-dark mb-3">
            <div class="card-header">Total Surat</div>
            <div class="card-body d-flex">
                <i class="fas fa-envelope fa-2x"></i>
                <h5 class="card-title" style="font-size: 25px;margin-left: 10px">{{ $jumlahSuratMasuk }} Surat</h5>
            </div>
        </div>
    </div>
</div>
@endsection