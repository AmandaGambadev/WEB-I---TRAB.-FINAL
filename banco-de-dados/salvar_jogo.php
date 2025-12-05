<?php

 require_once '../banco-de-dados/bancodedados.php';

 header('Content-Type: application/json');
 
 // sessão iniciada
 // coleta o ID do usuário
 if(session_status() === PHP_SESSION_NONE) {
     session_start();
 }

 // verificação de login
 if (!isset($_SESSION['id_usuario'])){
     echo json_encode(['success' => false, 'error' => 'O usuário não foi autenticado.']);
     exit();
 }
 
 // coleta os dados do usuário pelo JS
 $inputJSON = file_get_contents('php://input');
 $input = json_decode($inputJSON, true);
 
 $score = $input['pontos'] ?? 0;
 $wpm = $input['palavras_minuto'] ?? 0;
 $accuracy = $input['ortografia'] ?? 0;
 $id_usuario = $_SESSION['id_usuario']; // coleta o ID da sessão

 if ($score <= 0 || $wpm < 0 || $accuracy < 0 || $accuracy > 100) {
   echo json_encode(['success' => false, 'error' => 'Os dados são inválidos.']);
   exit();
 }

 // inserção com PDO na tabela 'table_matches'
 try {
   $stmt = $pdo->prepare(
     "INSERT INTO table_matches (id_usuario, pontos, palavras_minuto, ortografia, jogado) VALUES (?, ?, ?, ?, NOW())"
   );
  
   $stmt->execute([$id_usuario, $score, $wpm, $accuracy]);

   echo json_encode([
     'success' => true,
     'message' => 'A partida foi salva!',
     'new_game_score' => $score
   ]);
 
 // se bd der erro, retorna com JSON
 } catch (PDOException $e) {
   echo json_encode(['success' => false, 'error' => 'Erro! Não foi possível salvar a partida.']);
 }
 ?>
