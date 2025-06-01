@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Alamat E-Mail') }}</label>
                            <div class="col-md-6">
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="form-group row mt-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                >
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Remember Me --}}
                        <div class="form-group row mt-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                        {{ old('remember') ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="remember">
                                        {{ __('Ingat Saya') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Captcha --}}
                        <div class="form-group row mt-4">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div id="captcha-image">{!! captcha_img('easy') !!}</div>
                                    <button type="button" class="btn btn-secondary ml-3" id="reload">Reload</button>
                                </div>
                                <input
                                    type="text"
                                    class="form-control mt-2"
                                    name="captcha"
                                    placeholder="Masukkan kode CAPTCHA"
                                >
                                @error('captcha')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="form-group row mt-4 mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Lupa Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div> {{-- card-body --}}
            </div> {{-- card --}}
        </div> {{-- col --}}
    </div> {{-- row --}}
</div> {{-- container --}}
@endsection

@push('scripts')
<script type="text/javascript">
    document.getElementById('reload').addEventListener('click', function () {
        fetch('/reload-captcha?config=easy')
            .then(res => res.json())
            .then(data => {
                document.getElementById('captcha-image').innerHTML = data.captcha;
            });
    });
</script>
@endpush
