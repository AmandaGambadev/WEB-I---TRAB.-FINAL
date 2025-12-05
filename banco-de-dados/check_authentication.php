<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['id_usuario'])) {   // checa se 'id_usuario' existe para confirmar se o usuário está logado
  header('Location: /WEB-I---TRAB.-FINAL/jogo/index.php?error=not_logged_in');  // vai para a pág de login
  exit();
}
?>
