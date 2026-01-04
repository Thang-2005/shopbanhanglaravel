<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Admin Panel</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 20px 0;
        }

        /* Animated background particles */
        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: float 15s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .register-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 35px 30px;
            text-align: center;
            color: white;
        }

        .register-header i {
            font-size: 45px;
            margin-bottom: 15px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .register-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .register-header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .register-body {
            padding: 35px 35px 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 16px;
            z-index: 1;
        }

        .form-control {
            width: 100%;
            padding: 13px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
            z-index: 1;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            border: 2px solid #667eea;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0 20px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider span {
            padding: 0 15px;
            color: #999;
            font-size: 13px;
        }

        .social-register {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn-social {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-social i {
            font-size: 18px;
        }

        .btn-google {
            color: #db4437;
        }

        .btn-google:hover {
            border-color: #db4437;
            background: #fff5f5;
        }

        .btn-facebook {
            color: #1877f2;
        }

        .btn-facebook:hover {
            border-color: #1877f2;
            background: #f0f8ff;
        }

        .register-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .register-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-footer a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
            border: none;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
        }

        .alert-danger div {
            margin: 3px 0;
        }

        .alert-success {
            background: #efe;
            color: #3c3;
        }

        .password-strength {
            margin-top: 5px;
            height: 4px;
            background: #eee;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
        }

        .strength-weak { width: 33%; background: #f44336; }
        .strength-medium { width: 66%; background: #ff9800; }
        .strength-strong { width: 100%; background: #4caf50; }

        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 8px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .password-requirements div {
            margin: 3px 0;
        }

        .requirement-met {
            color: #4caf50;
        }

        .requirement-not-met {
            color: #999;
        }

        @media (max-width: 576px) {
            .register-container {
                padding: 15px;
            }

            .register-header {
                padding: 30px 20px;
            }

            .register-body {
                padding: 30px 25px 25px;
            }

            .register-header h2 {
                font-size: 24px;
            }

            .social-register {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-card">
        <!-- Header -->
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>Đăng Ký</h2>
            <p>Tạo tài khoản quản trị mới</p>
        </div>

        <!-- Body -->
        <div class="register-body">
            <!-- Hiển thị lỗi validate -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Thông báo thành công -->
            @if(session('message'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" id="registerForm">
                @csrf
                
                <!-- Họ tên -->
                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user"></i> Họ và tên
                    </label>
                    <div class="input-group-custom">
                        <i class="fas fa-user"></i>
                        <input type="text" 
                               class="form-control" 
                               id="name" 
                               name="admin_name" 
                               value="{{ old('admin_name') }}" 
                               placeholder="Nguyễn Văn A" 
                               required>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope"></i>
                        <input type="email" 
                               class="form-control" 
                               id="email" 
                               name="admin_email" 
                               value="{{ old('admin_email') }}" 
                               placeholder="example@email.com" 
                               required>
                    </div>
                </div>

                <!-- Số điện thoại -->
                <div class="form-group">
                    <label for="phone">
                        <i class="fas fa-phone"></i> Số điện thoại
                    </label>
                    <div class="input-group-custom">
                        <i class="fas fa-phone"></i>
                        <input type="text" 
                               class="form-control" 
                               id="phone" 
                               name="admin_phone" 
                               value="{{ old('admin_phone') }}" 
                               placeholder="0912345678" 
                               required>
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Mật khẩu
                    </label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="admin_password" 
                               placeholder="••••••••" 
                               required>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                    <div class="password-strength" id="passwordStrength">
                        <div class="password-strength-bar"></div>
                    </div>
                    <div class="password-requirements" id="passwordRequirements">
                        <div id="req-length" class="requirement-not-met">
                            <i class="fas fa-circle"></i> Tối thiểu 8 ký tự
                        </div>
                        <div id="req-uppercase" class="requirement-not-met">
                            <i class="fas fa-circle"></i> Có chữ hoa
                        </div>
                        <div id="req-number" class="requirement-not-met">
                            <i class="fas fa-circle"></i> Có số
                        </div>
                    </div>
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-lock"></i> Xác nhận mật khẩu
                    </label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="admin_password_confirmation" 
                               placeholder="••••••••" 
                               required>
                        <i class="fas fa-eye password-toggle" id="togglePasswordConfirm"></i>
                    </div>
                </div>

                <!-- Remember me -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">
                        Tôi đồng ý với <a href="#" style="color: #667eea;">Điều khoản dịch vụ</a> và <a href="#" style="color: #667eea;">Chính sách bảo mật</a>
                    </label>
                </div>

                <!-- Nút đăng ký -->
                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Đăng ký
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>Hoặc đăng ký với</span>
            </div>

            <!-- Social Register -->
            <div class="social-register">
                <button class="btn-social btn-google">
                    <i class="fab fa-google"></i>
                    Google
                </button>
                <button class="btn-social btn-facebook">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </button>
            </div>

            <!-- Footer -->
            <div class="register-footer">
                <p style="color: #666; font-size: 14px;">
                    Đã có tài khoản? 
                    <a href="{{ url('/login-auth') }}">Đăng nhập ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const icon = this;
        
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const password = document.getElementById('password_confirmation');
        const icon = this;
        
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Password strength checker
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.querySelector('.password-strength-bar');
        
        let strength = 0;
        
        // Check length
        const reqLength = document.getElementById('req-length');
        if (password.length >= 8) {
            strength++;
            reqLength.classList.remove('requirement-not-met');
            reqLength.classList.add('requirement-met');
            reqLength.querySelector('i').classList.remove('fa-circle');
            reqLength.querySelector('i').classList.add('fa-check-circle');
        } else {
            reqLength.classList.remove('requirement-met');
            reqLength.classList.add('requirement-not-met');
            reqLength.querySelector('i').classList.remove('fa-check-circle');
            reqLength.querySelector('i').classList.add('fa-circle');
        }
        
        // Check uppercase
        const reqUppercase = document.getElementById('req-uppercase');
        if (/[A-Z]/.test(password)) {
            strength++;
            reqUppercase.classList.remove('requirement-not-met');
            reqUppercase.classList.add('requirement-met');
            reqUppercase.querySelector('i').classList.remove('fa-circle');
            reqUppercase.querySelector('i').classList.add('fa-check-circle');
        } else {
            reqUppercase.classList.remove('requirement-met');
            reqUppercase.classList.add('requirement-not-met');
            reqUppercase.querySelector('i').classList.remove('fa-check-circle');
            reqUppercase.querySelector('i').classList.add('fa-circle');
        }
        
        // Check number
        const reqNumber = document.getElementById('req-number');
        if (/[0-9]/.test(password)) {
            strength++;
            reqNumber.classList.remove('requirement-not-met');
            reqNumber.classList.add('requirement-met');
            reqNumber.querySelector('i').classList.remove('fa-circle');
            reqNumber.querySelector('i').classList.add('fa-check-circle');
        } else {
            reqNumber.classList.remove('requirement-met');
            reqNumber.classList.add('requirement-not-met');
            reqNumber.querySelector('i').classList.remove('fa-check-circle');
            reqNumber.querySelector('i').classList.add('fa-circle');
        }
        
        // Update strength bar
        strengthBar.className = 'password-strength-bar';
        if (strength === 1) {
            strengthBar.classList.add('strength-weak');
        } else if (strength === 2) {
            strengthBar.classList.add('strength-medium');
        } else if (strength === 3) {
            strengthBar.classList.add('strength-strong');
        }
    });

    // Form submit animation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const btn = document.querySelector('.btn-register');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        btn.disabled = true;
    });
</script>

</body>
</html>