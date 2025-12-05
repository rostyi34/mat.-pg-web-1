<?php
require_once "../src/db.php";
require_once "../src/auth.php";

$pdo = getPDO();
$erro = "";


$pdo->exec("
CREATE TABLE IF NOT EXISTS admin (
    id SERIAL PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    senha TEXT NOT NULL
)");

$count = $pdo->query("SELECT COUNT(*) FROM admin")->fetchColumn();

if ($count == 0) {
    $hash = password_hash("admin123", PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO admin (usuario, senha) VALUES (:u, :s)");
    $stmt->execute(["u" => "admin", "s" => $hash]);
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = trim($_POST["usuario"]);
    $senha = $_POST["senha"];

    if (login($pdo, $usuario, $senha)) {
        header("Location: admin.php");
        exit;
    } else {
        $erro = "Usuário ou senha incorretos.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<style>
body { font-family: Arial; padding: 40px; text-align: center; }
input { padding: 10px; width: 250px; margin: 5px; }
button { padding: 10px 20px; cursor: pointer; }
</style>
</head>
<body>

<h2>Painel Administrativo</h2>
<p>Faça login para continuar.</p>

<form method="POST">
    <input name="usuario" placeholder="Usuário" required><br>
    <input name="senha" type="password" placeholder="Senha" required><br>
    <button>Entrar</button>
</form>

<p style="color:red;"><?= $erro ?></p>

</body>
</html>