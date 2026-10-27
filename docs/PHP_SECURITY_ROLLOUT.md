# Rebbity — etapa de segurança PHP (não publicada)

Atualização isolada na branch `security/rebbity-php-credentials-env-20261027`. **A demonstração do GitHub Pages permanece independente; este backend não deve ser usado em produção ainda.**

## Implementado nesta etapa
- Credenciais do banco via `REBBITY_DB_HOST`, `REBBITY_DB_USER`, `REBBITY_DB_PASS`, `REBBITY_DB_NAME`, configuradas **fora do Git**.
- `config2.php`, `backupconfig.php` e `portal/config.php` sem conexão duplicada ou credenciais hardcoded; o PHP retorna 503 genérico quando não configurado.
- Separação entre conectar e criar esquema: **não executar CREATE TABLE ao processar cada requisição**.
- Login POST-only, prepared statement, senha verificada com `password_verify`, token com `random_bytes`, `session_regenerate_id` e cookie HttpOnly/SameSite.
- Guard único para três mutações de categoria; UPDATE/DELETE filtram também `id_client`, reduzindo IDOR, SQL parametrizado.
- CI roda `php -l` e verificações estáticas sem expor dados ou requisitar banco.

## Obrigações ANTES de integrar em produção
1. **Revogar todas as senhas do banco antigas** e verificar histórico Git, caches, forks e logs. Esta branch não apaga segredos de commits anteriores.
2. Configurar variáveis no provedor de hospedagem; criar tabelas por **migração com backup**, jamais automaticamente no carregamento.
3. Revisar e corrigir os **outros endpoints** de categoria, item, cadastro, sessões e uploads. Eles ainda não são considerados seguros.
4. Implementar tokens CSRF reais nas páginas e formulários do portal; regras de autorização por proprietário em cada rota.
5. Adicionar rate limit de login, checagem de sessão, bloqueio, logs e testes de integração em um banco de teste descartável.
6. Verificar integridade do esquema e diferenças entre versões de `client`, `category` e `item`.

**Os testes de sintaxe e análise estática não equivalem a testes de integração de login, cadastro ou autorização em ambiente real.**