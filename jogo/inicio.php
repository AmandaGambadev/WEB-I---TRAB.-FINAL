<?php
 require '../banco-de-dados/authenticate.php';
 require_once '../banco-de-dados/bancodedados.php';
 //require_once '../banco-de-dados/check_authentication.php';

 // Buscar Top 5 Geral Semanal para o Dashboard
 $stmt_rank = $pdo->prepare("
    SELECT u.user_usuario, SUM(p.pontos) as total
    FROM table_matches p
    JOIN table_users u ON p.id_usuario = u.id_usuario
    WHERE p.jogado >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    GROUP BY u.id_usuario
    ORDER BY total DESC
    LIMIT 5
");
$stmt_rank->execute();
$ranking_geral = $stmt_rank->fetchAll();

// Buscar Histórico Recente do Usuário
$stmt_hist = $pdo->prepare("SELECT pontos, jogado FROM table_matches WHERE id_usuario = ? ORDER BY jogado DESC LIMIT 5");
$stmt_hist->execute([$_SESSION['id_usuario']]);
$meu_historico = $stmt_hist->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Shelter Cats - Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/shelter-cats/css/style.css">
</head>
<body>
  <div class="container mt-4">
    <h1>Bem-vinde, Voluntárie <?php echo htmlspecialchars($_SESSION['user_usuario']); ?>!</h1>
    <p>Os gatinhos do abrigo precisam de você. Está preparade?</p>

    <a href="jogo.php" class="btn btn-success btn-lg">Bora se voluntariar (Jogar)</a>
    <a href="ligas.php" class="btn btn-info">Ver Ligas</a>
    <a href="../jogo/logout.php" class="btn btn-danger">Sair</a>

    <div class="row mt-5">
      <div class="col-md-6">
        <h2>Quadro Geral com Pontuação Semanal</h2>
        <ul class="list-group">
          <?php if (empty($ranking_geral)): ?>
            <li class="list-group-item">Nenhuma partida esta semana.</li>
          <?php else: ?>
            <?php foreach ($ranking_geral as $index => $jogador): ?>
              <li class="list-group-item">
                <strong><?php echo ($index + 1); ?>º.</strong>
                <?php echo htmlspecialchars($jogador['user_usuario']); ?> -
                <?php echo $jogador['total']; ?> pontos
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
      <div class="col-md-6">
        <h3>Histórico de partidas</h3>
        <ul class="list-group">
          <?php if (empty($meu_historico)): ?>
            <li class="list-group-item">Você ainda não jogou nenhuma partida.</li>
          <?php else: ?>
            <?php foreach ($meu_historico as $partida): ?>
              <li class="list-group-item">
                <?php echo date('d/m/y H:i', strtotime($partida['jogado'])); ?> -
                <?php echo $partida['pontos']; ?> pontos
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</body>
</html>
