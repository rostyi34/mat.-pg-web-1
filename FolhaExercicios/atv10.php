<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Questão 10 - Árvore de Pastas Recursiva</title>
    <style>
        body {
            font-family: Consolas, monospace;
            margin: 30px;
            line-height: 1.4;
        }

        ul {
            list-style-type: "- ";
            margin-left: 20px;
            padding-left: 10px;
        }
    </style>
</head>
<body>
<h2>Árvore de Pastas (recursiva)</h2>

<?php

$pastas = array(
    "bsn" => array(
        "3a Fase" => array(
            "desenvWeb",
            "bancoDados 1",
            "engSoft 1"
        ),
        "4a Fase" => array(
            "Intro Web",
            "bancoDados 2",
            "engSoft 2"
        )
    )
);


function mostrarPastas($array) {
    echo "<ul>";
    foreach ($array as $chave => $valor) {
       
        if (is_array($valor)) {
           
            if (is_numeric($chave)) {
                echo "<li>$valor</li>";
            } else {
                echo "<li>$chave</li>";
                mostrarPastas($valor);
            }
        } else {
            echo "<li>$valor</li>";
        }
    }
    echo "</ul>";
}


mostrarPastas($pastas);
?>
</body>
</html>
