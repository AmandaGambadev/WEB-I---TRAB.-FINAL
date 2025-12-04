<?php

// Configurações de conexão
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shelter_cats";

// Conectando já direto ao banco existente
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

// Verifica a conexão
if ($mysqli->connect_error) {
    // Se a conexão falhar, pode ser porque o banco de dados ainda não existe.
    // O usuário deve executar 'criar_banco.php' primeiro.
    die("Erro ao conectar: " . $mysqli->connect_error . ". Certifique-se de que o banco de dados '$db_name' foi criado (execute 'criar_banco.php' primeiro).");
}

$mysqli->set_charset("utf8mb4");

// ---------- TABELAS ----------

// Usuários
$sql1 = "
CREATE TABLE IF NOT EXISTS table_users (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  user_usuario VARCHAR(50) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  criado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

// Partidas
$sql2 = "
CREATE TABLE IF NOT EXISTS table_matches (
  id_jogo INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  pontos INT DEFAULT 0,
  palavras_minuto INT DEFAULT 0,
  ortografia DECIMAL(5,2) DEFAULT 0.00,
  jogado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES table_users(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
";

// Ligas
$sql3 = "
CREATE TABLE IF NOT EXISTS liga (
  id_liga INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  palavra_chave VARCHAR(30) NOT NULL,
  id_criador_liga INT NOT NULL,
  criada_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_criador_liga) REFERENCES table_users(id_usuario)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;
";

// Membros liga
$sql4 = "
CREATE TABLE IF NOT EXISTS liga_membros (
  id_filiacao INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_liga INT NOT NULL,
  entrou_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_usuario_liga (id_usuario, id_liga),
  FOREIGN KEY (id_usuario) REFERENCES table_users(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_liga) REFERENCES liga(id_liga)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
";

// Executar
$erros = 0;
if ($mysqli->query($sql1) === FALSE) $erros++;
if ($mysqli->query($sql2) === FALSE) $erros++;
if ($mysqli->query($sql3) === FALSE) $erros++;
if ($mysqli->query($sql4) === FALSE) $erros++;

if ($erros === 0) {
    echo "Todas as tabelas foram criadas com sucesso!";
} else {
    echo "Erro ao criar tabelas. Verifique as permissões e a sintaxe SQL. Erros: " . $mysqli->error;
}

$mysqli->close();

?>
