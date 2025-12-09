<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel El Palacio')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #F3F4F6;
            color: #1F2937;
        }

        nav {
            height: 8%;
            background-color: #1A1A1A;
            color:#D4AF37;
        }

        nav button {
            background-color: #1A1A1A;
            color: #D4AF37;
            border: 1px solid #D4AF37;
            border-radius: 20px;
            padding: 5px 15px;
            font-weight: 600;
        }

        nav button:hover {
            background-color: #D4AF37;
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
                <button>Iniciar Sesion</button>
                <button>Registrarse</button>
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
