<ul class="sidebar navbar-nav">
    <li class="nav-item {{ Route::currentRouteName() == 'index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'incomes.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('incomes.index') }}">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Pendapatan</span>
        </a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'expenses.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('expenses.index') }}">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Pengeluaran</span>
        </a>
    </li>

    <!-- Tambahkan dropdown atau list untuk Ringkasan -->
    <li class="nav-item dropdown
        {{ in_array(Route::currentRouteName(), ['summary.all', 'summary.monthly']) ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="summaryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-table"></i>
            <span>Ringkasan</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="summaryDropdown">
            <a class="dropdown-item {{ Route::currentRouteName() == 'summary.all' ? 'active' : '' }}" href="{{ route('summary.all') }}">
                Semua Transaksi
            </a>
            <a class="dropdown-item {{ Route::currentRouteName() == 'summary.monthly' ? 'active' : '' }}" href="{{ route('summary.monthly') }}">
                Bulanan
            </a>
        </div>
    </li>

    <li class="nav-item {{ Route::currentRouteName() == 'notes.index' ? 'active' : '' }}" title="This is not calculate in Income/Expense">
        <a class="nav-link" href="{{ route('notes.index') }}">
            <i class="fas fa-fw fa-sticky-note"></i>
            <span>Notes</span>
        </a>
    </li>
</ul>
