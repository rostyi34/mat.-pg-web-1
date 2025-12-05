<?php

require_once __DIR__ . '/../src/perguntas.php';


$perguntas = fetch_perguntas();
?>
<!doctype html>

<link rel="stylesheet" href="css/style.css">

<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Avaliação de Serviços</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <h1>Avalie nossos serviços</h1>

    <form id="formAvaliacao" action="../src/respostas.php" method="post" novalidate>
      <div id="perguntas">
        <?php if (empty($perguntas)): ?>
          <p>Sem perguntas cadastradas no momento.</p>
        <?php else: ?>
          <?php foreach ($perguntas as $p): ?>
            <div class="pergunta" data-pergunta-id="<?= htmlspecialchars($p['id']) ?>">
              <label class="texto"><?= htmlspecialchars($p['texto']) ?></label>
              <div class="escala">
                <?php
                // Renderiza 0..10 como rádio — atende requisito 0-10
                for ($i = 0; $i <= 10; $i++): ?>
                  <label class="radio">
                    <input type="radio"
                           name="respostas[<?= $p['id'] ?>]"
                           value="<?= $i ?>"
                           required>
                    <span class="val"><?= $i ?></span>
                  </label>
                <?php endfor; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <div class="feedback">
        <label for="feedback">Feedback opcional (deixe em branco se não quiser):</label>
        <textarea name="feedback" id="feedback" rows="4" placeholder="Escreva seu comentário..."></textarea>
      </div>

      
      <input type="hidden" name="dispositivo_id" value="1">

      <p class="anonimo">Sua avaliação é anônima — nenhuma informação pessoal é solicitada ou armazenada.</p>

      <div class="acoes">
        <button type="submit" id="btnEnviar">Enviar avaliação</button>
      </div>
    </form>

  </main>

  <script src="js/script.js"></script>
</body>
</html>
