<?php

 require_once 'bancodedados.php'; // conexão pdo

 if ($_SERVER['REQUEST METHOD'] !== 'POST') {
     header('Location: ../jogo/index.php');
     exit();
 }
 
 $username = $_POST['username'] ?? '';
 $password = $_POST['password'] ?? '';
 
 // validação
 if (empty($username) || empty($password)) {
     header('Location: ../jogo/index.php?error=empty_fields');
     exit();
 }
 
 // consulta com pdo em $stmt
 try {
     $stmt = $pdo->prepare("SELECT id_usuario, user_usuario, senha FROM table_users WHERE user_usuario = ?");
     
     // execução com array
     $stmt->execute([$username]);
     
     // busca a resposta 
     $user = $stmt->fetch();
     
     // checa se o usuário e senha existem/estão certos
     if ($user && password_verify($password, $user['senha'])) {
         // faz login
         session_regenerate_id(true); // novo ID usado para abrir o jogo
         $_SESSION['id_usuario'] = $user['id_usuario'];
         $_SESSION['user_usuario'] = $user['user_usuario'];
         
         header('Location: ../jogo/inicio.php');
         exit();
     } else {
         // se o usuário/senha não existem/estão incorretos
         header('Location: ../jogo/index.php?error=invalid_login');
         exit();   
     }
     
 } catch (PDOException $e) {
     // se o bd der erro
     header('Location: ../jogo/index.php?error=db_error');
     exit();
 }
 ?> 
