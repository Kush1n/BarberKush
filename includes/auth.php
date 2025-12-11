<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: /barberkush/login.php");
        exit;
    }
}
