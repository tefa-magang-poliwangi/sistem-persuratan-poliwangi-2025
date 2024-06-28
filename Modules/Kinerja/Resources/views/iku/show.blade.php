@extends('adminlte::page')
@section('title', 'Iku')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('ikus.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                Detail IKU
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>Tahun</h5>
                    <span>{{ $iku->tahun ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Nomor</h5>
                    <span>{{ $iku->no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Sasaran</h5>
                    <span>{{ $iku->sasaran ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('ikus.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    Kembali
                </a>

                @can('create', App\Models\Iku::class)
                <a href="{{ route('ikus.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
