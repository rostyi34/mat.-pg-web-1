<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem e Busca de Pessoas</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 800px; margin: auto; }
        .form-busca { display: flex; gap: 10px; margin-bottom: 30px; }
        .form-busca input[type="text"] { flex-grow: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .form-busca input[type="submit"] { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .form-busca input[type="submit"]:hover { background-color: #1e7e34; }
        .button { display: inline-block; padding: 10px 20px; margin: 10px 0; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s; }
        .button:hover { background-color: #0056b3; }
        h3 { border-bottom: 2px solid #ccc; padding-bottom: 10px; }
    </style>
</head>
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