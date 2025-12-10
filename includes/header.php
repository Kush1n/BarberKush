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
            background-color: #1c1c1c;
            padding: px 0;
        }

        .logo-barberkush {
            width: 180px;
            height: auto;
        }

        .navbar-brand-text {
            color: #fff;
            font-size: 1.8rem;
            font-weight: bold;
            margin-left: 10px;
        }

        nav a {
            color: #fff;
            font-weight: 500;
            transition: color 0.2s;
        }

        nav a:hover {
            color: #ffc107;

        @media (max-width: 768px) {
            .navbar-collapse {
                text-align: center;
            }
            .navbar-brand {
                justify-content: center;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                    aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
