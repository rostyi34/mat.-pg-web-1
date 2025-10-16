<?php
include 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pessoas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>

<h2>Lista de Pessoas</h2>
<a href="cadastro.html">+ Novo Cadastro</a><br><br>

<!-- Formulário de busca -->
<form method="get" action="">
    Buscar nome: 
    <input type="text" name="busca" value="<?php echo htmlspecialchars($_GET['busca'] ?? '', ENT_QUOTES); ?>">
    <input type="submit" value="Pesquisar">
</form>

<?php
// Captura o termo de busca
$busca = $_GET['busca'] ?? '';

// Executa a consulta
if ($busca != '') {
    $sql = "SELECT * FROM tbpessoa WHERE pesnome ILIKE $1 ORDER BY pescodigo";
    $result = pg_query_params($con, $sql, array('%' . $busca . '%'));
    echo "<p>Resultados da busca por: <strong>" . htmlspecialchars($busca) . "</strong></p>";
} else {
    $result = pg_query($con, "SELECT * FROM tbpessoa ORDER BY pescodigo");
}

// Monta a tabela
if (pg_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Código</th><th>Nome</th><th>Email</th><th>Cidade</th><th>Estado</th></tr>";
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['pescodigo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pesnome']) . " " . htmlspecialchars($row['pessobrenome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pesemail']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pescidade']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pesestado']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum registro encontrado.</p>";
}
?>

</body>
</html>
