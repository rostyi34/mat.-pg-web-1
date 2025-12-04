<?php
$conn = pg_connect("host=localhost dbname=aula11 user=postgres password=1234");

$sql = "INSERT INTO TBPESSOA (PESNOME, PESSOBRENOME)
        VALUES ($1, $2)";
$params = array("João", "Silva");

$result = pg_query_params($conn, $sql, $params);

if ($result) {
    echo "Inserido!";
} else {
    echo "Erro ao inserir.";
}
?>
