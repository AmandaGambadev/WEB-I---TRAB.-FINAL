<?php

$db_host = "localhost";
$db_name = "shelter_cats";
$db_user = "root";
$db_password = "";

if (session_status() === PHP_SESSION_NONE) {  // inicia a sessão
  session_start();
}

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);  // conexão com mysqli

if ($mysqli->connect_error) {
  die("Erro! Não foi possível se conectar com o banco de dados: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");

// Criar conexão PDO para arquivos que usam PDO
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
