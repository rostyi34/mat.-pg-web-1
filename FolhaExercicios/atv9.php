<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Questão 9 - Moto do Juquinha</title>
</head>
<body>
<h2>Moto do Juquinha</h2>
<p>Valor à vista: <strong>R$ 8.654,00</strong></p>
<p>Taxa inicial: 2% ao mês (aumenta 0,3% a cada nível)</p>
<p>Opções: 24x, 36x, 48x, 60x</p>

<form method="post">
    <input type="hidden" name="valor" value="8654">
    <input type="submit" value="Calcular Parcelas">
</form>

<?php
if($_POST){
    $valor = $_POST['valor'];
    $juros = 2.0;

    echo "<hr><h3>Resultados:</h3>";
    for($parcelas = 24; $parcelas <= 60; $parcelas += 12){
        $taxa = $juros / 100;
        $montante = $valor * pow((1 + $taxa), ($parcelas/12)); // juros compostos
        $parcela = $montante / $parcelas;
        echo "<p>$parcelas vezes de <strong>R$ ".number_format($parcela,2,',','.')."</strong> (juros: ".number_format($juros,1,',','.')."%)</p>";
        $juros += 0.3;
    }
}
?>
</body>
</html>
