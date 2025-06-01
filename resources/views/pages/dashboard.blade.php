@extends('layouts.master')

@section('content')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
    </ol>

    <div class="row">
        <div class="col-xl-6 offset-xl-3 col-sm-12 mb-3">
            <ul class="list-group">
                <!-- Ganti bg-info ke bg-primary -->
                <li class="list-group-item bg-primary text-center text-white">
                    <span>Biaya Bulan Ini</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Pendapatan
                    <span class="badge badge-success badge-pill text-white">{{ formatRupiah($incomes) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Pengeluaran
                    <span class="badge badge-danger badge-pill text-white">{{ formatRupiah($expenses) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Saldo
                    <span class="badge badge-primary badge-pill text-white">{{ formatRupiah($balance) }}</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Icon Cards -->
    <div class="row">
        @php
            $cards = [
                ['color' => 'primary', 'icon' => 'table', 'text' => 'Total', 'link' => route('notes.index')],
                ['color' => 'success', 'icon' => 'dollar-sign', 'text' => App\Models\Income::where('user_id', Auth::user()->id)->count() . ' Pendapatan', 'link' => route('incomes.index')],
                ['color' => 'danger', 'icon' => 'money-bill', 'text' => App\Models\Expense::where('user_id', Auth::user()->id)->count() . ' Pengeluaran', 'link' => route('expenses.index')],
                ['color' => 'info', 'icon' => 'sticky-note', 'text' => App\Models\Note::where('user_id', Auth::user()->id)->count() . ' Note', 'link' => route('notes.index')],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-{{ $card['color'] }} o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-{{ $card['icon'] }}"></i>
                        </div>
                        <div class="mr-5">{{ $card['text'] }}</div>
                    </div>
                    <a class="nav-link text-white text-center card-footer clearfix small z-1" href="{{ $card['link'] }}">
                        <span class="float-left">Lihat Semua</span>
                        <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Chart -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-pie"></i>
                    Pendapatan Vs Pengeluaran
                    <small class="badge badge-primary">(Data Bulan Ini)</small>
                </div>
                <div class="card-body">
                    <canvas id="incomeExpenseChart" width="100%" height="30"></canvas>
                </div>
                <div class="card-footer small text-muted">Diperbarui Kemarin pada 23:59</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('dashboard/vendor/chart/chart.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    // Format Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + angka.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, '.').replace('.', ',');
    }

    // Income Expense Pie Chart
    var ctx = document.getElementById("incomeExpenseChart");
    var income = {{ $incomes }};
    var expense = {{ $expenses }};

    var incomeExpenseChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Pendapatan", "Pengeluaran"],
            datasets: [{
                data: [income, expense],
                backgroundColor: ['#28a745', '#dc3545'], // Hijau dan Merah
            }],
        },
        options: {
            plugins: {
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    formatter: function(value) {
                        return formatRupiah(value);
                    }
                }
            }
        }
    });
</script>
@endpush
