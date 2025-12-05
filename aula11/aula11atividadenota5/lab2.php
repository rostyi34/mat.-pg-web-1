<?php
// lab2.php - Recebe dados do cadastro.html, valida e insere no DB
$conn = pg_connect("host=localhost dbname=aula11 user=postgres password=1234");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Cadastro</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; padding-top: 50px; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        .success { color: #008000; font-weight: bold; }
        .error { color: #ff0000; font-weight: bold; }
        .button { display: inline-block; padding: 10px 20px; margin: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s; }
        .button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $errors = [];
        $dados = [];

        // 1. Sanitização e Validação (Exercício 4)
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = $_POST['senha'] ?? ''; // Senha não é sanitizada com filter_var, deve ser hashed
        $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        
        // Exemplo de Validação: Nome e E-mail
        if (empty($nome) || strlen($nome) < 2) {
            $errors[] = "O nome é obrigatório e precisa ter pelo menos 2 caracteres."; 
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "O e-mail é inválido.";
        }

        if (empty($errors)) {
            // 2. Hash da Senha (Boa prática de segurança)
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

            // 3. Preparar array de dados para pg_query_params()
            $sql = "INSERT INTO TBPESSOA (PESNOME, PESSOBRENOME, PESEMAIL, PESPASSWORD, PESCIDADE, PESESTADO)
                    VALUES ($1, $2, $3, $4, $5, $6)";
            
            $params = array($nome, $sobrenome, $email, $senha_hashed, $cidade, $estado);

            // 4. Executar a query
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