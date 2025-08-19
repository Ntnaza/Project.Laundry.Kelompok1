<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* CSS untuk tampilan baru */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #4A6BEE; /* Warna biru dari gambar */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: white;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 360px;
            text-align: center;
        }

        .logo-placeholder {
            width: 100px;
            height: 100px;
            background-color: #E0E0E0;
            margin: 0 auto 20px auto;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #9E9E9E;
            font-size: 14px;
        }

        .login-container h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-control:focus {
            outline: none;
            border-color: #4A6BEE;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-check-input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background-color: #4A6BEE;
            color: white;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #3a58d6;
        }

        .invalid-feedback {
            color: #e3342f;
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }
        
        /* CSS BARU UNTUK LINK REGISTER */
        .register-link {
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: #4A6BEE;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="logo-placeholder">
            foto logo
        </div>

        <h1>Welcome!</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <button type="submit" class="btn-login">
                {{ __('Login') }}
            </button>
            
            <!-- HTML BARU UNTUK LINK REGISTER -->
            @if (Route::has('register'))
                <p class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                </p>
            @endif
        </form>
    </div>

</body>
</html>
