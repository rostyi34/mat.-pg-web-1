<?php
include 'conexao.php';

// sanitização simples (boa prática)
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);

$sql = "INSERT INTO tbpessoa (pesnome, pessobrenome, pesemail, pespassword, pescidade, pesestado)
        VALUES ($1, $2, $3, $4, $5, $6)";

$result = pg_query_params($con, $sql, array($nome, $sobrenome, $email, $senha, $cidade, $estado));

if ($result) {
    echo "<p>Cadastro realizado com sucesso!</p>";
    echo "<a href='listar.php'>Ver cadastros</a>";
} else {
    echo "<p>Erro ao cadastrar.</p>";
}
?>
