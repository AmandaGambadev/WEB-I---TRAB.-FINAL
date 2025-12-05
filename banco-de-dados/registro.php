<?php
/**
 * PASSO 1: INCLUIR A CONEXÃO COM O BANCO
 * O arquivo 'bancodedados.php' cria a variável de conexão $pdo usando PDO.
 */
require_once 'bancodedados.php';

/**
 * PASSO 2: VALIDAR O MÉTODO DA REQUISIÇÃO
 * Garante que o script só seja acessado via formulário (método POST).
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../jogo/registrar.php');
    exit();
}

/**
 * PASSO 3: COLETAR E VALIDAR OS DADOS DO FORMULÁRIO
 */
$username = $_POST['user_usuario'] ?? '';
$password = $_POST['senha'] ?? '';

if (empty($username) || empty($password)) {
    header('Location: ../jogo/registrar.php?error=empty_fields');
    exit();
}

/**
 * PASSO 4: CRIAR O HASH DA SENHA
 * NUNCA armazene senhas em texto plano. password_hash é a forma correta e segura.
 */
$password_HASH = password_hash($password, PASSWORD_DEFAULT);

/**
 * PASSO 5: PREPARAR E EXECUTAR A INSERÇÃO NO BANCO
 * Usa prepared statements para prevenir SQL Injection.
 */
try {
    $stmt = $pdo->prepare("INSERT INTO table_users (user_usuario, senha) VALUES (?, ?)");
    $stmt->execute([$username, $password_HASH]);
    
    // SUCESSO NO REGISTRO!
    // Redireciona para a página de login com uma mensagem de sucesso.
    header('Location: ../jogo/index.php?success=registered');
    exit();
} catch (PDOException $e) {
    // FALHA NO REGISTRO
    if (strpos($e->getMessage(), '1062') !== false || strpos($e->getMessage(), 'UNIQUE') !== false) {
        // Erro de duplicação - usuário já existe
        header('Location: ../jogo/registrar.php?error=user_exists');
        exit();
    } else {
        // Para qualquer outro erro
        error_log("Erro ao registrar usuário: " . $e->getMessage());
        header('Location: ../jogo/registrar.php?error=registration_failed');
        exit();
    }
}
?>
