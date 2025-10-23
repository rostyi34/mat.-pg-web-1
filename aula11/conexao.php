<?php
$host = "localhost";
$port = "5432";
$dbname = "local";
$user = "postgres";
$password = "123";

$con = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$con) {
    echo "Erro ao conectar ao banco de dados.";
    exit;
}
?>
