<?php
require "Pessoa.php";
use Model\Pessoa;
$p = new Pessoa("Gustavo", "Silva", 18, "gustavo@example.com");
// Salva a representação JSON do objeto
file_put_contents("pessoa.json", $p->toJSON());
echo "Arquivo JSON criado!";
?>