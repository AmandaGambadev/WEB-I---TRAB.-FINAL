<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['id_usuario'])) {
      $login = false;
      header("Location: /WEB-I---TRAB.-FINAL/jogo/index.php?error=login_falso");  // usuário não está logado
      exit();
  } else {
      $login = true;
      $id_usuario = $_SESSION['id_usuario'];
  }
?>
