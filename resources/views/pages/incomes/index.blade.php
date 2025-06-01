@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Pendapatan</li>
        </ol>

        <!-- Alert Message -->
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <i class="fa fa-primary mx-2"></i>
                <strong>{!! session('message') !!}</strong>
            </div>
        @endif

        <!-- Summary -->
        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-sm-12 mb-3">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-center align-items-center">
                        <a href="{{ route('incomes.create') }}" class="btn btn-primary px-4 py-2">Tambahkan Pendapatan</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Pendapatan
                        <span class="badge badge-success badge-pill">{{ formatRupiah($totalIncomes) }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Pendapatan List -->
        <div class="row">
            @foreach($incomes as $income)
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>{{ \Carbon\Carbon::parse($income->income_date)->format('d-m-Y') }}</span>
                            <div>
                                <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-sm btn-primary mr-1" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus" type="submit">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="card-body-icon mt-5">
                                <i class="fas fa-fw fa-dollar-sign"></i>
                            </div>
                            <div>{{ $income->income_title }}</div>
                            <div class="font-weight-bold">{{ formatRupiah($income->income_amount) }}</div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-12">
                {{ $incomes->links() }}
            </div>
        </div>
    </div>
@endsection
