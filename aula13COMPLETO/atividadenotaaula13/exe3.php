<?php
require "model/Pessoa.php";
use Model\Pessoa;
$p = new Pessoa("Gustavo", "Silva", 18, "gustavo@example.com");
file_put_contents("pessoa.json", $p->toJSON());
echo "Arquivo JSON criado!";
?>