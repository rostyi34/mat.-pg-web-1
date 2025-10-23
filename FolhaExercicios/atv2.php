<!DOCTYPE html>
<html>
<head>
    <title>Questão 2 - Divisível por 2</title>
</head>
<body>
<form method="post">
    Número: <input type="number" name="num">
    <input type="submit" value="Verificar">
</form>

<?php
if($_POST){
    $num = $_POST['num'];
    if($num % 2 == 0){
        echo "Valor divisível por 2";
    } else {
        echo "O valor não é divisível por 2";
    }
}
?>
</body>
</html>
