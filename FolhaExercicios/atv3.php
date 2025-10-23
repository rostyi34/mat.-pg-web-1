<!DOCTYPE html>
<html>
<head>
    <title>Questão 3 - Área do quadrado</title>
</head>
<body>
<form method="post">
    Lado (m): <input type="number" step="0.01" name="lado">
    <input type="submit" value="Calcular">
</form>

<?php
if($_POST){
    $lado = $_POST['lado'];
    $area = $lado * $lado;
    echo "A área do quadrado de lado $lado metros é $area metros quadrados.";
}
?>
</body>
</html>
