# Relatório de Uso de Inteligência Artificial Generativa

Este documento registra todas as interações significativas com ferramentas de IA generativa (como Gemini, ChatGPT, Copilot, etc.) durante o desenvolvimento deste projeto. O objetivo é promover o uso ético e transparente da IA como ferramenta de apoio, e não como substituta para a compreensão dos conceitos fundamentais.

## Política de Uso

O uso de IA foi permitido para as seguintes finalidades:

- Geração de ideias e brainstorming de algoritmos.
- Explicação de conceitos complexos.
- Geração de código boilerplate (ex: estrutura de classes, leitura de arquivos).
- Sugestões de refatoração e otimização de código.
- Debugging e identificação de causas de erros.
- Geração de casos de teste.

É proibido submeter código gerado por IA sem compreendê-lo completamente e sem adaptá-lo ao projeto. Todo trecho de código influenciado pela IA deve ser referenciado neste log.

---

## Registro de Interações

### Interação 1: Correção de Arquitetura de BD e Debugging do Projeto Shelter Cats

- **Data:** 02/12/2025
- **Etapa do Projeto:** Ranking e Social
- **Ferramenta de IA Utilizada:** GitHub Copilot (Claude Haiku 4.5)
- **Objetivo da Consulta:** Implementar queries para carregar dados reais no dashboard, corrigir inconsistências de nomes de tabelas, adicionar suporte PDO e diagnosticar erros HTTP 500 durante testes locais. Também fiz algumas consultas para lembrar a sintaxe do php, que não estou muito acostumado.

- **Prompt(s) Utilizado(s):**

  1. "Implementei queries para carregar ranking e histórico em inicio.php, mas preciso de ajustes. Como deveria estruturar isso com PDO?"
  2. "Identifiquei SQL incorreto em pontos.php (JOIN id_usuario), corrigi para table_users, mas preciso verificar se há outros problemas similares"
  3. "Padronizei nomes de tabelas para table_users, table_matches, table_leagues. Quais arquivos preciso atualizar?"
  4. "Como formatar datas no PHP para exibir no dashboard?"
  5. "Implementei as queries em pontos.php mas está dando erro. Qual o problema?"
  6. "Como configuro localmente no XAMPP e valido as alterações?"
  7. "Login dá erro 500. Qual o motivo?"

- **Resumo da Resposta da IA:**
  A IA auxiliou na implementação das queries em `inicio.php`, sugeriu adicionar exportação de `$pdo` em `bancodedados.php` (que não estava sendo exportado), validou que a correção do SQL em `pontos.php` estava correta e identificou outros usos de `partida` que precisavam ser alterados para `table_matches`. Forneceu orientação sobre formatação de datas em PHP usando `date()` e `strtotime()` para exibição no dashboard. Ao investigar erros em `pontos.php`, identificou inconsistências na estrutura das queries que foram ajustadas. Diagnosticou que o erro 500 era causado por: (1) `$pdo` indefinido, (2) redirect incorreto em `authenticate.php`. Forneceu scripts de teste para isolamento de cada erro.

- **Análise e Aplicação:**
  Implementei as queries PHP em `inicio.php` para carregar dados reais (ranking semanal e histórico). A IA sugeriu adicionar `$pdo` em `bancodedados.php`, o que foi feito. Identifiquei e corrigi o SQL incorreto em `pontos.php` manualmente (JOIN id_usuario → JOIN table_users). Padronizei nomes de tabelas em todos os arquivos conforme recomendação da IA. Corrigir o redirect em `authenticate.php` também resolveu problemas de redirecionamento.

- **Referência no Código:**
  A lógica sugerida por esta interação foi implementada nos seguintes arquivos e linhas:
  - `banco-de-dados/bancodedados.php` - Linhas 12-14 (adição de $pdo)
  - `banco-de-dados/authenticate.php` - Linha 11 (correção de redirect)
  - `jogo/inicio.php` - Linhas 7-20 (queries PHP adicionadas)
  - `jogo/pontos.php`, `jogo/historico.php`, `banco-de-dados/funcs.php`, `banco-de-dados/salvar_jogo.php` - Atualização de referências para tabelas padronizadas

---

### Interação 2: Padronização de Código de Ligas e Placares (Pessoa 4)

- **Data:** 03/12/2025
- **Etapa do Projeto:** Ranking e Social
- **Ferramenta de IA Utilizada:** GitHub Copilot (Claude Haiku 4.5)
- **Objetivo da Consulta:** Completar os usos do Ranking, identificando e corrigindo inconsistências no código de gerenciamento de ligas e padronização de nomes de tabelas.

- **Prompt(s) Utilizado(s):**

  1. "Estou recebendo um parâmetro ?scope=league na URL, mas o código checa $scope === 'id_liga'. Qual é o problema?"
  2. "Procure lugares que estão usando o nome incorreto das tables de ranking"
  3. "O arquivo ligas.php está usando MySQLi prepare/bind_param, mas o resto do projeto usa PDO. Como converto?"

- **Resumo da Resposta da IA:**
  A IA explicou que o parâmetro vinha como 'league' na URL, mas o código testava 'id_liga', causando a falha no filtro de ligas. Confirmou que gerenciar_liga.php deveria usar 'table_leagues' e 'table_league_members' em todos os INSERTs, SELECTs e DELETEs para manter consistência. Mostrou como converter as operações create_league de MySQLi para PDO usando prepare(), execute([array]) e try-catch com PDOException.

- **Análise e Aplicação:**

  1. Corrigi pontos.php alterando if ($scope === 'id_liga') para if ($scope === 'league') para receber corretamente o parâmetro da URL
  2. Atualizei gerenciar_liga.php substituindo todas as 6 referências de 'liga' e 'liga_membros' para 'table_leagues' e 'table_league_members' em INSERTs, SELECTs e DELETEs
  3. Converti ligas.php da sintaxe MySQLi para PDO em todas as operações (create_league, join_league, listagem) usando prepared statements com array de parâmetros

- **Referência no Código:**
  As correções implementadas conforme orientação da IA encontram-se em:
  - `jogo/pontos.php` - Linhas 18, 31 (correção de scope parameter de 'id_liga' para 'league')
  - `banco-de-dados/gerenciar_liga.php` - Linhas 23, 28, 36, 68, 75, 82, 87 (padronização de nomes de tabelas)
  - `jogo/ligas.php` - Linhas 18-30, 32-56 (conversão de MySQLi para PDO com try-catch)

---
