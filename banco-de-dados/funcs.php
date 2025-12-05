<?php

function check_user_logged_in() {   // verificação de login do usuário
  if (!isset($_SESSION['id_usuario'])) {
    header('Location: /WEB-I---TRAB.-FINAL/jogo/index.php?error=denied_access');
    exit();
  }
}

function get_username_by_id($pdo, $id_usuario) {
  $stmt = $pdo->prepare("SELECT user_usuario FROM table_users WHERE id_usuario = ?");
  $stmt->execute([$id_usuario]);
  $result = $stmt->fetch();
  return $result ? $result['user_usuario'] : 'Voluntárie não encontrade';
}

?>
