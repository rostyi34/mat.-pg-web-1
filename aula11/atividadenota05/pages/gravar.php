<?php
require "../includes/conexao.php";
$nome=filter_var($_POST['nome'],FILTER_SANITIZE_SPECIAL_CHARS);
$sobrenome=filter_var($_POST['sobrenome'],FILTER_SANITIZE_SPECIAL_CHARS);
$email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
$senha=filter_var($_POST['senha'],FILTER_SANITIZE_SPECIAL_CHARS);
$cidade=filter_var($_POST['cidade'],FILTER_SANITIZE_SPECIAL_CHARS);
$estado=filter_var($_POST['estado'],FILTER_SANITIZE_SPECIAL_CHARS);
if($email!="" && !filter_var($email,FILTER_VALIDATE_EMAIL)) die("Email inválido.");

$sql="INSERT INTO TBPESSOA (PESNOME,PESSOBRENOME,PESEMAIL,PESPASSWORD,PESCIDADE,PESESTADO)
VALUES ($1,$2,$3,$4,$5,$6)";
$params=array($nome,$sobrenome,$email,$senha,$cidade,$estado);
$res=pg_query_params($conn,$sql,$params);
if($res){ header("Location: listar.php"); exit; }
echo "Erro ao inserir.";
?>