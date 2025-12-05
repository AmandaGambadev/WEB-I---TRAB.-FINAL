<?php
/**
 * ============================================
 * SCRIPT DE INICIALIZAÇÃO - Shelter Cats
 * ============================================
 * 
 * ⚠️ GERADO COM AUXÍLIO DE IA
 * Este arquivo foi criado com assistência de IA generativa (GitHub Copilot - Claude Haiku 4.5)
 * para facilitar a inicialização rápida do projeto com dados de teste.
 * 
 * Funcionalidades:
 * - Cria o banco de dados e tabelas
 * - Cria um usuário de teste (login: professor / senha: 123456)
 * - Cria uma liga de teste
 * - Adiciona o usuário à liga
 * - Insere dados de partidas de teste com pontuação
 * 
 * Caminho: /convenience/convenience_init.php
 * URL: http://localhost/WEB-I---TRAB.-FINAL/convenience/convenience_init.php
 */

require_once __DIR__ . '/../banco-de-dados/bancodedados.php';

echo "<h1>🐱 Shelter Cats - Inicialização com Dados de Teste</h1>";
echo "<hr>";

try {
    // ============================================
    // 1. CRIAR TABELAS
    // ============================================
    echo "<h2>✓ Criando tabelas...</h2>";

    // Tabela de usuários
    $sql_users = "CREATE TABLE IF NOT EXISTS table_users (
        id_usuario INT AUTO_INCREMENT PRIMARY KEY,
        user_usuario VARCHAR(50) UNIQUE NOT NULL,
        senha VARCHAR(255) NOT NULL,
        criado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) COMMENT='Dados dos usuários foram armazenados.';";
    $pdo->exec($sql_users);
    echo "<p>✅ Tabela 'table_users' criada</p>";

    // Tabela de partidas
    $sql_matches = "CREATE TABLE IF NOT EXISTS table_matches (
        id_partida INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        pontos INT DEFAULT 0,
        palavras_minuto INT DEFAULT 0,
        ortografia INT DEFAULT 0,
        jogado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_usuario) REFERENCES table_users(id_usuario) ON DELETE CASCADE
    ) COMMENT='O histórico de partidas foi armazenado.';";
    $pdo->exec($sql_matches);
    echo "<p>✅ Tabela 'table_matches' criada</p>";

    // Tabela de ligas
    $sql_leagues = "CREATE TABLE IF NOT EXISTS table_leagues (
        id_liga INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        palavra_chave VARCHAR(50) NOT NULL,
        id_criador_liga INT NOT NULL,
        criada_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_criador_liga) REFERENCES table_users(id_usuario) ON DELETE CASCADE
    ) COMMENT='Dados das ligas foram armazenados.';";
    $pdo->exec($sql_leagues);
    echo "<p>✅ Tabela 'table_leagues' criada</p>";

    // Tabela de membros de liga
    $sql_members = "CREATE TABLE IF NOT EXISTS table_league_members (
        id_membro INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        id_liga INT NOT NULL,
        entrou_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_usuario) REFERENCES table_users(id_usuario) ON DELETE CASCADE,
        FOREIGN KEY (id_liga) REFERENCES table_leagues(id_liga) ON DELETE CASCADE,
        UNIQUE KEY id_usuario_liga(id_usuario, id_liga)
    ) COMMENT='Dados dos membros das ligas foram armazenados.';";
    $pdo->exec($sql_members);
    echo "<p>✅ Tabela 'table_league_members' criada</p>";

    // ============================================
    // 2. CRIAR USUÁRIO DE TESTE
    // ============================================
    echo "<h2>✓ Criando usuário de teste...</h2>";

    $username = 'professor';
    $password = '123456';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO table_users (user_usuario, senha) VALUES (?, ?)");
        $stmt->execute([$username, $password_hash]);
        $user_id = $pdo->lastInsertId();
        echo "<p>✅ Usuário criado: <strong>$username</strong> / <strong>$password</strong></p>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'UNIQUE') !== false) {
            // Usuário já existe, buscar ID
            $stmt = $pdo->prepare("SELECT id_usuario FROM table_users WHERE user_usuario = ?");
            $stmt->execute([$username]);
            $result = $stmt->fetch();
            $user_id = $result['id_usuario'];
            echo "<p>⚠️ Usuário já existe (ID: $user_id)</p>";
        } else {
            throw $e;
        }
    }

    // ============================================
    // 3. CRIAR LIGA DE TESTE
    // ============================================
    echo "<h2>✓ Criando liga de teste...</h2>";

    $league_name = 'Liga de Teste';
    $league_keyword = 'senha123';

    try {
        $stmt = $pdo->prepare("INSERT INTO table_leagues (nome, palavra_chave, id_criador_liga) VALUES (?, ?, ?)");
        $stmt->execute([$league_name, $league_keyword, $user_id]);
        $league_id = $pdo->lastInsertId();
        echo "<p>✅ Liga criada: <strong>$league_name</strong> (Senha: $league_keyword)</p>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'UNIQUE') === false) {
            // Buscar liga existente
            $stmt = $pdo->prepare("SELECT id_liga FROM table_leagues WHERE nome = ?");
            $stmt->execute([$league_name]);
            $result = $stmt->fetch();
            $league_id = $result ? $result['id_liga'] : null;
            if ($league_id) {
                echo "<p>⚠️ Liga já existe (ID: $league_id)</p>";
            } else {
                throw $e;
            }
        } else {
            throw $e;
        }
    }

    // ============================================
    // 4. ADICIONAR USUÁRIO À LIGA
    // ============================================
    echo "<h2>✓ Adicionando usuário à liga...</h2>";

    try {
        $stmt = $pdo->prepare("INSERT INTO table_league_members (id_usuario, id_liga) VALUES (?, ?)");
        $stmt->execute([$user_id, $league_id]);
        echo "<p>✅ Usuário adicionado à liga</p>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'UNIQUE') !== false) {
            echo "<p>⚠️ Usuário já era membro da liga</p>";
        } else {
            throw $e;
        }
    }

    // ============================================
    // 5. INSERIR DADOS DE PARTIDAS DE TESTE
    // ============================================
    echo "<h2>✓ Inserindo dados de partidas de teste...</h2>";

    $test_games = [
        ['pontos' => 150, 'wpm' => 65, 'accuracy' => 92],
        ['pontos' => 200, 'wpm' => 78, 'accuracy' => 95],
        ['pontos' => 120, 'wpm' => 52, 'accuracy' => 88],
        ['pontos' => 180, 'wpm' => 72, 'accuracy' => 91],
    ];

    foreach ($test_games as $game) {
        $stmt = $pdo->prepare("INSERT INTO table_matches (id_usuario, pontos, palavras_minuto, ortografia, jogado) VALUES (?, ?, ?, ?, NOW() - INTERVAL FLOOR(RAND() * 7) DAY)");
        $stmt->execute([$user_id, $game['pontos'], $game['wpm'], $game['accuracy']]);
        echo "<p>✅ Partida inserida: {$game['pontos']} pontos, {$game['wpm']} WPM, {$game['accuracy']}% acurácia</p>";
    }

    // ============================================
    // 6. RESUMO
    // ============================================
    echo "<hr>";
    echo "<h2>✅ INICIALIZAÇÃO CONCLUÍDA COM SUCESSO!</h2>";
    echo "<p style='background: #e8f5e9; padding: 15px; border-radius: 5px;'>";
    echo "<strong>Dados de teste criados:</strong><br>";
    echo "• Usuário: <strong>professor</strong><br>";
    echo "• Senha: <strong>123456</strong><br>";
    echo "• Liga: <strong>Liga de Teste</strong><br>";
    echo "• Senha da Liga: <strong>senha123</strong><br>";
    echo "• Partidas: <strong>4</strong> com pontuações variadas<br>";
    echo "</p>";
    echo "<p style='margin-top: 20px;'>";
    echo "<a href='../jogo/index.php' style='background: #0f7ea0; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;'>Ir para Login →</a>";
    echo "</p>";

} catch (PDOException $e) {
    echo "<p style='color: red; background: #ffebee; padding: 15px; border-radius: 5px;'>";
    echo "<strong>❌ Erro na inicialização:</strong><br>";
    echo htmlspecialchars($e->getMessage());
    echo "</p>";
}
?>

<style>
  body {
    font-family: 'Nunito', sans-serif;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background: #fffbf5;
    color: #5d4037;
  }
  h1 {
    color: #0f7ea0;
    text-align: center;
  }
  h2 {
    color: #0f7ea0;
    margin-top: 30px;
  }
  p {
    line-height: 1.6;
  }
  hr {
    border: none;
    border-top: 2px solid #e0e0e0;
    margin: 30px 0;
  }
</style>
