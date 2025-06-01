@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Ringkasan Bulanan</li>
    </ol>

    <!-- Form Pilih Bulan -->
    <div class="row mb-4">
        <div class="col-xl-4 offset-xl-4">
            <form method="GET" action="{{ route('summary.monthly') }}">
                <div class="input-group">
                    <input type="month"
                           class="form-control"
                           name="monthyear"
                           value="{{ $monthyear ?? now()->format('Y-m') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Ringkasan Bulanan -->
    <div class="row mb-4">
        <div class="col-xl-6 offset-xl-3 col-sm-12">
            <ul class="list-group">
                <li class="list-group-item d-flex bg-info text-white justify-content-center align-items-center">
                    Ringkasan Bulan {{ \Carbon\Carbon::parse($monthyear . '-01')->format('F Y') }}
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Pendapatan
                    <span class="badge badge-primary badge-pill text-white">{{ formatRupiah($total_income) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Pengeluaran
                    <span class="badge badge-danger badge-pill text-white">{{ formatRupiah($total_expense) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Saldo
                    <span class="badge badge-primary badge-pill text-white">{{ formatRupiah($balance) }}</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Daftar Transaksi Bulan Terpilih -->
    <div class="row">
        @forelse($results as $result)
            <div class="col-xl-4 col-sm-6 mb-3">
                <div class="card text-white {{ ($result['type'] == 'income') ? 'bg-info' : 'bg-danger' }} o-hidden h-100">
                    <div class="card-header">
                        <span class="float-left text-white">
                            {{ \Carbon\Carbon::parse($result['created_at'])->format('d-m-Y') }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon mt-5">
                            <i class="fas fa-fw {{ ($result['type'] == 'income') ? 'fa-dollar-sign' : 'fa-money-bill' }}"></i>
                        </div>
                        <div>
                            {{ $result['type'] == 'income' ? $result['income_title'] : $result['expense_title'] }}
                        </div>
                        <div class="font-weight-bold text-white">
                            {{ $result['type'] == 'income' ? formatRupiah($result['income_amount']) : formatRupiah($result['expense_amount']) }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada transaksi untuk bulan ini.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
