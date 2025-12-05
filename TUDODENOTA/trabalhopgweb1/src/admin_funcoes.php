<?php

require_once __DIR__ . "/db.php"; 
$pdo = getPDO();



function listar_perguntas($pdo) {
    
    return $pdo->query("SELECT * FROM pergunta ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
}

function adicionar_pergunta($pdo, $texto) {
    
    $stmt = $pdo->prepare("INSERT INTO pergunta (texto) VALUES (?)");
    $stmt->execute([$texto]);
}

function obter_pergunta($pdo, $id) {
   
    $stmt = $pdo->prepare("SELECT * FROM pergunta WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function atualizar_pergunta($pdo, $id, $texto) {
    
    $stmt = $pdo->prepare("UPDATE pergunta SET texto=? WHERE id=?\r\n");
    $stmt->execute([$texto, $id]);
}

function remover_pergunta($pdo, $id) {
    
    $stmt = $pdo->prepare("DELETE FROM pergunta WHERE id=?");
    $stmt->execute([$id]);
}




function listar_setores($pdo) {
   
    return $pdo->query("SELECT * FROM setor ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
}

function adicionar_setor($pdo, $nome) {
    
    $stmt = $pdo->prepare("INSERT INTO setor (nome) VALUES (?)");
    $stmt->execute([$nome]);
}


/* ---------- DISPOSITIVOS ---------- */

function listar_dispositivos($pdo) {
    
    return $pdo->query("
        SELECT d.id, d.nome, s.nome AS setor_nome 
        FROM dispositivo d 
        JOIN setor s ON s.id = d.setor_id 
        ORDER BY d.nome
    ")->fetchAll(PDO::FETCH_ASSOC);
}

function adicionar_dispositivo($pdo, $nome, $setor_id) {
   
    $stmt = $pdo->prepare("INSERT INTO dispositivo (nome, setor_id) VALUES (?, ?)");
    $stmt->execute([$nome, $setor_id]);
}

