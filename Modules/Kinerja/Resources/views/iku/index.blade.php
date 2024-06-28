@extends('adminlte::page')
@section('title', 'Iku')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input
                                id="indexSearch"
                                type="text"
                                name="search"
                                placeholder="Pencarian"
                                value="{{ $search ?? '' }}"
                                class="form-control"
                                autocomplete="off"
                            />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    @can('ikus.show')
                        <a href="{{ route('ikus.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i>Tambah
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">IKU</h4>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="text-left">
                            Tahun
                        </th>
                        <th class="text-left">
                            Nomor
                        </th>
                        <th class="text-left">
                            Sasaran
                        </th>
                        <th class="text-center">
                            Aksi
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($ikus as $iku)
                        <tr>
                            <td>{{ $iku->tahun ?? '-' }}</td>
                            <td>{{ $iku->no }}</td>
                            <td>{{ $iku->sasaran ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('ikus.edit')
                                        <a href="{{ route('ikus.edit', $iku) }}">
                                            <button
                                                type="button"
                                                class="btn btn-light"
                                            >
                                                <i class="icon ion-md-create"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('ikus.show')
                                        <a href="{{ route('ikus.show', $iku) }}">
                                            <button
                                                type="button"
                                                class="btn btn-light"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('ikus.destroy')
                                        <form
                                            action="{{ route('ikus.destroy', $iku) }}"
                                            method="POST"
                                            onsubmit="return confirm('Anda yakin?')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-light text-danger"
                                            >
                                                <i class="icon ion-md-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                @lang('-')
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3">{!! $ikus->render() !!}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
