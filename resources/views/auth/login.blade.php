@extends('layouts.auth')

@section('title', 'Masuk - Digital Library')

@section('content')
    <div class="login-container">
        <div class="container-fluid">
            <div class="row min-vh-100 justify-content-center align-items-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-card">
                        <!-- Logo dan Header -->
                        <div class="text-center mb-4">
                            <div class="logo-container mb-3">
                                <i class="fas fa-book-open text-primary"></i>
                            </div>
                            <h3 class="login-title">Selamat Datang</h3>
                            <p class="login-subtitle">Masuk ke akun Anda</p>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf

                            <!-- Email Field -->
                            <div class="form-group mb-3">
                                <div class="input-wrapper">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email"
                                        class="form-control custom-input @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Alamat Email" value="{{ old('email') }}"
                                        required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <div class="error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group mb-3">
                                <div class="input-wrapper">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password"
                                        class="form-control custom-input @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Kata Sandi" required
                                        autocomplete="current-password">
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="form-options mb-4">
                                <div class="form-check">
                                    <input class="form-check-input custom-checkbox" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-password">
                                        Lupa kata sandi?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn login-btn w-100 mb-3">
                                <span class="btn-text">Masuk</span>
                                <i class="fas fa-arrow-right btn-icon"></i>
                            </button>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="register-text">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}" class="register-link">
                                        Daftar sekarang
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #375a7f;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --white: #ffffff;
            --gray-100: #f8f9fc;
            --gray-200: #eaecf4;
            --gray-300: #dddfeb;
            --gray-400: #d1d3e2;
            --gray-500: #b7b9cc;
            --gray-600: #858796;
            --gray-700: #6e707e;
            --gray-800: #5a5c69;
            --gray-900: #3a3b45;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
        }

        .login-container {
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1),
                0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color), var(--warning-color));
            border-radius: 20px 20px 0 0;
        }

        .logo-container i {
            font-size: 3.5rem;
            color: var(--primary-color);
            filter: drop-shadow(0 4px 8px rgba(78, 115, 223, 0.3));
        }

        .login-title {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--gray-600);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .form-group {
            position: relative;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--gray-500);
            z-index: 2;
            font-size: 1rem;
        }

        .custom-input {
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            padding: 0.875rem 1rem 0.875rem 3rem;
            font-size: 0.95rem;
            font-weight: 400;
            background: var(--white);
            transition: all 0.3s ease;
            width: 100%;
        }

        .custom-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem rgba(78, 115, 223, 0.15);
            outline: none;
            background: var(--white);
        }

        .custom-input.is-invalid {
            border-color: var(--danger-color);
        }

        .custom-input::placeholder {
            color: var(--gray-500);
            font-weight: 400;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: var(--gray-500);
            cursor: pointer;
            padding: 0.5rem;
            z-index: 2;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .custom-checkbox {
            width: 1.1rem;
            height: 1.1rem;
            border-radius: 4px;
            border: 2px solid var(--gray-400);
        }

        .custom-checkbox:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--gray-700);
            font-size: 0.9rem;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .login-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--white);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .btn-icon {
            transition: transform 0.3s ease;
        }

        .login-btn:hover .btn-icon {
            transform: translateX(4px);
        }

        .register-text {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin: 0;
        }

        .register-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .logo-container i {
                font-size: 3rem;
            }
        }

        @media (max-width: 576px) {
            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }
    </style>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordEye = document.getElementById('password-eye');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordEye.classList.remove('fa-eye');
                passwordEye.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordEye.classList.remove('fa-eye-slash');
                passwordEye.classList.add('fa-eye');
            }
        }
    </script>
@endsection
