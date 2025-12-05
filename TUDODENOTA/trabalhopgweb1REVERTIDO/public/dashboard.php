<?php
require_once "../src/db.php";
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

$pdo = getPDO();

// FILTRO
$setor_id = ($_GET["setor"] ?? "todos");

// LISTAR SETORES
$setores = $pdo->query("SELECT * FROM setor ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// LISTAR AVALIAÇÕES
$sql = "
    SELECT a.*, p.texto AS pergunta, s.nome AS setor, d.nome AS dispositivo
    FROM avaliacao a
    INNER JOIN pergunta p ON p.id = a.pergunta_id
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

// MÉDIA POR PERGUNTA
$media_sql = "
    SELECT p.texto, AVG(a.resposta) AS media
    FROM avaliacao a
    INNER JOIN pergunta p ON p.id = a.pergunta_id
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

// MÉDIA POR SETOR
$medias_setor = $pdo->query("
    SELECT s.nome, AVG(a.resposta) AS media, COUNT(*) AS total
    FROM avaliacao a
    INNER JOIN setor s ON s.id = a.setor_id
    GROUP BY s.id
    ORDER BY s.nome
")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { font-family: Arial; margin: 20px; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #ccc; padding: 8px; }
.container { max-width: 1100px; margin: auto; }
</style>
</head>
<body>

<div class="container">

<h1>Painel de Avaliações</h1>

<a href="admin.php">Gerenciar Perguntas</a> |
<a href="logout.php" style="color:red;">Sair</a>

<hr>

<h2>Filtrar por setor</h2>

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

<h2>Médias por pergunta</h2>

<table>
<tr><th>Pergunta</th><th>Média</th></tr>
<?php foreach ($medias as $m): ?>
<tr>
<td><?= $m["texto"] ?></td>
<td><?= number_format($m["media"], 2) ?></td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<h2>Avaliações registradas</h2>

<table>
<tr>
<th>Data</th>
<th>Setor</th>
<th>Dispositivo</th>
<th>Pergunta</th>
<th>Resposta</th>
<th>Feedback</th>
</tr>

<?php foreach ($avaliacoes as $a): ?>
<tr>
<td><?= $a["data_hora"] ?></td>
<td><?= $a["setor"] ?></td>
<td><?= $a["dispositivo"] ?></td>
<td><?= $a["pergunta"] ?></td>
<td><?= $a["resposta"] ?></td>
<td><?= $a["feedback"] ?></td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<h2>Gráfico — Média por pergunta</h2>
<canvas id="graf1"></canvas>

<script>
const labels = <?= json_encode(array_column($medias, "texto")) ?>;
const data = <?= json_encode(array_column($medias, "media")) ?>;

new Chart(document.getElementById('graf1'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: "Média",
            data: data
        }]
    }
});
</script>

</div>

</body>
</html>