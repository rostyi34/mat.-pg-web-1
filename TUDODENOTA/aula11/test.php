<?php
require_once __DIR__ . '/config.php';

try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "✅ Conexão com o banco PostgreSQL bem-sucedida!";
} catch (PDOException $e) {
    echo "❌ Erro ao conectar: " . $e->getMessage();
}
