<?php
// Configurações de conexão
$host = "localhost";
$user = "root";
$pass = "";
$db   = "shelter_cats";

// Conecta ao banco de dados
// A função mysqli::__construct() tenta se conectar ao servidor e selecionar o banco de dados
$conn = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($conn->connect_error) {
    // Se a conexão falhar, exibe uma mensagem de erro.
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error . ". Certifique-se de que o banco de dados '$db' foi criado e o MySQL está rodando.");
}

// Define o charset para evitar problemas com acentuação
$conn->set_charset("utf8mb4");

// A variável $conn agora está pronta para ser usada em consultas SQL.
// IMPORTANTE: A conexão NÃO É FECHADA AQUI. Ela deve ser fechada no script que a inclui (registro.php).
?>
