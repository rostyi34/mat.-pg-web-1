<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"><title>Cadastrar Pessoa</title>
<link rel="stylesheet" href="../assets/style.css">
</head><body>
<div class="container">
<h2>Cadastrar Pessoa</h2>
<form action="gravar.php" method="POST">
<input type="text" name="nome" placeholder="Nome" required>
<input type="text" name="sobrenome" placeholder="Sobrenome">
<input type="email" name="email" placeholder="Email">
<input type="password" name="senha" placeholder="Senha">
<input type="text" name="cidade" placeholder="Cidade">
<input type="text" name="estado" placeholder="Estado (UF)" maxlength="2">
<button type="submit">Salvar</button>
</form>
<a class="link-btn" href="listar.php">Ver Pessoas</a>
</div></body></html>