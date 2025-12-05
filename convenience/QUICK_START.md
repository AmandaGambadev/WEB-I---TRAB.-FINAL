# 🚀 Guia Rápido - Shelter Cats

## Inicialização Rápida

### 1️⃣ Inicializar o Projeto
Acesse no navegador:
```
http://localhost/WEB-I---TRAB.-FINAL/convenience/convenience_init.php
```
Isso irá:
- ✅ Criar o banco de dados
- ✅ Criar todas as tabelas
- ✅ Criar usuário de teste (professor / 123456)
- ✅ Criar liga de teste
- ✅ Inserir dados de partidas

### 2️⃣ Fazer Login
Acesse:
```
http://localhost/WEB-I---TRAB.-FINAL/jogo/index.php
```
Credenciais de teste:
- **Usuário:** professor
- **Senha:** 123456

### 3️⃣ Usar a Aplicação
- **Jogar:** Clique em "Bora se voluntariar (Jogar)"
- **Ver Ligas:** Acesse "Ver Ligas" para consultar a liga de teste
- **Ver Ranking:** Veja o placar com os dados de teste

---

## Estrutura do Código

### 📁 Diretórios Principais

```
banco-de-dados/        → Lógica de autenticação e banco de dados
├── bancodedados.php   → Conexão PDO com MySQL
├── login.php          → Autenticação de usuários
├── registro.php       → Criação de contas
├── gerenciar_liga.php → Operações de liga (criar, entrar, sair)
└── salvar_jogo.php    → API para salvar pontuação

jogo/                  → Interface e páginas do usuário
├── index.php          → Tela de login
├── inicio.php         → Dashboard
├── jogo.php           → Página do jogo
├── ligas.php          → Gestão de ligas
├── pontos.php         → Ranking/Placar
├── historico.php      → Histórico de partidas
└── logout.php         → Sair da sessão

js/                    → JavaScript
└── jogo.js            → Lógica do jogo (33 palavras, sem repetição)

css/                   → Estilos
└── style.css          → Design responsivo com Bootstrap
```

### 🔐 Fluxo de Autenticação

1. **Usuário acessa** `index.php` (login)
2. **Envia credenciais** para `login.php`
3. **Login valida** e cria sessão com `id_usuario`
4. **Páginas protegidas** verificam sessão via `authenticate.php`
5. **Logout** destroi sessão em `logout.php`

### 🎮 Fluxo do Jogo

1. **Usuário clica** "Iniciar Jogo" em `jogo.php`
2. **JavaScript** (`jogo.js`) gerencia gameplay com 90 segundos
3. **Ao terminar**, envia dados para `salvar_jogo.php` (AJAX)
4. **Backend** salva partida no banco
5. **Pontuação** aparece no histórico

### 📊 Banco de Dados

**4 Tabelas Principais:**
- `table_users` → Usuários (id, nome, senha)
- `table_matches` → Partidas (pontos, WPM, acurácia)
- `table_leagues` → Ligas (nome, palavra-chave, criador)
- `table_league_members` → Membros de liga (relação N:N)

### 🛡️ Segurança

- ✅ Senhas com `password_hash()`
- ✅ SQL Injection protegido com prepared statements
- ✅ Sessões regeneradas ao login
- ✅ Validação de entrada em todos os formulários

---

## Dados de Teste Disponíveis

**Usuário de Teste:**
- Login: `professor`
- Senha: `123456`

**Liga de Teste:**
- Nome: `Liga de Teste`
- Senha: `senha123`

**Partidas Simuladas:**
- 4 partidas com pontuação variada (120-200 pontos)
- Acurácia entre 88-95%

---

## Próximos Passos

1. ✅ Executar `convenience_init.php`
2. ✅ Logar com credenciais de teste
3. ✅ Jogar algumas rodadas
4. ✅ Explorar rankings e ligas
5. ✅ Criar nova conta pessoal se desejar

Tudo pronto! Aproveite o Shelter Cats! 🐱
