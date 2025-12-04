$(document).ready(function () {
  // lista de palavras (pode ajustar)
  const words = [
    "gatite",
    "ronronar",
    "pãozinho",
    "patinhas",
    "felino",
    "miau",
    "siamês",
    "arranhador",
    "bolinho",
    "ragdoll",
    "caixa de areia",
    "bola de pelo",
    "miado",
    "abrigo de gatos",
    "brincar",
    "frajolinha",
    "gato preto",
    "pular",
    "persa",
    "tricolor",
    "rajadinho",
    "petisco",
    "bigodes",
    "soninho",
    "fofo",
  ];

  let currentWordIndex = -1;
  let score = 0;
  let timerInterval = null;
  let timeLeft = 120;
  let wordTimeout = null;

  // imagens dos gatos (usando seletores corretos)
  const catImages = {
    esperando: ["#gato1", "#gato2", "#gato3", "#gato4"],
    feliz: $("#gato_feliz"),
    bravo1: $("#gato_bravo1"),
    bravo2: $("#gato_bravo2"),
    foi_embora: $("#gato_foi_embora"),
  };

  // imagens de comida (todas começam escondidas)
  const foodImages = {
    comida1: $("#comida1"),
    comida2: $("#comida2"),
    comida3: $("#comida3"),
    comida4: $("#comida4"),
  };

  Object.values(foodImages).forEach((img) => img.hide());

  // sons (pegamos o elemento <audio> e o primeiro item [0])
  const sounds = {
    esperando: $("#som_gato_esperando")[0],
    feliz: $("#som_gato_feliz")[0],
    bravo: $("#som_gato_bravo")[0],
    mastigando: $("#som_gato_mastigando")[0],
  };

  const wordDisplay = $("#word-display");
  const gameInput = $("#game-input");

  function setCatState(state) {
    $(".imagem-gato").removeClass("visible");
    if (state === "esperando") {
      const randomCat =
        catImages.esperando[
          Math.floor(Math.random() * catImages.esperando.length)
        ];
      $(randomCat).addClass("visible");
      return;
    }

    if (catImages[state]) {
      catImages[state].addClass("visible");
    }
  }

  function showRandomFood() {
    // esconder todas antes de mostrar uma
    Object.values(foodImages).forEach((img) => img.hide());

    const keys = Object.keys(foodImages);
    const randomKey = keys[Math.floor(Math.random() * keys.length)];

    foodImages[randomKey].fadeIn(150); // aparece suavemente
  }

  function hideAllFood() {
    Object.values(foodImages).forEach((img) => img.hide());
  }

  function pickNextWordRandom() {
    currentWordIndex = Math.floor(Math.random() * words.length);
    return words[currentWordIndex];
  }

  function showNextWord() {
    clearTimeout(wordTimeout);
    setCatState("esperando");
    hideAllFood();

    // escolher palavra aleatória
    const nextWord = pickNextWordRandom();
    wordDisplay.text(nextWord).removeClass("correct-word incorrect-word");
    gameInput.val("").focus();

    // tocar som de miado/espera
    if (sounds.esperando) {
      try {
        sounds.esperando.currentTime = 0;
        sounds.esperando.play();
      } catch (e) {
        /* ignore */
      }
    }

    // tempo para digitar a palavra (5s aqui)
    wordTimeout = setTimeout(() => {
      if (sounds.esperando)
        try {
          sounds.esperando.pause();
        } catch (e) {}
      setCatState("foi_embora");
      wordDisplay.text("Vixe! Parece que você demorou demais :(");
      setTimeout(showNextWord, 1500);
    }, 5000);
  }

  function startGame() {
    // evitar múltiplos timers
    if (timerInterval) clearInterval(timerInterval);

    score = 0;
    timeLeft = 120;
    $("#score-display").text(score);
    $("#time-display").text(timeLeft);
    gameInput.prop("disabled", false).val("").focus();

    showNextWord();

    timerInterval = setInterval(() => {
      timeLeft--;
      $("#time-display").text(timeLeft);
      if (timeLeft <= 0) {
        endGame();
      }
    }, 1000);

    setCatState("esperando");
  }

  function endGame() {
    clearInterval(timerInterval);
    timerInterval = null;
    clearTimeout(wordTimeout);
    gameInput.prop("disabled", true);
    // mostrar pontuação com template literal
    alert(`O jogo acabou!! A sua pontuação é: ${score}`);
    saveScore(score);
  }

  function saveScore(finalScore) {
    const wpm = Math.round(finalScore / 5);
    const accuracy = 98.5;

    $.ajax({
      url: "/shelter-cats/banco-de-dados/salvar_jogo.php",
      type: "POST",
      dataType: "json",
      data: {
        pontos: finalScore,
        palavras_minuto: wpm,
        ortografia: accuracy,
      },
    })
      .done(function (response) {
        if (response && response.success) {
          alert("A pontuação foi salva com sucesso.");
          // prepend com template literal
          $("#history-list").prepend(
            `<li class="list-group-item">Nova partida: ${
              response.new_game_score || finalScore
            } pontos</li>`
          );
        } else {
          alert(
            "Erro! Pontuação não foi salva: " +
              (response && response.error
                ? response.error
                : "resposta inválida")
          );
        }
      })
      .fail(function () {
        alert("Erro! Não foi possível se comunicar com o servidor.");
      });
  }

  // evento start (apenas um binding)
  $("#start-game-btn")
    .off("click")
    .on("click", function () {
      startGame();
    });

  // validação enquanto digita
  gameInput.on("input", function () {
    const typedText = $(this).val();
    const targetWord = wordDisplay.text();

    if (!targetWord) return;

    // se o texto digitado não for prefixo (começo) da palavra target
    if (!targetWord.startsWith(typedText)) {
      wordDisplay.addClass("incorrect-word");
      // mostrar gato bravo (usar um dos dois gifs bravo)
      setCatState("bravo1");
      if (sounds.bravo) {
        try {
          sounds.bravo.currentTime = 0;
          sounds.bravo.play();
        } catch (e) {}
      }

      // bloquear input por 800ms e limpar
      gameInput.prop("disabled", true);
      setTimeout(() => {
        gameInput.prop("disabled", false).val("");
        wordDisplay.removeClass("incorrect-word");
        setCatState("esperando");
        hideAllFood();
      }, 800);

      // cancelar o timeout atual e agendar próxima palavra em breve
      clearTimeout(wordTimeout);
      wordTimeout = setTimeout(showNextWord, 900);
      return;
    }

    // se digitou a palavra inteira corretamente
    if (typedText === targetWord) {
      clearTimeout(wordTimeout);
      hideAllFood();
      if (sounds.esperando)
        try {
          sounds.esperando.pause();
        } catch (e) {}
      if (sounds.feliz) {
        try {
          sounds.feliz.currentTime = 0;
          sounds.feliz.play();
        } catch (e) {}
      }
      setCatState("feliz");
      wordDisplay.addClass("correct-word");

      score += 10;
      $("#score-display").text(score);

      showRandomFood();
      if (sounds.mastigando) {
        try {
          sounds.mastigando.currentTime = 0;
          sounds.mastigando.play();
        } catch (e) {}
      }

      setTimeout(() => {
        hideAllFood();
        showNextWord();
      }, 1000);
    }
  });
});
