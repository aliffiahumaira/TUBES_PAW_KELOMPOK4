<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class SummaryController extends Controller
{
    /**
     * Halaman Ringkasan Bulanan (filter by monthyear)
     * Route name: summary.monthly
     * URL: /summary/monthly?monthyear=YYYY-MM
     */
    public function monthly(Request $request)
    {
        // Ambil parameter monthyear dari URL, default bulan sekarang (format: YYYY-MM)
        $monthyear = $request->input('monthyear', now()->format('Y-m'));

        // Parse tanggal awal dan akhir bulan
        try {
            $startDate = Carbon::parse($monthyear . '-01')->startOfDay();
            $endDate   = Carbon::parse($monthyear . '-01')->endOfMonth()->endOfDay();
        } catch (\Exception $e) {
            // Jika parsing gagal, pakai bulan sekarang
            $startDate = now()->startOfMonth()->startOfDay();
            $endDate   = now()->endOfMonth()->endOfDay();
            $monthyear = now()->format('Y-m');
        }

        // Ambil data income dan expense di rentang tanggal tersebut
        $incomes  = Income::whereBetween('income_date', [$startDate, $endDate])->get();
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->get();

        // Hitung total income dan expense per bulan
        $total_income  = $incomes->sum('income_amount');
        $total_expense = $expenses->sum('expense_amount');
        $balance       = $total_income - $total_expense;

        // Gabungkan data untuk daftar transaksi bulan terpilih
        $results = [];

        foreach ($incomes as $income) {
            $results[] = [
                'type'         => 'income',
                'created_at'   => $income->income_date,
                'income_title' => $income->income_title,
                'income_amount'=> $income->income_amount,
            ];
        }

        foreach ($expenses as $expense) {
            $results[] = [
                'type'           => 'expense',
                'created_at'     => $expense->expense_date,
                'expense_title'  => $expense->expense_title,
                'expense_amount' => $expense->expense_amount,
            ];
        }

        // Urutkan berdasarkan tanggal terbaru
        usort($results, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        // Kirim variabel ke view pages/summarymonthly.blade.php
        return view('pages.summarymonthly', compact(
            'monthyear', 'total_income', 'total_expense', 'balance', 'results'
        ));
    }

    /**
     * Halaman Ringkasan Keseluruhan (tanpa filter tanggal)
     * Route name: summary.all
     * URL: /summary/all
     */
    public function all()
    {
        // Ambil semua income dan expense tanpa filter
        $incomes  = Income::all();
        $expenses = Expense::all();

        // Hitung total keseluruhan
        $total_income_all  = $incomes->sum('income_amount');
        $total_expense_all = $expenses->sum('expense_amount');
        $balance_all       = $total_income_all - $total_expense_all;

        // Gabungkan semua transaksi
        $results_all = [];

        foreach ($incomes as $income) {
            $results_all[] = [
                'type'         => 'income',
                'created_at'   => $income->income_date,
                'income_title' => $income->income_title,
                'income_amount'=> $income->income_amount,
            ];
        }

        foreach ($expenses as $expense) {
            $results_all[] = [
                'type'           => 'expense',
                'created_at'     => $expense->expense_date,
                'expense_title'  => $expense->expense_title,
                'expense_amount' => $expense->expense_amount,
            ];
        }

        // Urutkan berdasarkan tanggal terbaru
        usort($results_all, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        // Kirim variabel ke view pages/summaryall.blade.php
        return view('pages.summaryall', compact(
            'total_income_all', 'total_expense_all', 'balance_all', 'results_all'
        ));
    }
}
