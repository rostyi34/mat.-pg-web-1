<?php


$conn = pg_connect("host=localhost dbname=aula11 user=postgres password=1234");
if (!$conn) {
    echo "<p class='error'>Erro de conexão com o banco de dados.</p>";
    exit;
}


$termo_busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

$sql = "SELECT pescodigo, pesnome, pessobrenome, pesemail, pescidade, pesestado FROM TBPESSOA";
$params = [];

if (!empty($termo_busca)) {
   
    $sql .= " WHERE PESNOME ILIKE $1 OR PESSOBRENOME ILIKE $1";
    
    $params[] = '%' . $termo_busca . '%';
    echo "<h4>Resultados da busca por: **$termo_busca**</h4>";
} else {
    echo "<h4>Lista Completa de Cadastros</h4>";
}

$sql .= " ORDER BY pescodigo DESC";

 
if (!empty($params)) {
    $result = pg_query_params($conn, $sql, $params);
} else {
    $result = pg_query($conn, $sql);
}

if (!$result) {
    echo "<p class='error'>Erro ao executar a consulta: " . pg_last_error($conn) . "</p>";
} else {
    if (pg_num_rows($result) > 0) {
  
        echo "<table>"; 
        echo "<thead><tr><th>Cód.</th><th>Nome</th><th>Sobrenome</th><th>E-mail</th><th>Cidade/Estado</th></tr></thead>";
        echo "<tbody>";

        while ($row = pg_fetch_assoc($result)) {
            
            $nome = htmlspecialchars($row['pesnome']);
            $sobrenome = htmlspecialchars($row['pessobrenome']);
            $email = htmlspecialchars($row['pesemail']);
            $local = htmlspecialchars($row['pescidade']) . "/" . htmlspecialchars($row['pesestado']);

            echo "<tr>";
            echo "<td>{$row['pescodigo']}</td>";
            echo "<td>$nome</td>";
            echo "<td>$sobrenome</td>";
            echo "<td>$email</td>";
            echo "<td>$local</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Nenhum registro encontrado.</p>";
    }
}
?>