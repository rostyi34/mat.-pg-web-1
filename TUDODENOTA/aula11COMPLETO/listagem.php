<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem e Busca de Pessoas</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <div class="header">
            <h2>🔍 Listagem e Busca de Pessoas</h2>
            <a href="cadastro.html" class="button">➕ Novo Cadastro</a>
        </div>
        
        <h3>Buscar por Nome</h3>
        <form action="procura.php" method="get" class="form-busca">
            <input type="text" name="busca" placeholder="Digite o nome ou parte do nome" required>
            <input type="submit" value="Buscar">
        </form>

        <h3>Todos os Cadastros</h3>
        
        <?php
        // Inclui o script de procura com a busca vazia para listar tudo
        $_GET['busca'] = '';
        include 'procura.php';
        ?>
    </div>
</body>
</html>