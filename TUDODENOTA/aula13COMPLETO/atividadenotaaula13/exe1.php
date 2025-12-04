<?php
require "Pessoa.php";
use Model\Pessoa;
$eu = new Pessoa("Gustavo", "Silva", 18, "gustavo@example.com");
echo "Meu nome completo: " . $eu->nomeCompleto();
?>