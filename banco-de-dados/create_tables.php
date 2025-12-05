<?php

// Configurações de conexão
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shelter_cats";

try {
    // Conexão com o MySQL
    $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Criação do BD (caso ainda não exista)
    $sql_db = "CREATE DATABASE IF NOT EXISTS $db_name";
    $pdo->exec($sql_db);
    echo "O banco de dados '$db_name' foi criado com sucesso!<br>";
    
    // Conexão com o DB shelter_cats
    $pdo->exec("USE $db_name");
    
    // Criação da tabela 'table_users'
    $sql_users = "CREATE TABLE IF NOT EXISTS table_users (
        id_usuario INT AUTO_INCREMENT PRIMARY KEY,
        user_usuario VARCHAR(50) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        criado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) COMMENT='Dados dos usuários foram armazenados.';";
    $pdo->exec($sql_users);
    echo "A tabela 'table_users' foi criada com sucesso!<br>";
    
    // Criação da tabela 'table_matches'
    $sql_matches = "CREATE TABLE IF NOT EXISTS table_matches (
        id_jogo INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        pontos INT NOT NULL DEFAULT 0,
        palavras_minuto INT NOT NULL,
        ortografia DECIMAL(5, 2) NOT NULL,
        jogado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_usuario) REFERENCES table_users(id_usuario) ON DELETE CASCADE
    );";
    $pdo->exec($sql_matches);
    echo "A tabela 'table_matches' foi criada com sucesso!<br>";
    
    // Criação da tabela 'table_leagues'
    $sql_leagues = "CREATE TABLE IF NOT EXISTS table_leagues (
        id_liga INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        palavra_chave VARCHAR(30) NOT NULL,
        id_criador_liga INT NOT NULL,
        criada_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_criador_liga) REFERENCES table_users(id_usuario) ON DELETE CASCADE
    ) COMMENT='Dados das ligas foram armazenados.';";
    $pdo->exec($sql_leagues);
    echo "A tabela 'table_leagues' foi criada com sucesso!<br>";
    
    // Criação da tabela 'table_league_members'
    $sql_members = "CREATE TABLE IF NOT EXISTS table_league_members (
        id_filiacao INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        id_liga INT NOT NULL,
        entrou_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_usuario) REFERENCES table_users(id_usuario) ON DELETE CASCADE,
        FOREIGN KEY (id_liga) REFERENCES table_leagues(id_liga) ON DELETE CASCADE,
        UNIQUE KEY id_usuario_liga(id_usuario, id_liga)
    ) COMMENT='Dados dos membros das ligas foram armazenados.';";
    $pdo->exec($sql_members);
    echo "A tabela 'table_league_members' foi criada com sucesso!<br>";

} catch (PDOException $e) {
    die("<br>Erro! O banco de dados teve falha na configuração: " . $e->getMessage());
}

?>
