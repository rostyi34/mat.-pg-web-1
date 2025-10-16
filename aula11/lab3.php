<?php
$dados = array(
    'nome' => $_POST['nome'],
    'sobrenome' => $_POST['sobrenome'],
    'email' => $_POST['email'],
    'senha' => $_POST['senha'],
    'cidade' => $_POST['cidade'],
    'estado' => $_POST['estado']
);

$arquivo = 'dados.json';

// Lê o arquivo existente, se houver
$conteudo = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

// Adiciona nova pessoa
$conteudo[] = $dados;

// Salva de volta em JSON
file_put_contents($arquivo, json_encode($conteudo, JSON_PRETTY_PRINT));

echo "Pessoa salva no arquivo com sucesso!";
?>
