@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('expenses.index') }}">Pengeluaran</a>
            </li>
            <li class="breadcrumb-item active">Masukkan</li>
        </ol>
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
        @endif
        <div class="row">
            <div class="col-xl-8 offset-2">
                <div class="card mx-auto mt-5">
                    <div class="card-header">Masukkan pengeluaran</div>
                    <div class="card-body">
                        <form action="{{ route('expenses.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" id="expense_title" class="form-control" placeholder="Expense Description" required="required" autofocus="autofocus" name="expense_title">
                                    <label for="expense_title">Keterangan</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="number" step="any" id="expense_amount" min="0.01"  class="form-control" placeholder="Expense Amount" required="required" name="expense_amount">
                                    <label for="expense_amount">Jumlah Pengeluaran</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="date" id="expense_amount" class="form-control" placeholder="Expense Date" required="required" name="expense_date" value="{{ date('Y-m-d') }}">
                                    <label for="expense_amount">Tanggal</label>
                                </div>
                            </div>
                            <div class="float-right">
                                <a href="{{ route('expenses.index') }}" class="btn btn-success">Back</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
