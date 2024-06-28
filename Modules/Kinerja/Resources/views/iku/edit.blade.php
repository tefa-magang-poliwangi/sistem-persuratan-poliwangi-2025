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
                Edit
            </h4>

            <x-form
                method="PUT"
                action="{{ route('ikus.update', $iku) }}"
                class="mt-4"
            >
                @include('kinerja::iku.form-inputs')

                <div class="mt-4">
                    <a href="{{ route('ikus.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        Kembali
                    </a>

                    <a href="{{ route('ikus.create') }}" class="btn btn-light">
                        <i class="icon ion-md-add text-primary"></i>
                        Tambah
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        Update
                    </button>
                </div>
            </x-form>


        </div>
    </div>
</div>
@endsection
