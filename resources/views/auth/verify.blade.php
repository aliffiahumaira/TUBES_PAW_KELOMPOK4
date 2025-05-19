@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifikasi Alamat Email') }}</div>

                <div class="card-body">
                    @if (session('Kirim Ulang'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Link Verifikasi Baru Telah Dikirim ke Alamat Email Anda.') }}
                        </div>
                    @endif
                    {{ __('Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.') }}
                    {{ __('Jika Anda tidak menerima email') }}, <a href="{{ route('verification.resend') }}">{{ __('klik di sini untuk meminta yang lain') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
