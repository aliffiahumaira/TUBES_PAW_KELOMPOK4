@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Ringkasan Keseluruhan</li>
    </ol>

    <!-- Ringkasan Keseluruhan -->
    <div class="row mb-4">
        <div class="col-xl-6 offset-xl-3 col-sm-12">
            <ul class="list-group">
                <li class="list-group-item d-flex bg-primary text-white justify-content-center align-items-center">
                    Ringkasan Semua Transaksi
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Pendapatan Keseluruhan
                    <span class="badge badge-success badge-pill text-white">{{ formatRupiah($total_income_all) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Pengeluaran Keseluruhan
                    <span class="badge badge-danger badge-pill text-white">{{ formatRupiah($total_expense_all) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Saldo Keseluruhan
                    <span class="badge badge-primary badge-pill text-white">{{ formatRupiah($balance_all) }}</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Daftar Transaksi Keseluruhan -->
    <div class="row">
        @forelse($results_all as $result)
            @php
                $bgColor = 'bg-primary'; // default biru
                if ($result['type'] === 'income') {
                    $bgColor = 'bg-success'; // hijau
                } elseif ($result['type'] === 'expense') {
                    $bgColor = 'bg-danger'; // merah
                }
            @endphp
            <div class="col-xl-4 col-sm-6 mb-3">
                <div class="card text-white {{ $bgColor }} o-hidden h-100">
                    <div class="card-header">
                        <span class="float-left text-white">
                            {{ \Carbon\Carbon::parse($result['created_at'])->format('d-m-Y') }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon mt-5">
                            <i class="fas fa-fw {{ ($result['type'] === 'income') ? 'fa-dollar-sign' : 'fa-money-bill' }}"></i>
                        </div>
                        <div>
                            {{ $result['type'] === 'income' ? $result['income_title'] : $result['expense_title'] }}
                        </div>
                        <div class="font-weight-bold text-white">
                            {{ $result['type'] === 'income' ? formatRupiah($result['income_amount']) : formatRupiah($result['expense_amount']) }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada transaksi sama sekali.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
