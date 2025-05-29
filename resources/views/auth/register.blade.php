@extends('layouts.auth')

@section('title', 'Daftar - Digital Library')

@section('content')
    <div class="register-container">
        <div class="container-fluid">
            <div class="row min-vh-100 justify-content-center align-items-center">
                <div class="col-md-8 col-lg-5">
                    <div class="register-card">
                        <!-- Logo dan Header -->
                        <div class="text-center mb-4">
                            <div class="logo-container mb-3">
                                <i class="fas fa-book-open text-primary"></i>
                            </div>
                            <h3 class="register-title">Bergabung dengan Kami</h3>
                            <p class="register-subtitle">Buat akun Digital Library Anda</p>
                        </div>

                        <!-- Register Form -->
                        <form method="POST" action="{{ route('register') }}" class="register-form">
                            @csrf

                            <!-- Name Field -->
                            <div class="form-group mb-3">
                                <div class="input-wrapper">
                                    <i class="fas fa-user input-icon"></i>
                                    <input type="text"
                                        class="form-control custom-input @error('name') is-invalid @enderror" id="name"
                                        name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required
                                        autocomplete="name" autofocus>
                                </div>
                                @error('name')
                                    <div class="error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="form-group mb-3">
                                <div class="input-wrapper">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email"
                                        class="form-control custom-input @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Alamat Email" value="{{ old('email') }}"
                                        required autocomplete="email">
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
                                        autocomplete="new-password">
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="password-strength mb-3" id="password-strength" style="display: none;">
                                <div class="strength-meter">
                                    <div class="strength-meter-fill" id="strength-meter-fill"></div>
                                </div>
                                <small class="strength-text" id="strength-text"></small>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group mb-3">
                                <div class="input-wrapper">
                                    <i class="fas fa-shield-alt input-icon"></i>
                                    <input type="password"
                                        class="form-control custom-input @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Konfirmasi Kata Sandi" required autocomplete="new-password">
                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-check-wrapper mb-3">
                                <div class="form-check">
                                    <input class="form-check-input custom-checkbox @error('terms') is-invalid @enderror"
                                        type="checkbox" name="terms" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Saya menyetujui <a href="#" class="terms-link">Syarat & Ketentuan</a>
                                        dan <a href="#" class="terms-link">Kebijakan Privasi</a>
                                    </label>
                                </div>
                                @error('terms')
                                    <div class="error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Newsletter Subscription (Optional) -->
                            <div class="form-check-wrapper mb-4">
                                <div class="form-check">
                                    <input class="form-check-input custom-checkbox" type="checkbox" name="newsletter"
                                        id="newsletter" checked>
                                    <label class="form-check-label" for="newsletter">
                                        Saya ingin menerima rekomendasi buku dan update terbaru
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn register-btn w-100 mb-3">
                                <span class="btn-text">Buat Akun</span>
                                <i class="fas fa-user-plus btn-icon"></i>
                            </button>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="login-text">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}" class="login-link">
                                        Masuk sekarang
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

        .register-container {
            position: relative;
            overflow: hidden;
            padding: 2rem 0;
        }

        .register-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="60" cy="30" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="70" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="20" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            animation: float 25s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-15px) rotate(120deg);
            }

            66% {
                transform: translateY(-10px) rotate(240deg);
            }
        }

        .register-card {
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

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--success-color), var(--primary-color), var(--info-color));
            border-radius: 20px 20px 0 0;
        }

        .logo-container i {
            font-size: 3.5rem;
            color: var(--primary-color);
            filter: drop-shadow(0 4px 8px rgba(78, 115, 223, 0.3));
        }

        .register-title {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
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

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-meter {
            height: 4px;
            background-color: var(--gray-300);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .strength-meter-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-text {
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Form Check Styling */
        .form-check-wrapper {
            position: relative;
        }

        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .custom-checkbox {
            width: 1.1rem;
            height: 1.1rem;
            border-radius: 4px;
            border: 2px solid var(--gray-400);
            margin-top: 0.1rem;
            flex-shrink: 0;
        }

        .custom-checkbox:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--gray-700);
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.4;
        }

        .terms-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .terms-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .register-btn {
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

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(28, 200, 138, 0.4);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .btn-icon {
            transition: transform 0.3s ease;
        }

        .register-btn:hover .btn-icon {
            transform: translateX(4px);
        }

        .login-text {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin: 0;
        }

        .login-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .register-card {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }

            .register-title {
                font-size: 1.5rem;
            }

            .logo-container i {
                font-size: 3rem;
            }
        }

        @media (max-width: 576px) {
            .register-container {
                padding: 1rem 0;
            }

            .register-card {
                padding: 1.5rem 1rem;
            }
        }
    </style>

    <script>
        // Password Toggle Function
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const passwordEye = document.getElementById(fieldId + '-eye');

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

        // Password Strength Checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('password-strength');
            const strengthFill = document.getElementById('strength-meter-fill');
            const strengthText = document.getElementById('strength-text');

            if (password.length === 0) {
                strengthMeter.style.display = 'none';
                return;
            }

            strengthMeter.style.display = 'block';

            let strength = 0;
            let feedback = [];

            // Length check
            if (password.length >= 8) strength += 1;
            else feedback.push('minimal 8 karakter');

            // Lowercase check
            if (password.match(/[a-z]/)) strength += 1;
            else feedback.push('huruf kecil');

            // Uppercase check
            if (password.match(/[A-Z]/)) strength += 1;
            else feedback.push('huruf besar');

            // Number check
            if (password.match(/[0-9]/)) strength += 1;
            else feedback.push('angka');

            // Special character check
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
            else feedback.push('karakter khusus');

            // Update strength meter
            const percentage = (strength / 5) * 100;
            strengthFill.style.width = percentage + '%';

            // Update color and text
            if (strength <= 2) {
                strengthFill.style.backgroundColor = '#dc3545';
                strengthText.textContent = 'Lemah - Tambahkan: ' + feedback.join(', ');
                strengthText.className = 'strength-text text-danger';
            } else if (strength <= 3) {
                strengthFill.style.backgroundColor = '#ffc107';
                strengthText.textContent = 'Sedang - Tambahkan: ' + feedback.join(', ');
                strengthText.className = 'strength-text text-warning';
            } else if (strength <= 4) {
                strengthFill.style.backgroundColor = '#28a745';
                strengthText.textContent = 'Kuat';
                strengthText.className = 'strength-text text-success';
            } else {
                strengthFill.style.backgroundColor = '#28a745';
                strengthText.textContent = 'Sangat Kuat';
                strengthText.className = 'strength-text text-success';
            }
        });

        // Confirm Password Matching
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    this.style.borderColor = 'var(--success-color)';
                } else {
                    this.style.borderColor = 'var(--danger-color)';
                }
            } else {
                this.style.borderColor = 'var(--gray-300)';
            }
        });
    </script>
@endsection
