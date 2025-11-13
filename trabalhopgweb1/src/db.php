<?php
// src/db.php
require_once __DIR__ . '/../config.php';

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Não exibir detalhes em produção
            die('Erro de conexão com o banco de dados.');
        }
    }
    return $pdo;
}
