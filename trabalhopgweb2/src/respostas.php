<?php
// src/respostas.php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/funcoes.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método não permitido.";
    exit;
}

// Esperamos:
// respostas como array: respostas[pergunta_id] = valor
// feedback (opcional) => string
// dispositivo_id (opcional) => integer

$respostas = $_POST['respostas'] ?? null;
$feedback = isset($_POST['feedback']) ? sanitize_text($_POST['feedback']) : null;
$dispositivo_id = isset($_POST['dispositivo_id']) ? (int)$_POST['dispositivo_id'] : null;

if (!is_array($respostas) || empty($respostas)) {
    // Resposta inválida
    header('Location: ../public/index.php?error=1');
    exit;
}

$pdo = getPDO();
try {
    $pdo->beginTransaction();

    $insert = $pdo->prepare("
        INSERT INTO avaliacoes (dispositivo_id, pergunta_id, resposta, feedback, data_hora)
        VALUES (:dispositivo_id, :pergunta_id, :resposta, :feedback, now())
    ");

    foreach ($respostas as $pergunta_id => $valor) {
        $pergunta_id = (int)$pergunta_id;
        $valor = (int)$valor;
        if (!validate_score($valor)) {
            // rollback e erro simples
            $pdo->rollBack();
            header('Location: ../public/index.php?error=2');
            exit;
        }
        // Só gravar feedback na primeira avaliação (opcional) - ou gravar sempre (aqui gravamos somente se houver)
        $fb_to_save = $feedback ?: null;

        $insert->execute([
            ':dispositivo_id' => $dispositivo_id ?: null,
            ':pergunta_id' => $pergunta_id,
            ':resposta' => $valor,
            ':feedback' => $fb_to_save
        ]);
        // Para evitar duplicar feedback em cada linha, podemos definir $feedback = null após a 1ª inserção,
        // mas manter como está não é um problema funcional (o enunciado permite).
        $feedback = null;
    }

    $pdo->commit();
    // Após gravação, redirecionar para página de obrigado
    header('Location: ../public/obrigado.php');
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    // Não mostrar exceção em produção
    header('Location: ../public/index.php?error=3');
    exit;
}
