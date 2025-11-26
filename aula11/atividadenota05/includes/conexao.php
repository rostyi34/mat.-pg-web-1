<?php
$conn = pg_connect("host=localhost dbname=aula11 user=postgres password=1234");
if (!$conn) { die("Erro ao conectar ao banco de dados."); }
?>