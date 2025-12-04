<?php
/**
 * PASSO 1: INCLUIR A CONEXÃO COM O BANCO
 * O arquivo 'bancodedados.php' cria a variável de conexão $conn.
 */
require_once 'bancodedados.php';

/**
 * PASSO 2: VALIDAR O MÉTODO DA REQUISIÇÃO (MELHORIA)
 * Garante que o script só seja acessado via formulário (método POST).
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se o acesso não for via POST, redireciona para a página de registro.
    header('Location: ../jogo/registrar.php');
    exit();
}

/**
 * PASSO 3: COLETAR E VALIDAR OS DADOS DO FORMULÁRIO
 */
$username = $_POST['user_usuario'] ?? '';
$password = $_POST['senha'] ?? '';

// Verifica se os campos de usuário ou senha estão vazios.
if (empty($username) || empty($password)) {
    // Redireciona de volta com uma mensagem de erro.
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
// CORREÇÃO: Usando a variável $conn, que vem do seu arquivo de conexão.
$stmt = $conn->prepare("INSERT INTO table_users (user_usuario, senha) VALUES (?, ?)");

// Verifica se a preparação da consulta falhou.
if ($stmt === false) {
    error_log("Erro na preparação da consulta de registro: " . $conn->error);
    header('Location: ../jogo/registrar.php?error=db_error');
    exit();
}

// Associa as variáveis aos placeholders. "ss" significa duas strings.
$stmt->bind_param("ss", $username, $password_HASH);

// Tenta executar a consulta.
if ($stmt->execute()) {
    // SUCESSO NO REGISTRO!
    // Redireciona para a página de login com uma mensagem de sucesso.
    header('Location: ../jogo/index.php?success=registered');
    exit();
} else {
    // FALHA NO REGISTRO.
    // CORREÇÃO: Verificando o código de erro através de $conn.
    if ($conn->errno === 1062) {
        // Erro 1062 é "Entrada duplicada". Significa que o usuário já existe.
        header('Location: ../jogo/registrar.php?error=user_exists');
        exit();
    } else {
        // Para qualquer outro erro, registra no log e dá uma mensagem genérica.
        error_log("Erro ao registrar usuário: " . $stmt->error);
        header('Location: ../jogo/registrar.php?error=registration_failed');
        exit();
    }
}

/**
 * PASSO 6: FECHAR A CONEXÃO
 */
$stmt->close();
// CORREÇÃO: Fechando a variável de conexão correta.
$conn->close();

?>
