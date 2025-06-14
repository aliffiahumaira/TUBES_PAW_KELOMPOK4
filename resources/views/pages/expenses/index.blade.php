@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Pengeluaran</li>
        </ol>

        <!-- Alert -->
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <i class="fa fa-info mx-2"></i>
                <strong>{!! session('message') !!}</strong>
            </div>
        @endif

        <!-- Summary -->
        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-sm-12 mb-3">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('expenses.create') }}" class="badge badge-primary p-2 mx-auto">Tambahkan Pengeluaran</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Pengeluaran
                        <span class="badge badge-danger badge-pill">{{ formatRupiah($totalExpenses) }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Daftar Pengeluaran -->
        <div class="row">
            @foreach($expenses as $expense)
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d-m-Y') }}</span>
                            <span>
                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="card-body-icon mt-5">
                                <i class="fas fa-fw fa-money-bill"></i>
                            </div>
                            <div>{{ $expense->expense_title }}</div>
                            <div class="font-weight-bold">{{ formatRupiah($expense->expense_amount) }}</div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-xl-12 col-sm-12">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>
@endsection
