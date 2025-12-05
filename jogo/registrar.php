<?php
$feedback_message = '';
$feedback_type = '';

if (isset($_GET['error'])) {
  if ($_GET['error'] === 'empty_fields') {
    $feedback_message = 'Por favor, preencha todos os campos.';
    $feedback_type = 'danger';
  } elseif ($_GET['error'] === 'user_exists') {
    $feedback_message = 'Este nome de voluntário já existe. Tente outro!';
    $feedback_type = 'warning';
  } elseif ($_GET['error'] === 'registration_failed') {
    $feedback_message = 'Erro ao registrar. Tente novamente mais tarde.';
    $feedback_type = 'danger';
  }
}

if (isset($_GET['success'])) {
  if ($_GET['success'] === 'registered') {
    $feedback_message = 'Perfil criado com sucesso! Faça o login agora.';
    $feedback_type = 'success';
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Shelter Cats: venha se voluntariar no abrigo de gatinhos!</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="text-center">
  <main class="form-signin w-100 m-auto">
    <form action="../banco-de-dados/registro.php" method="POST">
      <h1 class="h3 mb-3 fw-normal">Alimente um gatinho!</h1>
      <p>Crie uma conta para começar a alimentar os gatos que moram no abrigo.</p>

      <?php if (!empty($feedback_message)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($feedback_type); ?> alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($feedback_message); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="form-floating mb-2">
        <input type="text" class="form-control" id="id_usuario" name="user_usuario" placeholder="Seu nome aqui" required>
        <label for="user_usuario">Nome de Voluntário</label>
      </div>
      <div class="form-floating mb-2">
        <input type="senha" class="form-control" id="senha" name="senha" placeholder="Sua senha" required>
        <label for="senha">Senha</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Criar conta</button>
      <p class="mt-3">Já tem uma conta? <a href="index.php">Fazer o login.</a></p>
    </form>
  </main>
</body>
</html>
