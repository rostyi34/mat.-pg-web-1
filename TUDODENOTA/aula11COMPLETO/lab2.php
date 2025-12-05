<?php

$conn = pg_connect("host=localhost dbname=aula11 user=postgres password=1234");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Cadastro</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <?php
        $errors = [];
        $dados = [];

      
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = $_POST['senha'] ?? ''; 
        $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        
      
        if (empty($nome) || strlen($nome) < 2) {
            $errors[] = "O nome é obrigatório e precisa ter pelo menos 2 caracteres."; 
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "O e-mail é inválido.";
        }

        if (empty($errors)) {
           
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

           
            $sql = "INSERT INTO TBPESSOA (PESNOME, PESSOBRENOME, PESEMAIL, PESPASSWORD, PESCIDADE, PESESTADO)
                    VALUES ($1, $2, $3, $4, $5, $6)";
            
            $params = array($nome, $sobrenome, $email, $senha_hashed, $cidade, $estado);

            
            $result = pg_query_params($conn, $sql, $params);

            if ($result) {
                echo "<h2 class='success'>✅ Cadastro Realizado com Sucesso!</h2>";
                echo "<p>Pessoa **$nome $sobrenome** inserida no banco de dados.</p>";
            } else {
                echo "<h2 class='error'>❌ Erro ao Cadastrar</h2>";
                echo "<p>Ocorreu um erro ao tentar inserir os dados.</p>";
            }
        } else {
            echo "<h2 class='error'>❌ Erro de Validação</h2>";
            echo "<p>Corrija os seguintes problemas:</p>";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        }
        ?>
        
        <a href="cadastro.html" class="button">↩️ Voltar ao Cadastro</a>
        <a href="listagem.php" class="button">🔍 Ir para a Listagem</a>
    </div>
</body>
</html>