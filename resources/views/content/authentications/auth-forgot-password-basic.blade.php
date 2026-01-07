@extends('layouts/blankLayout')

@section('title', 'Lupa Password - Materio')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
            <!-- Forgot Password -->
            <div class="card p-sm-7 p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{ url('/') }}" class="app-brand-link gap-3">
                        <span class="app-brand-logo demo">@include('_partials.macros')</span>
                        <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
                    </a>
                </div>
                <!-- /Logo -->
                <div class="card-body mt-1">
                    <h4 class="mb-1">Lupa Password? 🔒</h4>
                    <p class="mb-5">Masukkan email Anda dan kami akan mengirimkan instruksi untuk reset password</p>

                    @if(session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-5" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-5 form-control-validation">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" autofocus required />
                            <label for="email">Email</label>
                        </div>
                        <button class="btn btn-primary d-grid w-100 mb-5" type="submit">Kirim Link Reset</button>
                    </form>

                    <p class="text-center">
                        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center gap-2">
                            <i class="ri-arrow-left-s-line icon-16px"></i>
                            Kembali ke Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection