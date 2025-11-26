<?php
require "../includes/conexao.php";
$busca="";
if(isset($_GET['busca'])) $busca=filter_var($_GET['busca'],FILTER_SANITIZE_SPECIAL_CHARS);

if($busca!=""){
$sql="SELECT * FROM TBPESSOA WHERE PESNOME ILIKE $1 ORDER BY PESCODIGO DESC";
$params=array("%$busca%");
$result=pg_query_params($conn,$sql,$params);
}else{
$sql="SELECT * FROM TBPESSOA ORDER BY PESCODIGO DESC";
$result=pg_query($conn,$sql);
}
?>
<!DOCTYPE html><html><head>
<meta charset="UTF-8"><title>Listagem</title>
<link rel="stylesheet" href="../assets/style.css">
</head><body>
<div class="container">
<h2>Pessoas Cadastradas</h2>
<form method="GET">
<input type="text" name="busca" placeholder="Buscar por nome..." value="<?= $busca ?>">
<button type="submit">Pesquisar</button>
</form>
<a class="link-btn" href="cadastro.php">Cadastrar Nova Pessoa</a>
<table>
<tr><th>ID</th><th>Nome</th><th>Email</th><th>Cidade</th></tr>
<?php while($r=pg_fetch_assoc($result)){ ?>
<tr>
<td><?= htmlspecialchars($r['pescodigo']) ?></td>
<td><?= htmlspecialchars($r['pesnome']." ".$r['pessobrenome']) ?></td>
<td><?= htmlspecialchars($r['pesemail']) ?></td>
<td><?= htmlspecialchars($r['pescidade']) ?></td>
</tr>
<?php } ?>
</table>
</div></body></html>