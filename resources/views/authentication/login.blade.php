<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Guitar Shop</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)),
                url('/images/guitar.png') center center / cover no-repeat fixed;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 35px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;

            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 8px;
            color: white;
        }

        .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
            color: white;
        }

        .login-link,
        .register-link {
            color: white;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #1d4ed8;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: #2563eb;
            text-decoration: none;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 5px;
            font-size: 13px;
            margin-bottom: 18px;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <h2>Guitar Shop</h2>
        <p class="subtitle">Login to your account</p>

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST" id="loginForm">

            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>

                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                    required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" id="loginButton">
                Login
            </button>

        </form>

        <div class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Register here</a>
        </div>

    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function () {
            const button = document.getElementById('loginButton');

            button.disabled = true;
            button.textContent = 'Logging in...';
        });
    </script>

</body>

</html>