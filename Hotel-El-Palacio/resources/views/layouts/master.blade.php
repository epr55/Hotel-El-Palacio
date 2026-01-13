<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel El Palacio')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mozilla+Headline:wght@400;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #FEF7EC;
            color: #1F2937;
        }

        nav {
            height: 8%;
            background-color: #FEF7EC;
            color:#D39D55;
            box-shadow: 0 3px 10px rgba(0,0,0,0.28);
            display: flex;
            align-items: center;
        }

        nav button {
            background-color: #FFFFFF;
            color: #D39C2F;
            border: 1px solid #D39C2F;
            border-radius: 20px;
            padding: 5px 15px;
            font-weight: 600;
        }

        nav button:hover {
            background-color: #DC4C18;
            color: #1A1A1A;
        }

        footer {
            margin-top: auto;
            background-color: #1A1A1A;
            padding: 40px 0;
            color: #FFFFFF;
        }

        footer a {
            text-decoration: none;
            color: #D4AF37;
        }

        footer a:hover {
            color: #FFFFFF;
            text-decoration: underline;
        }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 90px);
        }

        .login-box {
            width: 420px;
            background: #FFFAF3;
            border: 1.5px solid #BDC1C7;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .login-title {
            text-align: center;
            color: #DF9E2D;
            margin-bottom: 20px;
            font-family: 'Mozilla Headline', sans-serif;
            font-weight: 700;
        }

        .login-box label {
            font-size: 14px;
            font-weight: 600;
            margin-top: 8px;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #BDC1C7;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .forgot {
            font-size: 13px;
            color: #00AEEF;
            text-decoration: none;
        }

        .btn-login-main {
            width: 100%;
            background: #E15218;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            margin-top: 8px;
            font-weight: 600;
        }

        .btn-cancel {
            width: 100%;
            background: #B3B3B3;
            color: #333;
            border: none;
            border-radius: 8px;
            padding: 8px;
            margin-top: 10px;
        }

        .register-text {
            text-align: center;
            margin-top: 14px;
            font-size: 14px;
        }
        
        .register-box {
            width: 500px;
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .row-2 input {
            margin-bottom: 14px;
        }

        .terms {
            display: flex;
            align-items: baseline;
            justify-content: flex-start;
            gap: 8px;
            margin: 4px 0 12px;
            font-size: 14px;
        }

        .terms input[type="checkbox"] {
            width: auto;
            margin: 0;
            flex-shrink: 0;
            vertical-align: middle;
        }

        .row-2-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .navbar-left img.logo-img {
            height: 60px;
            width: auto;
        }

        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Mozilla Headline', sans-serif;
            font-weight: 700;
            font-size: 38px;
            color: #DF9E2D;
        }

        .navbar-right button {
            background-color: #E15218;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 16px;
            font-weight: 600;
        }

        .navbar-right button:hover {
            background-color: #DC4C18;
            color: #fff;
        }

        /* Estilos para errores de validación */
        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            color: #842029;
        }

        .alert ul {
            padding-left: 20px;
            margin: 0;
        }

        .text-danger {
            color: #dc3545;
            display: block;
            margin-top: -6px;
            margin-bottom: 8px;
        }

        .small {
            font-size: 12px;
        }

        input.is-invalid {
            border-color: #dc3545 !important;
            background-color: #fff5f5;
        }

        input.is-invalid:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
        }

        /* Estilos para mensajes de éxito */
        .alert-success {
            background-color: #d1e7dd;
            border: 1px solid #badbcc;
            color: #0f5132;
        }

        .alert-info {
            background-color: #cff4fc;
            border: 1px solid #b6effb;
            color: #055160;
        }

        .flash-message {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

    </style>

</head>

<body>

    <nav class="navbar">
        <div class="container">
            <div class="navbar-left">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            </div>

            <a href="{{ route('home') }}" class="navbar-center" style="text-decoration: none; color: inherit;">
                Hotel El Palacio
            </a>

            <div class="navbar-right d-flex align-items-center gap-3">
                @auth
                    <a href="{{ route('perfil') }}" style="text-decoration: none;">
                        <span style="
                            color: #D39D55; 
                            font-weight: 500; 
                            font-family: 'Mozilla Headline', sans-serif; 
                            font-size: 1.25rem;
                            cursor: pointer;
                        ">
                            {{ Auth::user()->name }}
                        </span>
                    
                        <img src="{{ asset('images/perfil.png') }}" alt="Foto de perfil" 
                            style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-logout btn btn-outline-danger btn-sm">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">
                        <button>Iniciar Sesión</button>
                    </a>
                    <a href="{{ route('registro') }}">
                        <button>Registrarse</button>
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Mensajes flash -->
    @if (session('success'))
        <div class="flash-message alert alert-success" role="alert">
            <strong>✓ Éxito!</strong> {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.flash-message').style.opacity = '0';
                setTimeout(() => document.querySelector('.flash-message').remove(), 300);
            }, 4000);
        </script>
    @endif

    @if (session('error'))
        <div class="flash-message alert alert-danger" role="alert">
            <strong>✗ Error!</strong> {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.flash-message').style.opacity = '0';
                setTimeout(() => document.querySelector('.flash-message').remove(), 300);
            }, 4000);
        </script>
    @endif
    
    <div class="container">
        @yield('content')
    </div>

    <footer>
        <div class="container">
            
        </div>
    </footer>
</body>
</html>
