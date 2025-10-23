<!DOCTYPE html>
<html>
<head>
    <title>Questão 4 - Área do retângulo</title>
</head>
<body>
<form method="post">
    Lado A (m): <input type="number" step="0.01" name="a"><br>
    Lado B (m): <input type="number" step="0.01" name="b"><br>
    <input type="submit" value="Calcular">
</form>

<?php
if($_POST){
    $a = $_POST['a'];
    $b = $_POST['b'];
    $area = $a * $b;
    if($area > 10){
        echo "<h1>A área do retângulo de lados $a e $b metros é $area metros quadrados.</h1>";
    } else {
        echo "<h3>A área do retângulo de lados $a e $b metros é $area metros quadrados.</h3>";
    }
}
?>
</body>
</html>
