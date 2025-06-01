@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('expenses.index') }}">Pengeluaran</a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="card mt-4">
                    <div class="card-header">
                        Update Pengeluaran
                    </div>
                    <div class="card-body">
                        <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                            @csrf
                            @method('PUT') {{-- Penting: agar request dianggap PUT oleh Laravel --}}

                            <div class="form-group">
                                <label for="expense_title">Keterangan</label>
                                <input
                                    type="text"
                                    id="expense_title"
                                    name="expense_title"
                                    class="form-control"
                                    placeholder="Keterangan"
                                    required
                                    autofocus
                                    value="{{ old('expense_title', $expense->expense_title) }}"
                                >
                            </div>

                            <div class="form-group">
                                <label for="expense_amount">Jumlah Pengeluaran</label>
                                <input
                                    type="number"
                                    id="expense_amount"
                                    name="expense_amount"
                                    class="form-control"
                                    placeholder="Jumlah Pengeluaran"
                                    step="any"
                                    min="0.01"
                                    required
                                    value="{{ old('expense_amount', $expense->expense_amount) }}"
                                >
                            </div>

                            <div class="form-group">
                                <label for="expense_date">Tanggal</label>
                                <input
                                    type="date"
                                    id="expense_date"
                                    name="expense_date"
                                    class="form-control"
                                    required
                                    value="{{ old('expense_date', $expense->expense_date) }}"
                                >
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('expenses.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
