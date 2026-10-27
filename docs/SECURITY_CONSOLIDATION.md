# Segurança do Rebbity — consolidação antes da implantação

As implementações de PHP/MySQL seguem isoladas da demonstração estática do GitHub Pages.

## Implementação de referência

**PR #1 (chore/modernizacao-auditoria-ux-2026-10)** possui arquitetura central `app/bootstrap.php` com autenticação, CSRF, política de sessões, validação de uploads, isolamento por `id_client`, migração de schema para banco novo, CI MySQL 8 e Playwright. O objetivo é tratá-la como **candidata canônica** para homologação, após auditoria.

**PR #2 (security/rebbity-php-credentials-env-20261027)** contém correções incrementais de segurança que se sobrepõem à PR #1. **Não mesclar ambas automaticamente**, pois não compartilham a mesma arquitetura de bootstrap, validação CSRF e schema.

## Cobertura ampliada

`tests/integration/smoke.sh` acrescenta regressões:
- CSRF ausente/inválido e entrada vazia;
- texto HTML potencialmente malicioso salvo em categoria, verificando que é escapado na resposta;
- tentativa de visualizar ou editar categoria pertencente a outro parceiro;
- upload com conteúdo falsificado de PNG e MIME inválido.

O CI cria MySQL temporário com dados sintéticos e testa PHP embutido. **Não usa as credenciais ou dados reais do legado**.

## Bloqueios reais para produção

- Credenciais que tenham constado no histórico precisam ser revogadas/rotacionadas no provedor.
- Instalação real deve ter HTTPS, variáveis `REBBITY_DB_*`, teste de integração, backup e migração de schema revisada.
- Testar a correspondência das rotas `.html` para entradas PHP protegidas, cabeçalhos CSP e riscos remanescentes.
- O site GitHub Pages entrega uma demonstração independente e **não executa PHP**.

Revisar conflitos e preservar a PR como rascunho até completar a homologação operacional.