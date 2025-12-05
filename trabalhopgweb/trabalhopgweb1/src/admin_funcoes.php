<?php
// src/admin_funcoes.php - Revertido para usar tabelas auxiliares no SINGULAR
require_once __DIR__ . "/db.php"; 
$pdo = getPDO();

/* ============================================================
   FUNÇÕES INTERNAS DO ADMIN
   ============================================================ */

/* ---------- PERGUNTAS ---------- */

function listar_perguntas($pdo) {
    // REVERTIDO: Usando 'pergunta' (singular)
    return $pdo->query("SELECT * FROM pergunta ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
}

function adicionar_pergunta($pdo, $texto) {
    // REVERTIDO: Usando 'pergunta' (singular)
    $stmt = $pdo->prepare("INSERT INTO pergunta (texto) VALUES (?)");
    $stmt->execute([$texto]);
}

function obter_pergunta($pdo, $id) {
    // REVERTIDO: Usando 'pergunta' (singular)
    $stmt = $pdo->prepare("SELECT * FROM pergunta WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function atualizar_pergunta($pdo, $id, $texto) {
    // REVERTIDO: Usando 'pergunta' (singular)
    $stmt = $pdo->prepare("UPDATE pergunta SET texto=? WHERE id=?\r\n");
    $stmt->execute([$texto, $id]);
}

function remover_pergunta($pdo, $id) {
    // REVERTIDO: Usando 'pergunta' (singular)
    $stmt = $pdo->prepare("DELETE FROM pergunta WHERE id=?");
    $stmt->execute([$id]);
}


/* ---------- SETORES ---------- */

function listar_setores($pdo) {
    // Mantido como 'setor' (singular)
    return $pdo->query("SELECT * FROM setor ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
}

function adicionar_setor($pdo, $nome) {
    // Mantido como 'setor' (singular)
    $stmt = $pdo->prepare("INSERT INTO setor (nome) VALUES (?)");
    $stmt->execute([$nome]);
}


/* ---------- DISPOSITIVOS ---------- */

function listar_dispositivos($pdo) {
    // REVERTIDO: Usando 'dispositivo' (singular)
    return $pdo->query("
        SELECT d.id, d.nome, s.nome AS setor_nome 
        FROM dispositivo d 
        JOIN setor s ON s.id = d.setor_id 
        ORDER BY d.nome
    ")->fetchAll(PDO::FETCH_ASSOC);
}

function adicionar_dispositivo($pdo, $nome, $setor_id) {
    // REVERTIDO: Usando 'dispositivo' (singular)
    $stmt = $pdo->prepare("INSERT INTO dispositivo (nome, setor_id) VALUES (?, ?)");
    $stmt->execute([$nome, $setor_id]);
}

// ... Outras funções de CRUD (se houver) ...