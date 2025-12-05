<?php
// src/respostas.php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/funcoes.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método não permitido.";
    exit;
}

$respostas = $_POST['respostas'] ?? null;
$feedback = isset($_POST['feedback']) ? sanitize_text($_POST['feedback']) : null;
$dispositivo_id = isset($_POST['dispositivo_id']) ? (int)$_POST['dispositivo_id'] : null;

if (!is_array($respostas) || empty($respostas)) {
    header('Location: ../public/index.php?error=1');
    exit;
}

$pdo = getPDO();
try {
    $pdo->beginTransaction();

    $insert = $pdo->prepare("
        INSERT INTO avaliacoes (dispositivo_id, pergunta_id, resposta, feedback, data_hora) /* <--- CORRIGIDO: 'avaliacoes' */
        VALUES (:dispositivo_id, :pergunta_id, :resposta, :feedback, now())
    "); 

    foreach ($respostas as $pergunta_id => $valor) {
        $pergunta_id = (int)$pergunta_id;
        $valor = (int)$valor;
        if (!validate_score($valor)) {
            $pdo->rollBack();
            header('Location: ../public/index.php?error=2');
            exit;
        }
        
        $fb_to_save = $feedback ?: null;

        $insert->execute([
            ':dispositivo_id' => $dispositivo_id ?: null,
            ':pergunta_id' => $pergunta_id,
            ':resposta' => $valor,
            ':feedback' => $fb_to_save
        ]);
        
        $feedback = null;
    }

    $pdo->commit();
    // Redirecionamento para a tela de obrigado após sucesso
    header('Location: ../public/obrigado.php');
    exit;

} catch (PDOException $e) { 
    if ($pdo->inTransaction()) $pdo->rollBack();
    header('Location: ../public/index.php?error=99');
    exit;
}