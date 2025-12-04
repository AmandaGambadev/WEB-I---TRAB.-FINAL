<?php
/**
 * PASSO 1: INICIAR A SESSÃO
 * Essencial para usar $_SESSION e manter o usuário logado entre as páginas.
 */
session_start();

/**
 * PASSO 2: INCLUIR A CONEXÃO COM O BANCO
 * O arquivo 'bancodedados.php' cria a variável de conexão $conn.
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
 * CORREÇÃO: Usando a variável $conn.
 */
$stmt = $conn->prepare("SELECT id_usuario, user_usuario, senha FROM table_users WHERE user_usuario = ?");

// Verifica se a preparação da consulta falhou.
if ($stmt === false) {
    // Registra o erro real no log do servidor (mais seguro).
    error_log("Erro na preparação da consulta: " . $conn->error);
    // Redireciona o usuário com uma mensagem de erro genérica.
    header('Location: ../jogo/index.php?error=db_error');
    exit();
}

$stmt->bind_param("s", $username);

// Executa a consulta.
if ($stmt->execute()) {
    /**
     * PASSO 6: PROCESSAR O RESULTADO
     */
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifica se o usuário existe E se a senha está correta.
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
} else {
    // Falha na execução da consulta.
    error_log("Erro na execução da consulta: " . $stmt->error);
    header('Location: ../jogo/index.php?error=db_error');
    exit();
}

/**
 * PASSO 7: FECHAR A CONEXÃO
 * CORREÇÃO: Fechando a variável de conexão correta.
 */
$stmt->close();
$conn->close();

?>
