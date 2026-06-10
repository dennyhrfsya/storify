@extends('layouts.login')
@section('title', 'Login')

@section('content')
    <div class="dx-container">

        <!-- Konten bagian kiri -->
        <div class="dx-min-h-screen bg-white dx-px-6 dx-py-5 dx-left-content">
            <a href="#"
                class="d-flex align-items-center dx-mb-30 dx-text-sm hover:dx-no-underline dx-text-biru hover:dx-text-biru-muda dx-no-underline">
            </a>
            <h3 class="dx-text-biru dx-text-lg dx-font-bold dx-mb-4">Login</h3>
            <p class="dx-text-biru dx-mb-10">Masuk dengan menggunakan email dan password anda</p>
            <form method="POST" action="{{ route('login') }}" autocomplete="off" novalidate id="login-form">
                @csrf
                <div class="dx-mb-4 dx-shadow">
                    <div class="position-relative">
                        <input type="email" id="email" name="email" class="dx-form-input dx-input"
                            value="{{ old('email') }}" placeholder="Masukan email" required autofocus>
                        <label class="dx-form-label">Email</label>
                    </div>
                    <div class="position-relative">
                        <div class="position-relative">
                            <input type="password" id="password" name="password"
                                class="form-password dx-form-password dx-input" placeholder="Masukkan password" required>
                            <label class="dx-form-label">Password</label>
                        </div>
                        <img src="{{ asset('images/eye-slash.svg') }}" id="icon-login" alt="" class="dx-icon-eye">
                    </div>
                </div>
                <div class="dx-mb-5 dx-min-height-4">

                    @error('email')
                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                    @enderror
                    @error('password')
                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                    @enderror

                    <div class="dx-mt-4 d-flex justify-content-between">
                        <div class="position-relative dx-text-xs dx-text-abu-abu dx-checkbox">
                            <input id="icon-login" type="checkbox" name="remember">
                            <label>
                                Ingat saya
                            </label>
                        </div>
                        <a href="#"
                            class="dx-text-xs dx-text-biru hover:dx-text-biru-muda hover:dx-no-underline dx-no-underline">Lupa
                            password?</a>
                    </div>
                    <div class="dx-my-4">
                        <button type="submit" id="btn-login" class="dx-btn dx-btn-primary dx-mr-4">
                            <span id="btn-text">Login</span>
                            <span id="btn-loader" class="dx-loader"></span>
                        </button>

                        <button type="reset" id="btn-reset" class="dx-btn dx-btn-secondary">Reset</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Konten bagian kanan -->
        <div class="dx-right-content">
            <div class="dx-login-background"></div>
        </div>

    </div>
    @push('scripts')
        <script src="{{ asset('js/javascript-icon-password.js') }}"></script>
        @vite('resources/js/pages/login.js')
    @endpush
@endsection
