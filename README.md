# Rebbity — Portal experimental de parceiros

**Projeto web legado voltado a páginas de parceiros e operações relacionadas a delivery.**

## Visão geral

O repositório reúne páginas públicas, áreas de portal e rotinas PHP para experimentar fluxos de cadastro e gerenciamento de parceiros.

## Estrutura

- `index.html` — entrada pública.
- `portal/` e `view/` — áreas e páginas adicionais.
- `*.php` — rotinas de servidor, incluindo autenticação e persistência.
- `css/`, `js/`, `img/` — recursos de interface.
- `banco_teste.sql` — arquivo SQL presente no projeto; revise antes de importar.

## Execução e segurança

Para executar integralmente, é necessário configurar um ambiente PHP e banco de dados compatíveis com o código existente.

> **Código legado não auditado:** antes de qualquer deploy público, revise as credenciais existentes em arquivos de configuração, autenticação, sessões, permissões, SQL, validação de entradas e tratamento de dados pessoais. Não utilize dados reais de clientes sem essas verificações.

## Próxima evolução

Documentar rotas e fluxo principal, atualizar dependências, isolar segredos e adicionar testes.

Criado por [Hélio Conde](https://github.com/HelioConde).
