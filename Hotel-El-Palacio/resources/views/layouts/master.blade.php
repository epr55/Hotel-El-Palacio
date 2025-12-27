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
            margin-top: 14px;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #BDC1C7;
            border-radius: 8px;
            margin-bottom: 14px;
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
            margin-top: 14px;
            font-weight: 600;
        }

        .btn-cancel {
            width: 100%;
            background: #B3B3B3;
            color: #333;
            border: none;
            border-radius: 8px;
            padding: 12px;
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
            align-items: center;
            gap: 8px;
            margin: 10px 0 20px;
            font-size: 14px;
        }

        .row-2-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

    </style>

</head>

<body>

    <nav class="navbar">
        <div class="container">
            <div class="logo">
                HOTEL EL PALACIO
            </div>
            <div class="navegacion">
                <a>Inicio</a>
                <a>Habitaciones</a>
                <a>Servicios</a>
            </div>
            <div class="sesion">
                <a href="{{ route('login') }}">
                    <button>Iniciar Sesión</button>
                </a>
                <a href="{{ route('registro') }}">
                    <button>Registrarse</button>
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        @yield('content')
    </div>

    <footer>
        <div class="container">
            
        </div>
    </footer>
</body>
</html>
