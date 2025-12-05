<?php

require_once '../banco-de-dados/bancodedados.php';
require_once '../banco-de-dados/funcs.php';
check_user_logged_in();

$id_usuario = $_SESSION['id_usuario'];

// coleta os dados da tabela 'table_matches'
$stmt = $pdo->prepare("SELECT pontos, jogado FROM table_matches WHERE id_usuario = ? ORDER BY jogado DESC");
$stmt->execute([$id_usuario]);
$matches = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>Histórico de Partidas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container m-4">
    <h1>Histórico de Voluntariado</h1>
    <a href="inicio.php" class="btn btn-secondary mb-3">Voltar ao Painel</a>
    
    <div class="card"
         <div class="card-body">
             <table class="table table-striped table-hover">
                 <thead class="table-dark">
                     <tr>
                         <th>Data e Hora</th>
                         <th>Pontuação</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php if (empty($matches)): ?>
                     <tr>
                         <td colspan="2" class="text-center p-4">
                             <strong>Você ainda não jogou uma partida.</strong>
                             Os gatinhos estão te esperando!
                         </td>
                     </tr>
                     <?php else: ?>
                      <?php foreach ($matches as $match): ?>
                       <tr> 
                           <td><?php echo date('d/m/Y H:i', strtotime($match['jogado'])); ?></td>
                           <td><span class="badge bg-primary rounded-pill"><?php echo $match['pontos']; ?> pts</span></td>
                     </tr>
                    <?php endforeach; ?>
                   <?php endif; ?>
                 </tbody> 
             </table>
        </div>
  </div>
  </body>
  </html>
