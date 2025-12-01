<?php

require_once 'bancodedados.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {   // verifica o método
  header('Location: ../jogo/index.php');
  exit();
}

$username = $_POST['username'] ?? '';  // validação do login
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
  header('Location: ../jogo/index.php?error=empty_fields');
  exit();
}

$stmt = $mysqli->prepare("SELECT id_usuario, user_usuario, senha FROM table_users WHERE user_usuario = ?");  // consulta sql

if ($stmt === false) {
  die("Erro! Não foi possível fazer a consulta: " . $mysqli->error);
}

$stmt->bind_param("s", $username);  // "s" indica que é string

if ($stmt->execute()) {  // a consulta é feita
  $result = $stmt->get_result();  // resultado

  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['senha'])) {  // verifica username e senha
    session_regenerate_id(true);
    $_SESSION['id_usuario'] = $user['id_usuario'];
    $_SESSION['user_usuario'] = $user['user_usuario'];

    header('Location: ../jogo/inicio.php');
    exit();
  } else {
    header('Location: ../jogo/index.php?error=invalid_login');
    exit();
  }
} else {
  header('Location: ../jogo/index.php?error=db_error');
  exit();
}

$stmt->close();
$mysqli->close();

?>
