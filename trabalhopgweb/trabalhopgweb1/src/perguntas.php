<?php
// src/perguntas.php
require_once __DIR__ . '/db.php';

function fetch_perguntas(): array {
    $pdo = getPDO();
    // CORRIGIDO: Usando 'perguntas'
    $stmt = $pdo->prepare("SELECT id, texto, ordem FROM perguntas WHERE status = TRUE ORDER BY ordem, id");
    $stmt->execute();
    return $stmt->fetchAll();
}