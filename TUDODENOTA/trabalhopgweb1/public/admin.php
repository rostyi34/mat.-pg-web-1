<?php

require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/auth.php'; 
proteger(); 

function fetch_feedbacks(): array {
    $pdo = getPDO();
    
    $stmt = $pdo->prepare("
        SELECT feedback, data_hora 
        FROM avaliacoes  
        WHERE feedback IS NOT NULL AND TRIM(feedback) <> ''
        ORDER BY data_hora DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll();
}

$feedbacks = fetch_feedbacks();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Visualização de Feedbacks</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    
    .feedback-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .feedback-table th, .feedback-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }
    .feedback-table th {
        background-color: #f2f2f2;
        color: #333;
    }
    .feedback-text {
        font-style: italic;
    }
  </style>
</head>
<body>
  <main class="container">
    <h1>Feedbacks Adicionais</h1>
    
    <p><a href="dashboard.php">Ver Dashboard Completo</a> | <a href="logout.php">Sair</a></p>

    <?php if (empty($feedbacks)): ?>
        <p>Nenhum feedback adicional encontrado até o momento.</p>
    <?php else: ?>
        <table class="feedback-table">
            <thead>
                <tr>
                    <th>Data/Hora</th>
                    <th>Comentário (Feedback)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedbacks as $fb): ?>
                    <tr>
                        <td><?= (new DateTime($fb['data_hora']))->format('d/m/Y H:i') ?></td>
                        <td class="feedback-text"><?= htmlspecialchars($fb['feedback']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

  </main>
</body>
</html>