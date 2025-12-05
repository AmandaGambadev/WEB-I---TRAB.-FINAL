<?php

if (session_status() === PHP_SESSION_NONE) {  
  session_start();
}

// Configurações de conexão
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shelter_cats";

try {
  // Criação da conexão PDO
  $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_password);
  
  // Em caso de erro SQL
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  // Definição do retorno padrão
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  
  // Criação do BD (caso ainda não exista)
  $sql_db = "CREATE DATABASE IF NOT EXISTS $db_name";
  $pdo->exec($sql_db);
  
  // Conexão com o DB shelter_cats
  $pdo->exec("USE $db_name");
  
} catch (Exception $ex) {
  // Interrupção segura caso a conexão falhe 
  die("Erro! Não foi possível se conectar com o banco de dados. Tente novamente mais tarde.");
}

?>
