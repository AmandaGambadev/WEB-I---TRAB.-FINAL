<?php
/**
 * PASSO 1: INICIAR A SESSÃO
 * Essencial para usar $_SESSION e manter o usuário logado entre as páginas.
 */
session_start();

/**
 * PASSO 2: INCLUIR A CONEXÃO COM O BANCO
 * O arquivo 'bancodedados.php' cria a variável de conexão $pdo usando PDO.
 */
require_once 'bancodedados.php';

/**
 * PASSO 3: VALIDAR O MÉTODO DA REQUISIÇÃO
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../jogo/index.php');
    exit();
}

/**
 * PASSO 4: COLETAR E VALIDAR OS DADOS DO FORMULÁRIO
 */
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header('Location: ../jogo/index.php?error=empty_fields');
    exit();
}

/**
 * PASSO 5: CONSULTAR O BANCO DE DADOS DE FORMA SEGURA
 * Usando prepared statements com PDO para prevenir SQL Injection.
 */
try {
    $stmt = $pdo->prepare("SELECT id_usuario, user_usuario, senha FROM table_users WHERE user_usuario = ?");
    
    // Execução com array (PDO)
    $stmt->execute([$username]);
    
    // Busca a resposta
    $user = $stmt->fetch();
    
    // Checa se o usuário existe E se a senha está correta
    if ($user && password_verify($password, $user['senha'])) {
        // SUCESSO NO LOGIN!
        
        session_regenerate_id(true);
        
        // Armazena os dados do usuário na sessão.
        $_SESSION['id_usuario'] = $user['id_usuario'];
        $_SESSION['user_usuario'] = $user['user_usuario'];
        $_SESSION['loggedin'] = true;
        
        // Redireciona para a página principal do jogo.
        header('Location: ../jogo/inicio.php');
        exit();
    } else {
        // FALHA NO LOGIN: Usuário ou senha inválidos.
        header('Location: ../jogo/index.php?error=invalid_login');
        exit();   
    }
    
} catch (PDOException $e) {
    // Se o BD der erro
    error_log("Erro na consulta de login: " . $e->getMessage());
    header('Location: ../jogo/index.php?error=db_error');
    exit();
}
?>
