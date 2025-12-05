<?php
// public/dashboard.php
require_once "../src/db.php";
require_once "../src/auth.php"; 
proteger(); 

$pdo = getPDO();

// FILTRO
$setor_id = ($_GET["setor"] ?? "todos");

// LISTAR SETORES
$setores = $pdo->query("SELECT * FROM setor ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

/* -------------------------------------------------------------
   LISTAR AVALIAÇÕES - BUSCA AVALIACOES E FAZ JOINS
   ------------------------------------------------------------- */
$sql = "
    SELECT a.*, p.texto AS pergunta, s.nome AS setor, d.nome AS dispositivo
    FROM avaliacoes a  /* <--- CORRIGIDO: 'avaliacoes' */
    INNER JOIN perguntas p ON p.id = a.pergunta_id  /* <--- CORRIGIDO: 'perguntas' */
    INNER JOIN setor s ON s.id = a.setor_id
    INNER JOIN dispositivo d ON d.id = a.dispositivo_id
";

if ($setor_id !== "todos") {
    $sql .= " WHERE a.setor_id = :setor";
}

$sql .= " ORDER BY a.data_hora DESC";

$stmt = $pdo->prepare($sql);
if ($setor_id !== "todos") {
    $stmt->execute(["setor" => $setor_id]);
} else {
    $stmt->execute();
}

$avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* -------------------------------------------------------------
   MÉDIA POR PERGUNTA
   ------------------------------------------------------------- */
$media_sql = "
    SELECT p.texto, AVG(a.resposta) AS media
    FROM avaliacoes a  /* <--- CORRIGIDO: 'avaliacoes' */
    INNER JOIN perguntas p ON p.id = a.pergunta_id /* <--- CORRIGIDO: 'perguntas' */
";

if ($setor_id !== "todos") {
    $media_sql .= " WHERE a.setor_id = :setor";
}

$media_sql .= " GROUP BY p.id ORDER BY p.id";

$stmt = $pdo->prepare($media_sql);
if ($setor_id !== "todos") {
    $stmt->execute(["setor" => $setor_id]);
} else {
    $stmt->execute();
}

$medias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard | Painel Administrativo</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main class="container">
    <h1>Painel Administrativo</h1>
    <p><a href="admin.php">Ver Feedbacks Simples</a> | <a href="logout.php">Sair</a></p>

    <h2>Filtrar Avaliações</h2>

    <form>
    <select name="setor">
        <option value="todos">Todos</option>
        <?php foreach ($setores as $s): ?>
        <option value="<?= $s["id"] ?>" <?= ($setor_id == $s["id"] ? "selected" : "") ?>>
            <?= $s["nome"] ?>
        </option>
        <?php endforeach; ?>
    </select>
    <button>Filtrar</button>
    </form>

    <hr>

    <h2>Médias por Pergunta</h2>

    <table>
    <tr><th>Pergunta</th><th>Média</th></tr>
    <?php foreach ($medias as $m): ?>
    <tr>
    <td><?= htmlspecialchars($m["texto"]) ?></td>
    <td><?= number_format($m["media"], 2) ?></td>
    </tr>
    <?php endforeach; ?>
    </table>

    <hr>

    <h2>Avaliações Registradas (Detalhe)</h2>

    <table>
    <tr>
    <th>Data</th>
    <th>Setor</th>
    <th>Dispositivo</th>
    <th>Pergunta</th>
    <th>Resposta</th>
    <th>Feedback</th>
    </tr>

    <?php if (empty($avaliacoes)): ?>
        <tr><td colspan="6">Nenhuma avaliação encontrada para o filtro selecionado.</td></tr>
    <?php else: ?>
        <?php foreach ($avaliacoes as $a): ?>
        <tr>
        <td><?= (new DateTime($a['data_hora']))->format('d/m/Y H:i') ?></td>
        <td><?= htmlspecialchars($a["setor"]) ?></td>
        <td><?= htmlspecialchars($a["dispositivo"]) ?></td>
        <td><?= htmlspecialchars($a["pergunta"]) ?></td>
        <td><?= htmlspecialchars($a["resposta"]) ?></td>
        <td><?= htmlspecialchars($a["feedback"]) ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </table>

</main>
</body>
</html>