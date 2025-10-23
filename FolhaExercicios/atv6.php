<!DOCTYPE html>
<html>
<head>
    <title>Questão 6 - Feira do Joãozinho</title>
</head>
<body>
<form method="post">
    Maçã (R$/kg): <input type="number" step="0.01" name="maca_preco"> Quantidade (kg): <input type="number" step="0.01" name="maca_qtd"><br>
    Melancia (R$/kg): <input type="number" step="0.01" name="melancia_preco"> Quantidade (kg): <input type="number" step="0.01" name="melancia_qtd"><br>
    Laranja (R$/kg): <input type="number" step="0.01" name="laranja_preco"> Quantidade (kg): <input type="number" step="0.01" name="laranja_qtd"><br>
    Repolho (R$/kg): <input type="number" step="0.01" name="repolho_preco"> Quantidade (kg): <input type="number" step="0.01" name="repolho_qtd"><br>
    Cenoura (R$/kg): <input type="number" step="0.01" name="cenoura_preco"> Quantidade (kg): <input type="number" step="0.01" name="cenoura_qtd"><br>
    Batatinha (R$/kg): <input type="number" step="0.01" name="batata_preco"> Quantidade (kg): <input type="number" step="0.01" name="batata_qtd"><br>
    <input type="submit" value="Calcular total">
</form>

<?php
if($_POST){
    $total = ($_POST['maca_preco'] * $_POST['maca_qtd']) +
             ($_POST['melancia_preco'] * $_POST['melancia_qtd']) +
             ($_POST['laranja_preco'] * $_POST['laranja_qtd']) +
             ($_POST['repolho_preco'] * $_POST['repolho_qtd']) +
             ($_POST['cenoura_preco'] * $_POST['cenoura_qtd']) +
             ($_POST['batata_preco'] * $_POST['batata_qtd']);

    $saldo = 50;
    if($total > $saldo){
        $dif = $total - $saldo;
        echo "<p style='color:red'>Faltou R$ ".number_format($dif,2,',','.')."</p>";
    } elseif($total < $saldo){
        $sobrou = $saldo - $total;
        echo "<p style='color:blue'>Joãozinho ainda pode gastar R$ ".number_format($sobrou,2,',','.')."</p>";
    } else {
        echo "<p style='color:green'>Saldo esgotado! Valor total da compra R$ 50,00</p>";
    }
}
?>
</body>
</html>
