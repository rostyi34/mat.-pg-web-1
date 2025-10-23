<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Questão 7 - Carro da Mariazinha</title>
</head>
<body>
<h2>Carro da Mariazinha</h2>
<p>Valor à vista: <strong>R$ 22.500,00</strong><br>
60 parcelas de <strong>R$ 489,65</strong></p>

<form method="post">
    <input type="hidden" name="avista" value="22500">
    <input type="hidden" name="parcela" value="489.65">
    <input type="hidden" name="meses" value="60">
    <input type="submit" value="Calcular Juros">
</form>

<?php
if($_POST){
    $avista = $_POST['avista'];
    $parcela = $_POST['parcela'];
    $meses = $_POST['meses'];
    
    $total = $parcela * $meses;
    $juros = $total - $avista;

    echo "<hr>";
    echo "<p>Valor total pago: <strong>R$ ".number_format($total,2,',','.')."</strong></p>";
    echo "<p>Valor dos juros: <strong>R$ ".number_format($juros,2,',','.')."</strong></p>";
}
?>
</body>
</html>
