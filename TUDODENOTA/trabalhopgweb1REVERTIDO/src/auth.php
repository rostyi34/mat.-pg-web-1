<?php
require_once __DIR__ . "/db.php";

session_start();

function login($pdo, $usuarioDigitado, $senhaDigitada) {

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE usuario = ?");
    $stmt->execute([$usuarioDigitado]);  // ← AQUI ESTAVA O ERRO

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }

    if (password_verify($senhaDigitada, $user["senha"])) {
        $_SESSION["logado"] = true;
        $_SESSION["usuario"] = $user["usuario"];
        return true;
    }

    return false;
}

function proteger() {
    if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
        header("Location: login.php");
        exit;
    }
}