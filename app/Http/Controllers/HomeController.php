<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Note;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        // Hitung total pendapatan bulan ini
        $incomes = Income::where('user_id', $userId)
            ->whereYear('income_date', Carbon::now()->year)
            ->whereMonth('income_date', Carbon::now()->month)
            ->sum('income_amount');

        // Hitung total pengeluaran bulan ini
        $expenses = Expense::where('user_id', $userId)
            ->whereYear('expense_date', Carbon::now()->year)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->sum('expense_amount');

        $balance = $incomes - $expenses;

        // Siapkan data cards
        $cards = [
            [
                'color' => 'primary',
                'icon' => 'table',
                'text'  => 'Total',
                'link'  => route('summary.monthly'),
            ],
            [
                'color' => 'success',
                'icon' => 'dollar-sign',
                'text'  => Income::where('user_id', $userId)->count() . ' Pendapatan',
                'link'  => route('incomes.index'),
            ],
            [
                'color' => 'danger',
                'icon' => 'money-bill',
                'text'  => Expense::where('user_id', $userId)->count() . ' Pengeluaran',
                'link'  => route('expenses.index'),
            ],
            [
                'color' => 'info',
                'icon' => 'sticky-note',
                'text'  => Note::where('user_id', $userId)->count() . ' Note',
                'link'  => route('summary.monthly'),
            ],
        ];

        return view('pages.dashboard', compact('incomes', 'expenses', 'balance', 'cards'));
    }
}
