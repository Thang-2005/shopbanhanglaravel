<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- CSS Modern -->
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3f5efb, #fc466b);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container{
            background: #fff;
            width: 380px;
            padding: 40px 35px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from{ opacity: 0; transform: translateY(10px); }
            to{ opacity: 1; transform: translateY(0); }
        }

        h2{
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }

        .input-box{
            margin-bottom: 18px;
        }

        .input-box input{
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #ccc;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }

        .input-box input:focus{
            border-color: #3f5efb;
            box-shadow: 0 0 8px rgba(63,94,251,0.2);
        }

        .options{
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .btn-login{
            width: 100%;
            background: #3f5efb;
            padding: 14px;
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover{
            background: #324ecf;
        }

        .links{
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
        }

        .links a{
            color: #3f5efb;
            text-decoration: none;
            font-weight: 500;
        }

        .text-alert{
            color: red;
            text-align: center;
            margin-bottom: 10px;
            display: block;
        }

    </style>

</head>
<body>

<div class="login-container">

    <h2>Đăng nhập Admin</h2>

    <?php
        $message = Session::get('message');
        if($message){
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message', null);
        }
    ?>

    <form action="{{ URL::to('/admin-dashboard') }}" method="post">
        {{ csrf_field() }}

        <div class="input-box">
            <input type="text" name="admin_email" placeholder="Email đăng nhập" required>
        </div>

        <div class="input-box">
            <input type="password" name="admin_password" placeholder="Mật khẩu" required>
        </div>

        <div class="options">
            <label><input type="checkbox"> Nhớ mật khẩu</label>
            <a href="#">Quên mật khẩu?</a>
        </div>

        <button type="submit" class="btn-login">Đăng nhập</button>

    </form>

    <div class="links">
        <p><a href="{{ url('/register-auth') }}">Đăng ký tài khoản auth</a></p>
        <p><a href="{{ url('/login-auth') }}">Đăng nhập auth</a></p>
    </div>

</div>

</body>
</html>
