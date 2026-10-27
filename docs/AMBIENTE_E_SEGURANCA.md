# Ambiente PHP/MySQL — Rebbity

## Uso local isolado

Requisitos: PHP 8.2+ (extensões mysqli, mbstring e fileinfo), MySQL 8, Node.js 20+ para Playwright.

1. Use um banco **novo e vazio**; não importe dados pessoais reais em ambiente local.
2. Defina `REBBITY_DB_HOST`, `REBBITY_DB_PORT`, `REBBITY_DB_USER`, `REBBITY_DB_PASSWORD` e `REBBITY_DB_NAME` no ambiente do processo PHP; `.env.example` é só modelo e **não é carregado automaticamente**.
3. Crie o banco, execute `database/schema.sql` nele e inicie `php -S 127.0.0.1:8000 -t .`.
4. Abra `http://127.0.0.1:8000/index.html`. O painel exige autenticação e aprovação (cadastros novos têm `block=true`).
5. Rode `npm install`, `npx playwright install chromium` e `npm run test:e2e` para a landing estática.

### Segurança operacional

- **Ação humana obrigatória:** revogar/rotacionar credenciais antigas de banco e FTP que foram publicadas no Git, verificar logs e não reutilizá-las.
- O histórico do GitHub ainda pode conter esses segredos após a limpeza dos arquivos atuais; revisar política de reescrita de histórico e forks separadamente.
- Configure HTTPS e `session.cookie_secure` em produção; coloque `portal/index.php` e endpoints PHP atrás do servidor PHP. GitHub Pages não executa PHP/MySQL.
- **Não** execute `database/schema.sql` sobre produção sem backup e migração de esquema revisada. Este arquivo é bootstrap de banco vazio, não ferramenta de migração de dados.
- Não disponibilize formulários que armazenem CPF/CNPJ sem política de privacidade atualizada, bases legais e testes de proteção dos dados.
- Rotas antigas como `portal/index.html` apontam ao PHP protegido, mas qualquer hospedagem deve desativar listagem de diretórios, proteção de fontes e debug.
- O processo de aprovação de cadastro é manual; **não liberar parceiro automaticamente**.

### QA e homologação

- Proteções de acesso direto: `GET /portal/index.php` sem sessão deve responder 401; endpoints de alteração sem token CSRF devem responder 403, sem executar consultas mutáveis.
- Fluxos: cadastro, parceiro bloqueado, aprovação controlada, login, criação de categoria/item, tentativas de acesso cruzado, logout.
- Restaurar backup e validar rollback antes de qualquer merge para produção.

## Estado da atualização

Configuração e handlers migrados para PHP protegido, mas homologação no ambiente de hospedagem e rotação dos segredos ainda não realizadas.

### Cache de conteúdo autenticado

O bootstrap aplica `Cache-Control: private, no-store, max-age=0` e `Pragma: no-cache` dentro de `rb_partner()`, que é compartilhado por `portal/index.php` e pelas rotas diretas `portal/view/`. Isso evita persistência involuntária de dados de parceiros no cache HTTP do navegador e de proxies. Os testes de integração verificam os cabeçalhos em sessão autenticada para Home do portal, dashboard, categoria e menu. A política não substitui a necessidade de HTTPS, autenticação, logout seguro, proteção de dados ou a rotação das credenciais do histórico.

### Proteção contra repetição de tentativas de login

O formulário PHP autenticado usa `app/login-rate-limit.php` e a tabela `login_attempts` do banco **novo** de homologação. Cada tentativa registra uma janela de 15 minutos por hash de e-mail e por endereço IP remoto, limitando a 7 tentativas por e-mail e 60 por IP. Acima dos limites responde `429 Too Many Requests` com `Retry-After`. Ao autenticar corretamente, apenas o contador do e-mail é eliminado; o contador por IP continua até a janela expirar. A tabela guarda somente hashes dos identificadores, não endereços/e-mails em texto simples.

**Para produção:** a tabela precisa de migração controlada e testada em ambiente separado, nunca executar `database/schema.sql` em banco legado. Configurar job de limpeza de linhas com `reset_at` antigo, monitorar abusos e analisar bloqueios indevidos de IPs compartilhados. O controle por IP usa `REMOTE_ADDR` do servidor; não confia em `X-Forwarded-For` enviado por visitantes. Essa defesa é uma camada inicial e não substitui WAF, HTTPS, senhas fortes, recuperação de conta e monitoramento.

O teste CI simula senha incorreta, resposta 429, troca de sessão, tentativas com senha correta durante o bloqueio e reinício após vencer a janela.
