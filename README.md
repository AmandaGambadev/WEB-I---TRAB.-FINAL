Universidade Federal do Paraná - UFPR

Setor de Educação Profissional e Tecnológica - SEPT

Tecnologia em Análise e Desenvolvimento de Sistemas

---

*DS122 - Desenvolvimento Web I*

# Shelter Cats - Jogo de Digitação

Esse projeto foi desenvolvido como trabalho prático para a disciplina DS122 - Desenvolvimento Web I, consistindo em uma aplicação WEB que implementa um jogo de digitação onde o usuário se torna voluntário em um abrigo de gatos.

## 🎯 Descrição do Sistema

Shelter Cats é um jogo de digitação onde a velocidade e habilidade do jogador (usuário) são recompensadas com pontos, que, no jogo, aparecem como ajuda e alimento para gatinhos que vivem em um abrigo. 

O sistema conta com autenticação de usuários, placares e rankings em ligas, onde o jogador pode competir com seus amigos e demais usuários. 

A interface foi projetada para ser amigável e fofa, utilizando uma paleta de cores pastéis e um design coeso em todas as telas, para trazer ao jogador uma experiência agradável e que condiz com o tema.

## ✨ Funcionalidades

* **Autenticação de Usuários:** Sistema completo de registro e login para proteger o acesso e salvar o progresso de cada jogador.
* **Jogo de Digitação:** Jogo implementado em JavaScript onde o jogador digita palavras e termos do universo felino para marcar pontos.
* **Sistema de Ligas:**
    * Jogadores podem criar suas próprias ligas, inserindo uma senha para protegê-las.
    * Jogadores podem entrar em ligas já existentes, digitando a palavra-chave correspondente para receber o acesso.
    * Há também a possibilidade de sair de uma liga ou excluí-la, caso o jogador seja o criador da liga em questão.
* **Placares:**
   * **Placar Geral:** Apresenta a pontuação de todos os jogadores.
   * **Placar das Ligas:** Apresenta a pontuação dos membros no placar dessa liga.
   * **Filtro Semanal/All Time:** Os placares podem ser filtrados para mostrar a pontuação SEMANAL ou TOTAL desde a criação do jogo.
* **Histórico do Jogador:** O jogador tem acesso a uma tela que mostra o registro de todas as suas partidas, com a pontuação e data correspondentes.

---

## 🚀 Inicialização Rápida

### 1️⃣ Executar o Script de Inicialização

Acesse no navegador:
```
http://localhost/WEB-I---TRAB.-FINAL/convenience/convenience_init.php
```

Este script irá:
- ✅ Criar o banco de dados
- ✅ Criar todas as tabelas
- ✅ Criar usuário de teste (professor / 123456)
- ✅ Criar liga de teste
- ✅ Inserir dados de partidas de teste

### 2️⃣ Fazer Login

Acesse:
```
http://localhost/WEB-I---TRAB.-FINAL/jogo/index.php
```

**Credenciais de Teste:**
- **Usuário:** `professor`
- **Senha:** `123456`

### 3️⃣ Explorar a Aplicação

- 🎮 **Jogar:** Clique em "Bora se voluntariar (Jogar)"
- 🏆 **Ver Rankings:** Acesse "Quadro de Pontos"
- ⚽ **Ver Ligas:** Clique em "Ver Ligas"
- 📊 **Histórico:** Veja suas partidas anteriores

---

## 📁 Estrutura do Código

### Diretórios Principais

```
banco-de-dados/        → Backend e conexão com BD
├── bancodedados.php   → Conexão PDO com MySQL (CENTRAL)
├── login.php          → Autenticação de usuários
├── registro.php       → Criação de contas
├── authenticate.php   → Validação de sessão
├── gerenciar_liga.php → Operações de liga (criar, entrar, sair)
├── funcs.php          → Funções auxiliares
└── salvar_jogo.php    → API para salvar pontuação (AJAX)

jogo/                  → Interface e Páginas
├── index.php          → Tela de login
├── inicio.php         → Dashboard do usuário
├── jogo.php           → Página do jogo
├── ligas.php          → Gestão de ligas
├── pontos.php         → Ranking/Placar
├── historico.php      → Histórico de partidas
├── registrar.php      → Página de registro
├── logout.php         → Sair da sessão
└── convenience/              # Scripts de inicialização
    ├── convenience_init.php   # Inicialização com dados de teste
    └── QUICK_START.md         # Guia rápido

js/                    → JavaScript
└── jogo.js            → Lógica do jogo (33 palavras felinas)

css/                   → Estilos
└── style.css          → Design responsivo com Bootstrap
```

