<?php
// Inclui a classe Pessoa
require "Pessoa.php";
use Model\Pessoa;

// --- Exe 1: Instância Pessoal ---
$eu = new Pessoa("Gustavo", "Silva", 18, "gustavo@example.com");

// --- Exe 2: Carregamento dos Dados da Família (Deserialização) ---
// **CORREÇÃO APLICADA: Verifica se o arquivo existe E não está vazio antes de desserializar.**
$familia_objetos = [];
$filename_familia = "familia.txt";
if (file_exists($filename_familia) && filesize($filename_familia) > 0) {
    $familia_serializada = file_get_contents($filename_familia);
    // Usa @ para suprimir o Notice caso a desserialização falhe de forma incompleta
    $temp_objects = @unserialize($familia_serializada); 
    if ($temp_objects !== false) {
        $familia_objetos = $temp_objects;
    }
}

// --- Exe 3: Carregamento dos Dados JSON ---
$pessoa_json = null;
if (file_exists("pessoa.json")) {
    $pessoa_json_conteudo = file_get_contents("pessoa.json");
    $pessoa_json = json_decode($pessoa_json_conteudo);
}

// Função auxiliar para renderizar a Pessoa em um card
function renderPessoaCard(Pessoa $p, $header = "") {
    echo '<div class="card-body">';
    if (!empty($header)) {
         echo '<h6 class="card-subtitle mb-2 text-muted">' . $header . '</h6>';
    }
    echo '  <h5 class="card-title">' . htmlspecialchars($p->nomeCompleto()) . '</h5>';
    echo '  <p class="card-text"><strong>Idade:</strong> ' . htmlspecialchars($p->getIdade()) . '</p>';
    echo '  <p class="card-text"><strong>Email:</strong> ' . htmlspecialchars($p->getEmail()) . '</p>';
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OO - Exercícios de Persistência</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <h1>🏠 PHP Orientado a Objetos - Persistência de Dados</h1>
        
        <p class="mb-4"><a href="create.php" class="btn btn-success">➕ Criar Novo Objeto Pessoa na Interface</a></p>
        
        <hr>
        
        <div class="row mb-5">
            <div class="col-md-6">
                <h2>👤 Instância em Memória (Exe 1)</h2>
                <div class="card shadow">
                    <?php renderPessoaCard($eu, "Objeto criado diretamente no script"); ?>
                </div>
            </div>
            <div class="col-md-6">
                <h2>💾 Carregado de JSON (Exe 3)</h2>
                <?php if ($pessoa_json && isset($pessoa_json->nome)): ?>
                    <div class="card shadow bg-light">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Dados lidos do arquivo 'pessoa.json'</h6>
                            <h5 class="card-title"><?= htmlspecialchars($pessoa_json->nome) . " " . htmlspecialchars($pessoa_json->sobrenome) ?></h5>
                            <p class="card-text"><strong>Idade:</strong> <?= htmlspecialchars($pessoa_json->idade) ?></p>
                            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($pessoa_json->email) ?></p>
                        </div>
                    </div>
                <?php else: ?>
                     <div class="alert alert-warning">Arquivo 'pessoa.json' não encontrado ou vazio. Execute o 'exe3.php' primeiro!</div>
                <?php endif; ?>
            </div>
        </div>

        <hr>

        <h2 class="mt-4">👨‍👩‍👧‍👦 Dados da Família (Deserialização de TXT - Exe 2)</h2>
        <p class="text-muted">Abaixo estão os objetos `Model\Pessoa` reconstruídos a partir da serialização salva em `familia.txt`.</p>
        
        <div class="row">
            <?php if (!empty($familia_objetos)): ?>
                <?php foreach ($familia_objetos as $membro): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-primary">
                            <?php renderPessoaCard($membro); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                 <div class="alert alert-warning">Arquivo 'familia.txt' vazio ou não encontrado. Execute o 'exe2.php' primeiro!</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>