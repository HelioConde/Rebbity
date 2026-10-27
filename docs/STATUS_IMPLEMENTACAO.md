# Rebbity — progresso verificável da modernização

Atualizado em 27/10/2026. A coluna "implementado" refere-se à **branch do PR #1**, não à `main` nem a um site de produção.

| Etapa | Estado | Evidência e ressalva |
| --- | --- | --- |
| 01 Rotação dos segredos | PENDENTE (externo) | Senhas antigas no histórico exigem rotação no provedor e inspeção de logs. |
| 02 Ambiente/segredos | IMPLEMENTADO NO CÓDIGO | `app/bootstrap.php`, `.env.example`, wrappers `config*.php`; **histórico permanece**. |
| 03 Banco isolado | IMPLEMENTADO EM CI | `database/schema.sql`, serviço MySQL para testes. Migração de base legada ainda pendente. |
| 04 Proteção do portal | IMPLEMENTADO NO CÓDIGO | `portal/index.php` exige sessão; `portal/index.html` não expõe painel. |
| 05 Login | PARCIAL | Prepared statements, hash, token seguro, cookie e regeneração; faltam recuperação de senha/rate limit. |
| 06 Isolamento dos parceiros | IMPLEMENTADO NOS ENDPOINTS MIGRADOS | CRUD com verificação de `id_client`; teste entre duas contas no CI. |
| 07 CSRF | IMPLEMENTADO NOS FLUXOS PRINCIPAIS | Token nos formulários públicos e operações AJAX. |
| 08 SQL/XSS/uploads | PARCIAL | Handlers CRUD parametrizados, HTML escapado e imagem validada; auditoria externa e revisão residual pendentes. |
| 09 Modelo de dados | PARCIAL | Esquema limpo para banco novo, sem migração automática dos dados antigos. |
| 10 Tokens | IMPLEMENTADO (FUNDAÇÃO) | `css/foundation.css`. |
| 11 Design System | PARCIAL | `docs/DESIGN_SYSTEM.md` e componentes RB. |
| 12 Landing | IMPLEMENTADO (PR) | `view/index.html` com hero, CTAs e cards. |
| 13 Cadastro por etapas | IMPLEMENTADO (PR) | `view/form-*.html`, `js/partner-form.js`. |
| 14 Portal | PARCIAL | Menu e cardápios integrados; demais seções continuam históricas/incompletas. |
| 15 Componentes | PARCIAL | Componentes RB iniciais; ainda há CSS legado. |
| 16 Acessibilidade | PARCIAL | Foco visível, semântica, labels e teclado; falta auditoria manual de contraste/zoom. |
| 17 Menus mobile | IMPLEMENTADO (PR) | Botão público e menu interno, com Escape. |
| 18 Responsividade | COBERTURA DE TESTES | CI cobre 320, 375, 768, 1366 e 1920px; inspeção visual humana pendente. |
| 19 Image to Code | PARCIAL | Screenshots disponíveis como artifact do Actions para comparação; sem redesenho geral das views legadas. |
| 20 Imagens | PARCIAL | Placeholder pesado removido do login/menu; demais imagens aguardam otimização. |
| 21 Playwright | IMPLEMENTADO (CI) | Rotas públicas, formulários, menu, captures e verificação de overflow. |
| 22 Integração PHP/MySQL | IMPLEMENTADO (CI) | Login, cadastro, CRUD, duas contas, CSRF e logout. |
| 23 CI | IMPLEMENTADO | `qa-static.yml` e `php-safety.yml`. |
| 24 SEO e documentos legais | PARCIAL | Removidas metas erradas e claims antigos; canonical/domínio e revisão jurídica pendentes. |
| 25 Performance | PARCIAL | Recursos não usados reduzidos e placeholders substituídos; medições Web Vitals pendentes. |
| 26 Homologação e publicação | PENDENTE (externo) | Requer rotacionar segredos, migrar dados e validar backups/rollback e termos. |

## Gates ainda bloqueantes

- Não mesclar como "produção pronta" até rotação dos segredos antigos e revisão de permissões do provedor.
- Realizar migração controlada dos dados existentes e testes de rollback. `database/schema.sql` é apenas para bancos vazios.
- Revisar base legal de tratamento de CPF/CNPJ, privacidade e termos de serviço.
- Executar QA manual no ambiente PHP de hospedagem com HTTPS.
- Analisar CSRF/XSS/IDOR além dos casos cobertos pela suíte automatizada.

## Ordem para continuar

1. Validar os workflows do PR e consertar qualquer regressão antes de avançar.
2. Revisar layout e acessibilidade a partir das capturas do CI.
3. Completar gestão de cardápios, edição de produtos e seções reais do portal.
4. Finalizar migração e homologação sem acessar dados de produção nesta etapa.

**Este documento diferencia alterações no código de operações externas não realizadas.**