### 🔐 Fluxo de Autenticação

1. Usuário acessa `index.php` e insere credenciais
2. Formulário envia dados para `login.php` (POST)
3. `login.php` valida credenciais e cria sessão com `id_usuario`
4. Páginas protegidas verificam sessão via `authenticate.php`
5. Ao logout, `logout.php` destroi a sessão

### 🎮 Fluxo do Jogo

1. Usuário clica "Iniciar Jogo" em `jogo.php`
2. `jogo.js` gerencia gameplay com timer de 90 segundos
3. Ao término, envia dados via AJAX para `salvar_jogo.php`
4. Backend salva partida no banco de dados
5. Pontuação aparece imediatamente no histórico

### 📊 Banco de Dados (4 Tabelas)

| Tabela | Função |
|--------|--------|
| `table_users` | Dados dos usuários (id, nome, senha) |
| `table_matches` | Histórico de partidas (pontos, WPM, acurácia) |
| `table_leagues` | Ligas criadas (nome, senha, criador) |
| `table_league_members` | Membros de ligas (relação N:N) |

### 🛡️ Segurança Implementada

- ✅ Senhas com `password_hash()` (não armazenadas em texto plano)
- ✅ SQL Injection protegido com prepared statements (PDO)
- ✅ Sessões regeneradas ao login
- ✅ Validação de entrada em todos os formulários
- ✅ Type casting para IDs (casting para int)
- ✅ Sanitização com `htmlspecialchars()`

### 🎮 Características do Jogo

- **33 palavras felinas** (sem acentos, sem repetição consecutiva)
- **90 segundos** de duração por partida
- **Sistema de pontuação** baseado em acurácia e velocidade
- **Feedback visual** com gatos e sons
- **Histórico completo** de partidas do usuário

---

## 📚 Stack Tecnológico

- **Backend:** PHP 8.2.4
- **Banco de Dados:** MySQL (PDO)
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla + jQuery)
- **Framework CSS:** Bootstrap 5.3.0
- **Autenticação:** Session-based

---

## 📝 Dados de Teste Disponíveis

**Usuário de Teste:**
- Login: `professor`
- Senha: `123456`

**Liga de Teste:**
- Nome: `Liga de Teste`
- Senha da Liga: `senha123`

**Partidas Simuladas:**
- 4 partidas com pontuação variada (120-200 pontos)
- Acurácia entre 88-95%

---

## 🤖 Observação sobre IA Generativa

Este projeto foi desenvolvido com auxílio de **GitHub Copilot (Claude Haiku 4.5)** para:
- Geração de código boilerplate
- Debugging e identificação de erros
- Explicação de conceitos complexos
- Sugestões de refatoração

Todo código foi compreendido, validado e adaptado pelos desenvolvedores antes de sua implementação. Veja `AI_USAGE_LOG.md` para detalhes completos.

---

## ✅ Status do Projeto

- ✅ Autenticação funcional
- ✅ Jogo completamente implementado
- ✅ Sistema de ligas operacional
- ✅ Rankings em tempo real
- ✅ Histórico de partidas
- ✅ Dados de teste automáticos
- ✅ Pronto para deployment

---

## 📖 Documentação Adicional

- `convenience/QUICK_START.md` - Guia de inicialização rápida
- `convenience/convenience_init.php` - Script de inicialização automática
- `AI_USAGE_LOG.md` - Log detalhado de uso de IA
- `MERGE_RESOLUTION.md` - Resolução de conflitos de merge
- `SETUP_GUIDE.md` - Guia completo de configuração

