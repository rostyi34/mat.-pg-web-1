<?php
require_once "../src/db.php"; 
$pdo = getPDO();   // CORRIGE TODOS OS ERROS

/* ============================================================
   FUNÇÕES INTERNAS DO ADMIN (TUDO EM 1 ARQUIVO)
   ============================================================ */

/* ---------- PERGUNTAS ---------- */

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
    $stmt = $pdo->prepare("UPDATE pergunta SET texto=? WHERE id=?");
    $stmt->execute([$texto, $id]);
}

function remover_pergunta($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM pergunta WHERE id=?");
    $stmt->execute([$id]);
}


/* ---------- SETORES ---------- */

function listar_setores($pdo) {
    return $pdo->query("SELECT * FROM setor ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
}

function adicionar_setor($pdo, $nome) {
    $stmt = $pdo->prepare("INSERT INTO setor (nome) VALUES (?)");
    $stmt->execute([$nome]);
}

/* ---------- DISPOSITIVOS ---------- */

function listar_dispositivos($pdo) {
    return $pdo->query("
        SELECT d.*, s.nome AS setor 
        FROM dispositivo d 
        LEFT JOIN setor s ON s.id = d.setor_id
        ORDER BY d.id
    ")->fetchAll(PDO::FETCH_ASSOC);
}

function adicionar_dispositivo($pdo, $nome, $setor_id) {
    $stmt = $pdo->prepare("INSERT INTO dispositivo (nome, setor_id) VALUES (?, ?)");
    $stmt->execute([$nome, $setor_id]);
}

function remover_dispositivo($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM dispositivo WHERE id=?");
    $stmt->execute([$id]);
}


/* ============================================================
   AÇÕES (POST/GET)
   ============================================================ */

// adicionar pergunta
if (isset($_POST['add_pergunta'])) {
    adicionar_pergunta($pdo, $_POST['texto']);
}

// editar pergunta
if (isset($_POST['edit_pergunta'])) {
    atualizar_pergunta($pdo, $_POST['id'], $_POST['texto']);
}

// remover pergunta
if (isset($_GET['del_pergunta'])) {
    remover_pergunta($pdo, $_GET['del_pergunta']);
}

// adicionar setor
if (isset($_POST['add_setor'])) {
    adicionar_setor($pdo, $_POST['nome']);
}

// adicionar dispositivo
if (isset($_POST['add_dispositivo'])) {
    adicionar_dispositivo($pdo, $_POST['nome'], $_POST['setor_id']);
}

// remover dispositivo
if (isset($_GET['del_dispositivo'])) {
    remover_dispositivo($pdo, $_GET['del_dispositivo']);
}


/* ============================================================
   CARREGAR LISTAS
   ============================================================ */

$perguntas = listar_perguntas($pdo);
$setores = listar_setores($pdo);
$dispositivos = listar_dispositivos($pdo);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Painel Administrativo</title>
<style>
body { font-family: Arial; margin: 40px; }
h1 { color: #222; }
table { border-collapse: collapse; width: 90%; margin-top: 10px; }
table, td, th { border: 1px solid #000; padding: 6px; }
form { margin-bottom: 30px; }
input, textarea, select { width: 300px; padding: 6px; }
button { padding: 6px 14px; cursor: pointer; }
</style>
</head>
<body>

<h1>Painel Administrativo</h1>

<hr>

<!-- ============================================================
     PERGUNTAS
     ============================================================ -->

<h2>Cadastro de Perguntas</h2>

<form method="POST">
<textarea name="texto" placeholder="Texto da pergunta..." required></textarea><br>
<button name="add_pergunta">Adicionar Pergunta</button>
</form>

<table>
<tr>
<th>ID</th><th>Pergunta</th><th>Ação</th>
</tr>
<?php foreach ($perguntas as $p): ?>
<tr>
<td><?= $p["id"] ?></td>
<td><?= $p["texto"] ?></td>
<td>
<a href="?edit=<?= $p["id"] ?>">Editar</a> | 
<a href="?del_pergunta=<?= $p["id"] ?>">Remover</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<?php if (isset($_GET["edit"])): 
    $p = obter_pergunta($pdo, $_GET["edit"]);
?>
<hr>
<h3>Editando Pergunta ID <?= $p["id"] ?></h3>

<form method="POST">
<input type="hidden" name="id" value="<?= $p["id"] ?>">
<textarea name="texto"><?= $p["texto"] ?></textarea><br>
<button name="edit_pergunta">Salvar</button>
</form>
<?php endif; ?>

<hr>

<!-- ============================================================
     SETORES
     ============================================================ -->

<h2>Cadastro de Setores</h2>

<form method="POST">
<input name="nome" placeholder="Nome do setor..." required>
<button name="add_setor">Adicionar Setor</button>
</form>

<table>
<tr>
<th>ID</th><th>Setor</th></tr>
<?php foreach ($setores as $s): ?>
<tr>
<td><?= $s["id"] ?></td>
<td><?= $s["nome"] ?></td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<!-- ============================================================
     DISPOSITIVOS
     ============================================================ -->

<h2>Cadastro de Dispositivos</h2>

<form method="POST">
<input name="nome" placeholder="Nome do dispositivo..." required>

<select name="setor_id" required>
<option value="">Selecione o setor</option>
<?php foreach ($setores as $s): ?>
<option value="<?= $s["id"] ?>"><?= $s["nome"] ?></option>
<?php endforeach; ?>
</select>

<button name="add_dispositivo">Adicionar Dispositivo</button>
</form>

<table>
<tr>
<th>ID</th><th>Nome</th><th>Setor</th><th>Ação</th>
</tr>
<?php foreach ($dispositivos as $d): ?>
<tr>
<td><?= $d["id"] ?></td>
<td><?= $d["nome"] ?></td>
<td><?= $d["setor"] ?></td>
<td><a href="?del_dispositivo=<?= $d["id"] ?>">Remover</a></td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>