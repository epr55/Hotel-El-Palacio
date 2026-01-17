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

        /* Estilos para página de completar reserva */
        .reserva-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .reserva-title {
            font-family: 'Mozilla Headline', sans-serif;
            font-size: 2rem;
            color: #1A1A1A;
            margin-bottom: 30px;
        }

        .reserva-layout {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 30px;
        }

        .card-white {
            background: #FFFFFF;
            border: 1.5px solid #BDC1C7;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1A1A1A;
            margin-bottom: 20px;
        }

        .habitacion-detalle {
            display: flex;
            gap: 20px;
        }

        .habitacion-img {
            width: 150px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }

        .habitacion-img-placeholder {
            width: 150px;
            height: 120px;
            background: linear-gradient(135deg, #DF9E2D 0%, #E15218 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .habitacion-info h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1A1A1A;
            margin-bottom: 10px;
        }

        .habitacion-info p {
            margin: 5px 0;
            color: #4A4A4A;
            font-size: 0.95rem;
        }

        /* Estilos para servicios */
        .servicio-item {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 8px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .servicio-item:hover {
            background-color: #F5F5F5;
        }

        .servicio-checkbox {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            cursor: pointer;
            accent-color: #E15218;
        }

        .servicio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            flex: 1;
            font-size: 0.95rem;
        }

        .servicio-icono {
            font-size: 1.2rem;
        }

        .servicio-nombre {
            font-weight: 500;
            color: #1A1A1A;
        }

        .servicio-precio {
            color: #666;
            font-size: 0.9rem;
        }

        .precio-card {
            position: sticky;
            top: 100px;
        }

        .precio-linea {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.95rem;
            color: #4A4A4A;
        }

        .precio-divider {
            border: none;
            border-top: 1px solid #E0E0E0;
            margin: 16px 0;
        }

        .total-servicios {
            font-weight: 600;
            color: #1A1A1A;
        }

        .precio-total {
            font-size: 1.25rem;
            color: #1A1A1A;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #DF9E2D;
        }

        .btn-confirmar {
            width: 100%;
            background: #E15218;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px;
            margin-top: 20px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-confirmar:hover {
            background: #DC4C18;
        }

        @media (max-width: 768px) {
            .reserva-layout {
                grid-template-columns: 1fr;
            }

            .precio-card {
                position: static;
            }
        }

        footer {
            background-color: #1A1A1A;
            color: #E5E5E5;
            padding: 50px 0 20px;
            font-size: 0.9rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            justify-items: center;
            text-align: center;
        }

        .footer-title {
            font-family: 'Mozilla Headline', sans-serif;
            font-size: 1.1rem;
            color: #D39D55;
            margin-bottom: 15px;
        }

        .footer-text {
            margin-bottom: 8px;
            color: #CCCCCC;
            line-height: 1.5;
        }

        .footer-text:hover {
            color: #FFFFFF;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 8px;
        }

        .footer-links a {
            color: #D4AF37;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #FFFFFF;
        }

        .footer-socials {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }

        .footer-socials a {
            color: #CCCCCC;
            text-decoration: none;
        }


        .footer-socials a:hover {
            color: #FFFFFF;
            text-decoration: none;
        }

        .footer-bottom {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #333;
            text-align: center;
            color: #999;
            font-size: 0.8rem;
        }

        footer .footer-text,
        footer .footer-socials a {
            position: relative;
            cursor: pointer;
            
        }

        footer .footer-text::after,
        footer .footer-socials a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 100%;
            height: 2px;
            background-color: currentColor;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
            
        }

        footer .footer-text:hover::after,
        footer .footer-socials a:hover::after {
            transform: scaleX(1);
            
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
        }

        @media (max-width: 480px) {
            .footer-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-socials {
                align-items: center;
            }
        }

        /* --- Estilos del Desplegable de Usuario --- */
        .user-profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .dropdown-trigger:hover {
            opacity: 0.8;
        }

        .dropdown-trigger span {
            color: #D39D55; 
            font-weight: 500; 
            font-family: 'Mozilla Headline', sans-serif; 
            font-size: 1.25rem;
        }

        .dropdown-trigger img {
            width: 50px; 
            height: 50px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 2px solid #D39D55;
        }

        .profile-menu {
            display: none; /* Oculto por defecto */
            position: absolute; 
            right: 0; 
            top: 100%; 
            background-color: #FFFAF3; 
            min-width: 200px; 
            box-shadow: 0 8px 16px rgba(0,0,0,0.15); 
            border-radius: 12px; 
            border: 1px solid #BDC1C7; 
            z-index: 1000;
            margin-top: 15px;
            overflow: hidden;
        }

        .dropdown-link {
            display: block; 
            padding: 12px 20px; 
            text-decoration: none; 
            color: #1F2937; 
            font-weight: 600;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s, color 0.2s;
        }

        .dropdown-link:hover {
            background-color: #FEF7EC;
            color: #DF9E2D !important;
        }

        .btn-logout-dropdown {
            width: 100%; 
            text-align: left; 
            background: none; 
            border: none; 
            padding: 12px 20px; 
            color: #E15218; 
            font-weight: bold; 
            cursor: pointer;
        }

        .btn-logout-dropdown:hover {
            background-color: #fff5f5;
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
                    <div class="user-profile-dropdown">
                        <div id="profileTrigger" class="dropdown-trigger">
                            <span>{{ Auth::user()->name }}</span>
                            <img src="{{ asset('images/perfil.png') }}" alt="Foto de perfil">
                        </div>

                        <div id="profileMenu" class="profile-menu">
                            <a href="{{ route('perfil') }}" class="dropdown-link">Mis Datos</a>
                            <a href="{{ route('reservas.usuario') }}" class="dropdown-link">Mis Reservas</a>

                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn-logout-dropdown">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"><button>Iniciar Sesión</button></a>
                    <a href="{{ route('registro') }}"><button>Registrarse</button></a>
                @endauth
            </div>
        </div>
    </nav>
    
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
        <div class="container footer-grid">

            <div class="footer-col">
                <h5 class="footer-title">Ayuda</h5>
                <p class="footer-text">Política de Privacidad</p>
                <p class="footer-text">Términos y condiciones</p>
                <p class="footer-text">Trabaja con nosotros</p>
            </div>

            <div class="footer-col">
                <h5 class="footer-title">Contacto</h5>
                <p class="footer-text">Calle Palacio 12, Madrid</p>
                <p class="footer-text">+34 912 345 678</p>
                <p class="footer-text">info@hotelelpacio.com</p>
            </div>

            <div class="footer-col">
                <h5 class="footer-title">Síguenos</h5>
                <div class="footer-socials">
                    <a href="https://facebook.com" target="_blank">Facebook</a>
                    <a href="https://instagram.com" target="_blank">Instagram</a>
                    <a href="https://twitter.com" target="_blank">Twitter</a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            © {{ date('Y') }} Hotel El Palacio · Todos los derechos reservados
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('profileTrigger');
            const menu = document.getElementById('profileMenu');

            if (trigger && menu) {
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
                });

                document.addEventListener('click', function(e) {
                    if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                        menu.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>
