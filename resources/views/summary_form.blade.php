<form method="GET" action="{{ route('summary.index') }}">
    <div class="input-group">
        <input type="month" class="form-control" name="monthyear" value="{{ request('monthyear') ?? now()->format('Y-m') }}">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Tampilkan</button>
        </div>
    </div>
</form>
