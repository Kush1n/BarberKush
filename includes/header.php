<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>BarberKush</title>

    <link rel="stylesheet" href="/barberkush/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>


        header {
            background: linear-gradient(90deg, #111, #1b1b1b);
            padding: 10px 0;
            border-bottom: 1px solid #2a2a2a;
            box-shadow: 0 4px 12px rgba(0,0,0,0.45);
        }

        .logo-barberkush {
            width: 150px;
            height: auto;
            transition: transform .25s ease;
        }

        .logo-barberkush:hover {
            transform: scale(1.05);
        }

        .navbar-brand-text {
            color: #fff;
            font-size: 1.7rem;
            font-weight: 700;
            margin-left: 12px;
            letter-spacing: 0.6px;
        }

        nav a.nav-link {
            color: #e8e8e8;
            font-weight: 500;
            margin-left: 20px;
            padding-bottom: 3px;
            position: relative;
            transition: color .25s ease;
        }

        nav a.nav-link:hover {
            color: #f0c14b;
        }

        nav a.nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 0%;
            height: 2px;
            background: #f0c14b;
            transition: width .25s ease;
        }

        nav a.nav-link:hover::after {
            width: 100%;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        @media (max-width: 768px) {

            .navbar-brand {
                width: 100%;
                justify-content: center;
                margin-bottom: 10px;
            }

            nav a.nav-link {
                margin: 10px 0;
                font-size: 1.2rem;
            }

            .navbar-collapse {
                background: #111;
                padding: 15px 0;
                border-radius: 8px;
                border: 1px solid #2a2a2a;
                margin-top: 10px;
            }
        }

    </style>
</head>

<body>

<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark p-0">

            <a class="navbar-brand d-flex align-items-center" href="/barberkush/index.php">
                <img src="/barberkush/img/logo1.png" alt="BarberKush Logo" class="logo-barberkush">
                <span class="navbar-brand-text">BarberKush</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/barberkush/index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/barberkush/pages/clientes/">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="/barberkush/pages/barbeiros/">Barbeiros</a></li>
                    <li class="nav-item"><a class="nav-link" href="/barberkush/pages/servicos/">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link" href="/barberkush/pages/agendamentos/">Agendamentos</a></li>
                </ul>
            </div>

        </nav>
    </div>
</header>

<main class="container mt-4">
