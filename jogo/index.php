<?php

require_once '../banco-de-dados/bancodedados.php';

if (isset($_SESSION['id_usuario'])) {   // verifica se a sessão já está ativa
  header('Location: /WEB-I---TRAB.-FINAL/jogo/inicio.php');
  exit();
}

$feedback_message = '';  // mensagens de aviso ao usuário

if (isset($_GET['error'])) {
  if ($_GET['error'] === 'invalid_login') {
    $feedback_message = 'Nome de voluntárie ou senha inválidos.';
  } elseif ($_GET['error'] === 'not_logged_in') {
    $feedback_message = 'Você precisa fazer o login para poder começar a jogar.';
  }
}

if (isset($_GET['success'])) {
  if ($_GET['success'] === 'registered') {
    $feedback_message = 'O seu perfil foi criado com sucesso. Faça o login agora para começar a jogar!';
  }
}

if (isset($_GET['status'])) {
  if ($_GET['status'] === 'logout_success') {
    $feedback_message = 'Logout concluído.';
  }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Shelter Cats - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="auth-container card">
    <h1>Abrigo de gatinhos</h1>
    <p>Bem-vindo de volta, voluntário!</p>

    <?php
    if (!empty($feedback_message)) {
      echo $feedback_message;
    }
    ?>

    <form action="../banco-de-dados/login.php" method="POST">
      <div class="form-group mb-3">
        <label for="username" class="form-label">Nome do Voluntário</label>
        <input type="text" id="username" name="username" class="form-input" required>
      </div>

      <div class="form-group mb-4">
        <label for="password" class="form-label">Senha</label>
        <input type="password" id="password" name="password" class="form-input" required>
      </div>

      <button type="submit" class="btn-principal" style="width: 100%;">Entrar no Abrigo</button>
    </form>

    <p class="mt-4">
      Ainda não é um voluntário?
      <a href="registrar.php">Crie o seu perfil</a>
    </p>
  </div>
</body>
</html>
