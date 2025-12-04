<?php
require '../banco-de-dados/authenticate.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Shelter Cats - Jogo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/shelter-cats/css/style.css">
</head>
<body>
  <div class="container mt-4">
    <h1>Jogo — Shelter Cats</h1>

    <div class="mb-3">
      <button id="start-game-btn" class="btn btn-primary">Iniciar Jogo</button>
      <span class="ms-3">Pontuação: <strong id="score-display">0</strong></span>
      <span class="ms-3">Tempo restante: <strong id="time-display">120</strong>s</span>
    </div>

    <div class="game-area">
      <div id="cat-shelter" class="shelter-background">
        <img id="gato1" class="imagem-gato" src="/shelter-cats/figuras-e-sons/gato1.jpg" alt="Gato 1">
        <img id="gato2" class="imagem-gato" src="/shelter-cats/figuras-e-sons/gato2.jpg" alt="Gato 2">
        <img id="gato3" class="imagem-gato" src="/shelter-cats/figuras-e-sons/gato3.jpg" alt="Gato 3">
        <img id="gato4" class="imagem-gato" src="/shelter-cats/figuras-e-sons/gato4.jpg" alt="Gato 4">
        <img id="gato_feliz" class="imagem-gato" src="/shelter-cats/figuras-e-sons/gato_feliz.gif" alt="Gato feliz">
        <img id="gato_bravo1" class="imagem-gato" src="/shelter-cats/figuras-e-sons/gato_bravo1.gif" alt="Gato bravo 1">
        <img id="gato_bravo2" class="imagem-gato" src="/shelter-cats/figuras-e-sons/gato_bravo2.gif" alt="Gato bravo 2">
        <img id="gato_foi_embora" class="imagem-gato" src="/shelter-cats/figuras-e-sons/gato_foi_embora.gif" alt="Gato foi embora">
        <img id="comida1" class="imagem-comida" src="/shelter-cats/figuras-e-sons/comida1.jpg" alt="Comida 1">
        <img id="comida2" class="imagem-comida" src="/shelter-cats/figuras-e-sons/comida2.jpg" alt="Comida 2">
        <img id="comida3" class="imagem-comida" src="/shelter-cats/figuras-e-sons/comida3.jpg" alt="Comida 3">
        <img id="comida4" class="imagem-comida" src="/shelter-cats/figuras-e-sons/comida4.jpg" alt="Comida 4">
      </div>

      <div id="word-display" class="word-bubble"></div>

      <input type="text" id="game-input" placeholder="Digite as palavras corretamente para alimentar os gatinhos!" autocomplete="off" disabled class="form-control">
    </div>

    <hr>
    <h4>Histórico de partidas</h4>
    <ul id="history-list" class="list-group mb-4"></ul>
  </div>

  <audio id="musica_inicio" src="/shelter-cats/figuras-e-sons/musica_inicio.mp3" preload="auto"></audio>
  <audio id="som_gato_feliz" src="/shelter-cats/figuras-e-sons/som_gato_feliz.mp3" preload="auto"></audio>
  <audio id="som_gato_bravo" src="/shelter-cats/figuras-e-sons/som_gato_bravo.mp3" preload="auto"></audio>
  <audio id="som_gato_esperando" src="/shelter-cats/figuras-e-sons/som_gato_esperando.mp3" preload="auto"></audio>
  <audio id="som_gato_mastigando" src="/shelter-cats/figuras-e-sons/som_gato_mastigando.mp3" preload="auto"></audio>
  <audio id="musica_ganhou" src="/shelter-cats/figuras-e-sons/musica_ganhou.mp3" preload="auto"></audio>
  <audio id="musica_perdeu" src="/shelter-cats/figuras-e-sons/musica_perdeu.mp3" preload="auto"></audio>
  <audio id="musica_pontos" src="/shelter-cats/figuras-e-sons/musica_pontos.mp3" preload="auto"></audio>
  <audio id="musica_ligas" src="/shelter-cats/figuras-e-sons/musica_ligas.mp3" preload="auto"></audio>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="/shelter-cats/js/jogo.js"></script>
</body>
</html>
