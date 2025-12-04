<?php

require_once 'bancodedados.php';

$username = $_POST['user_usuario'] ?? '';
$password = $_POST['senha'] ?? '';

if (empty($username) || empty($password)) {
  header('Location: ../banco-de-dados/registro.php?error=invalid_data');
  exit();
}

$password_HASH = password_hash($password, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO table_users (user_usuario, senha) VALUES (?, ?)");

$stmt->bind_param("ss", $username, $password_HASH);  // duas variáveis de string

if ($stmt->execute()) {
  header('Location: ../jogo/index.php?success=registered');
} else {
  if ($mysqli->errno === 1062) {
    header('Location: ../jogo/registrar.php?error=user_exists');
  } else {
    die("Erro! Não foi possível registrar sua conta: " . $stmt->error);
  }
}

$stmt->close();
$mysqli->close();

?>
