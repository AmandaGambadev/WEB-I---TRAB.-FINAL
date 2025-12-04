<?php

require_once '../banco-de-dados/bancodedados.php';
require_once '../banco-de-dados/funcs.php';
check_user_logged_in();

$id_usuario = $_SESSION['id_usuario'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ================================
       CRIAR LIGA
    ==================================*/
    if (isset($_POST['action']) && $_POST['action'] === 'create_league') {
        $league_name = trim($_POST['league_name']);
        $league_keyword = trim($_POST['league_keyword']);

        if (!empty($league_name) && !empty($league_keyword)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO table_leagues (nome, palavra_chave, id_criador_liga) VALUES (?, ?, ?)");
                $stmt->execute([$league_name, $league_keyword, $id_usuario]);
                $new_league_id = $pdo->lastInsertId();

                $stmt = $pdo->prepare("INSERT INTO table_league_members (id_usuario, id_liga) VALUES (?, ?)");
                $stmt->execute([$id_usuario, $new_league_id]);

                $message = '<div class="alert alert-success">Liga "' . htmlspecialchars($league_name) . '" foi criada com sucesso.</div>';
            } catch (PDOException $e) {
                $message = '<div class="alert alert-danger">Erro ao criar liga.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Nome e palavra-chave são obrigatórios.</div>';
        }
    }

    /* ================================
       ENTRAR EM UMA LIGA EXISTENTE
    ==================================*/
    if (isset($_POST['action']) && $_POST['action'] === 'join_league') {
        $league_id = intval($_POST['league_id']);
        $keyword_attempt = trim($_POST['keyword_attempt']);

        $stmt = $pdo->prepare("SELECT palavra_chave FROM table_leagues WHERE id_liga = ?");
        $stmt->execute([$league_id]);
        $league = $stmt->fetch();

        if ($league && $league['palavra_chave'] === $keyword_attempt) {
            try {
                $stmt = $pdo->prepare("INSERT INTO table_league_members (id_usuario, id_liga) VALUES (?, ?)");
                $stmt->execute([$id_usuario, $league_id]);
                $message = '<div class="alert alert-success">Você entrou na liga!</div>';
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $message = '<div class="alert alert-warning">Você já faz parte dessa liga.</div>';
                } else {
                    $message = '<div class="alert alert-danger">Erro ao entrar na liga.</div>';
                }
            }
        } else {
            $message = '<div class="alert alert-danger">Palavra-chave incorreta ou a liga não existe.</div>';
        }
    }
}

/* ================================
   LIGAS EM QUE O USUÁRIO PARTICIPA
===================================*/

$stmt = $pdo->prepare("
    SELECT l.id_liga, l.nome, l.criada_em
    FROM table_leagues AS l
    JOIN table_league_members AS lm ON l.id_liga = lm.id_liga
    WHERE lm.id_usuario = ?
");
$stmt->execute([$id_usuario]);
$my_leagues = $stmt->fetchAll();

$stmt_all = $pdo->query("SELECT id_liga, nome FROM table_leagues");
$all_leagues = $stmt_all->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>Ligas de Voluntáries</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container mt-4">
    <h1>Ligas</h1>
    <a href="inicio.php">Voltar ao painel</a>
    <hr>
    <?php echo $message; ?>

    <div class="row">
       <div class="col-md-4">
       <h2>Criar uma nova liga</h2>
       <form action="ligas.php" method="POST">
          <input type="hidden" name="action" value="create_league">
          <div class="mb-2"><input type="text" name="league_name" class="form-control" placeholder="Nome da Liga" required></div>
          <div class="mb-2"><input type="text" name="league_keyword" class="form-control" placeholder="Palavra-chave" required></div>
          <button type="submit" class="btn btn-success">Criar Liga</button>
        </form>
        <hr>
        <h3>Entrar em uma Liga</h3>
        <form action="ligas.php" method="POST">
        <input type="hidden" name="action" value="join_league">
        <div class="mb-2">
            <select name="league_id" class="form-select">
                <?php foreach($all_leagues as $league): ?>
                  <option value="<?php echo $league['id_liga']; ?>"><?php echo htmlspecialchars($league['nome']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2"><input type="text" name="keyword_attempt" class="form-control" placeholder="Palavra-chave" required></div>
        <button type="submit" class="btn btn-primary">Entrar na Liga</button>
      </form>
    </div>

    <div class="col-md-8">
      <h4>Suas Ligas</h4>
      <ul class="list-group">
        <?php if (empty($my_leagues)): ?>
          <li class="list-group-item">Você ainda não participa de nenhuma liga.</li>
        <?php else: ?>
          <?php foreach($my_leagues as $league): ?>
            <li class="list-group-item">
              <strong><?php echo htmlspecialchars($league['nome']); ?></strong>
              <small class="text-muted">(Criada em: <?php echo date('d/m/y', strtotime($league['criada_em'])); ?>)</small>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>
</body>
</html>
