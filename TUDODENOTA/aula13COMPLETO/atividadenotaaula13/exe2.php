<?php
require "Pessoa.php";
use Model\Pessoa;
$familia = [];
$familia[] = new Pessoa("Pai", "Silva", 45, "pai@example.com");
$familia[] = new Pessoa("Mãe", "Silva", 42, "mae@example.com");
$familia[] = new Pessoa("Irmão", "Silva", 20, "irmao@example.com");

file_put_contents("familia.txt", serialize($familia));
echo "Arquivo TXT criado com sucesso!";
?>