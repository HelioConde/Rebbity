# Rebbity — auditoria e roteiro de modernização

> 27/10/2026 — diagnóstico estático do repositório. Não houve auditoria de ambiente implantado, acesso ao banco ou validação funcional em navegador. O projeto é legado e **não deve ser disponibilizado para operação comercial** antes de passar pelos critérios de segurança.

## Evidências

| Prioridade | Arquivos | Constatação |
| --- | --- | --- |
| P0 | `config.php`, `config2.php`, `portal/config.php`, `backupconfig.php` | Segredos de infraestrutura foram versionados no histórico; **rotacionar banco e FTP fora do Git** e migrar configuração para variáveis de ambiente. |
| P0 | `portal/index.html` | O trecho de validação de sessão está dentro de comentário HTML e não protege a interface. |
| P0 | `authentication.php` | Consulta SQL concatenada, token de sessão gerado com `Rand`, ausência de regeneração de ID após login. |
| P0 | `portal/categoryChageDel.php`, `portal/categoryChageDelItem.php`, `portal/categoryChageName.php` | Mutação por ID sem validar `id_client`, com risco de atuação sobre registros de outros parceiros. |
| P0 | `portal/viewCategory.php`, `portal/view_add_OS.php` | Dados armazenados são interpolados diretamente em HTML/handlers inline sem escape contextual. |
| P1 | `portal/newItemCategory.php`, `portal/insertSubCategory.php` | Upload não valida MIME, dimensão/tamanho nem erros de envio. |
| P1 | `insert_market.php`, `insert_restaurant.php` | SQL interpolado e cadastros muito semelhantes duplicados. |
| P1 | `portal/insertItem.php` | Endpoint apenas ecoa campos do POST; fluxo não salva efetivamente. |
| P1 | `config.php` e `portal/config.php` | Criação de tabelas durante requisições e esquemas divergentes. |
| P2 | `index.html` e `portal/index.html` | Metadados antigos e repetidos; possíveis URLs e informações de contato desatualizadas. |
| P2 | `view/form-market.html` e `view/form-restaurant.html` | Rádio do delivery marcado duas vezes; campos requerem revisão de rótulos e validação. |
| P2 | `img/lorem.gif`, `img/lorem.png` | Arquivos de demonstração grandes; otimização e substituição antes da publicação. |

## Execução em ordem — lotes encadeados

### Lote A — Segurança e fundação
- [ ] **01. Contenção:** verificar se banco/FTP antigos ainda são ativos; rotacionar todos os segredos expostos, revogar acessos e inspecionar logs.
- [ ] **02. Segredos:** substituir configurações por variáveis de ambiente, inserir exemplo sem segredos e regras de exclusão do Git. Revisar o histórico já publicado.
- [ ] **03. Ambiente:** criar ambiente de desenvolvimento/testes isolado, PHP suportado, MySQL descartável e importação/migrações reprodutíveis.
- [ ] **04. Portal protegido:** servir `portal/index.php` e outras páginas protegidas via servidor com bloqueio real, retornando 401/403 quando necessário.
- [ ] **05. Identidade:** reformular login com prepared statements, `password_verify`, `random_bytes`, `session_regenerate_id`, cookies seguros, expiração e logout.
- [ ] **06. Autorização:** estabelecer autorização por parceiro em cada acesso/mutação e testes explícitos de isolamento entre duas contas.
- [ ] **07. CSRF:** exigir token CSRF e validação de método em todas as requisições mutáveis, com erro HTTP adequado.
- [ ] **08. SQL/XSS/upload:** parametrizar queries, escapar saídas HTML/atributo/JS e validar imagem real, tamanho e armazenamento seguro.
- [ ] **09. Dados:** alinhar esquema de `client`, `category`, `item`; aplicar migrations, constraints, índices e transactions.

**Gate A:** nenhuma credencial no HEAD, segredo antigo rotacionado, login/logout testados, tentativas de SQLi/XSS/CSRF/IDOR rejeitadas e teste de duas contas aprovado.

### Lote B — Taste Skill + Awesome Design
- [ ] **10. Tokens:** definir tipografia, paleta, espaçamento, raios, sombras, foco e estados. Base incremental em `css/foundation.css`.
- [ ] **11. Guia:** manter `docs/DESIGN_SYSTEM.md` como fonte de verdade de componentes/estados.
- [ ] **12. Landing:** redesenhar hero, proposta de valor, diferenciais e chamadas para restaurante/mercado com hierarquia de conteúdo.
- [ ] **13. Formulários:** transformar o cadastro em etapas curtas, preservar progresso, mensagens inline e estados de sucesso/erro.
- [ ] **14. Portal:** simplificar sidebar, dashboard, gerenciamento de cardápios e estados vazios/erros/carregamento.
- [ ] **15. Componentes:** consolidar botões, inputs, modais, tabelas e cards reutilizáveis antes de introduzir novas funcionalidades.

**Gate B:** consistência visual desktop/mobile e fluxo principal executável sem orientação externa.

### Lote C — Web Design Guidelines + Image to Code
- [ ] **16. Semântica:** landmarks, cabeçalhos, rótulos, mensagens anunciadas, contraste AA e navegação completa com teclado.
- [ ] **17. Movimento:** respeitar `prefers-reduced-motion`, implementar estado de menu por click/teclado/Escape, evitar interação somente por `mouseup`.
- [ ] **18. Responsividade:** testar 320/375/390/768/1024/1366/1920px e zoom de 200% sem cortes/rolagem horizontal inesperada.
- [ ] **19. Referências:** capturar telas do legado e redesenhar componentes a partir de referências reais, com comparação visual antes/depois.
- [ ] **20. Mídia:** trocar placeholders, otimizar imagens e carregar conteúdo sob demanda onde necessário.

**Gate C:** navegação por teclado funcional, sem falhas graves de axe e layout aprovado nas resoluções de teste.

### Lote D — Playwright CLI, qualidade e publicação
- [ ] **21. Testes estáticos:** automatizar rotas públicas, erros de navegação, navegação de teclado e screenshots.
- [ ] **22. Testes de integração:** cobrir cadastro de restaurante/mercado, login, bloqueio, CRUD de cardápios, upload, logout e negativas de autorização com DB de teste.
- [ ] **23. CI:** execução de `php -l`, testes de integração, Playwright, análise de dependências e secret scanning em PRs.
- [ ] **24. SEO/legais:** atualizar meta/canonical/sitemap, domínio real, política de privacidade/LGPD e contatos; nunca indexar rotas administrativas.
- [ ] **25. Performance:** remover dependências/mídia ociosas, medir Core Web Vitals e erros JS.
- [ ] **26. Homologação:** checklist de deploy PHP com HTTPS, backup/restore, logs, monitoramento e rollback testado.

**Gate D:** QA reproduzível em CI e homologação; aprovação explícita para qualquer publicação comercial.

## Regras de continuidade

1. Executar os itens numerados em lotes, registrando commit/PR, evidência de teste e pendências — não marcar tarefas como feitas somente por gerar documentação.
2. Priorizar correções que **não quebrem** fluxos; mudanças de segurança com impacto no ambiente exigem variáveis e dados de teste antes de merge.
3. Após cada lote: analisar código, corrigir regressões e só avançar quando o respectivo gate estiver satisfeito.
4. Este arquivo registra um plano de execução, **não configura um agente em segundo plano**.
