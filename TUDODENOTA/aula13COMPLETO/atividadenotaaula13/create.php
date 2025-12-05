<?php

require "Pessoa.php";
use Model\Pessoa;

$mensagem = "";
$pessoaCriada = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
    $idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

   
    if ($nome && $sobrenome && $idade && $email) {
        $pessoaCriada = new Pessoa($nome, $sobrenome, (int)$idade, $email);
        
       
        file_put_contents("ultima_pessoa_criada.json", $pessoaCriada->toJSON());

        $mensagem = "Objeto Pessoa ('{$pessoaCriada->nomeCompleto()}') criado com sucesso! Dados salvos em 'ultima_pessoa_criada.json'.";
    } else {
        $mensagem = "Erro: Por favor, preencha todos os campos corretamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Novo Objeto Pessoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>➕ Criar Novo Objeto Pessoa</h1>
        <p><a href="index.php" class="btn btn-secondary btn-sm">← Voltar para a Tela Principal</a></p>

        <?php if (!empty($mensagem)): ?>
            <div class="alert <?= strpos($mensagem, 'Erro') !== false ? 'alert-danger' : 'alert-success' ?> mt-3"><?= $mensagem ?></div>
        <?php endif; ?>

        <h2 class="mt-4">📝 Instanciar Objeto</h2>
        <form method="POST" action="create.php" class="card p-4 shadow">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="sobrenome" class="form-label">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
            </div>
            <div class="mb-3">
                <label for="idade" class="form-label">Idade</label>
                <input type="number" class="form-control" id="idade" name="idade" min="1" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Instanciar Novo Objeto Pessoa</button>
        </form>
        
        <?php if ($pessoaCriada): ?>
            <h2 class="mt-4">🚀 Objeto Recém-Criado (Em Memória)</h2>
            <div class="card shadow bg-light mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($pessoaCriada->nomeCompleto()) ?></h5>
                    <p class="card-text"><strong>Idade:</strong> <?= htmlspecialchars($pessoaCriada->getIdade()) ?></p>
                    <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($pessoaCriada->getEmail()) ?></p>
                    <p class="card-text text-muted">JSON salvo em arquivo: <code>ultima_pessoa_criada.json</code></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>