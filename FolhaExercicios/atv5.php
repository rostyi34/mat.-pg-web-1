<!DOCTYPE html>
<html>
<head>
    <title>Questão 5 - Área do triângulo retângulo</title>
</head>
<body>
<form method="post">
    Base (m): <input type="number" step="0.01" name="base"><br>
    Altura (m): <input type="number" step="0.01" name="altura"><br>
    <input type="submit" value="Calcular">
</form>

<?php
if($_POST){
    $base = $_POST['base'];
    $altura = $_POST['altura'];
    $area = ($base * $altura) / 2;
    echo "A área do triângulo retângulo é $area metros quadrados.";
}
?>
</body>
</html>
