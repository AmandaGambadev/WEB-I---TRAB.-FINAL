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
