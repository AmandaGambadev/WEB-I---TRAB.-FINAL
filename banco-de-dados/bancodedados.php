<?php

$db_host = "localhost";
$db_name = "shelter_cats";
$db_user = "root";
$db_password = "";

 if (session_status() === PHP_SESSION_NONE) {  // inicia a sessão
   session_start();
 }

 try {
     // criação da conexão pdo
     $pdo = new
 PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_password);
    
     // em caso de erro SQL
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     // definição do retorno padrão
     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
  } catch (Exception $ex) {
      // interrupção segura caso a conexão falhe 
      die("Erro! Não foi possível se conectar com o banco de dados. Tente novamente mais tarde.");
  }

 ?>
