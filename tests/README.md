# QA do Rebbity

A suíte Playwright cobre **somente rotas e navegação estáticas públicas**. Não prova que o portal PHP, cadastro, login ou operações sobre dados estão corretos ou seguros.

## Executar

Requisitos: Node.js 20+ e Python 3 (com comando `python`).

```bash
npm install
npx playwright install chromium
npm run test:e2e
```

Os testes sobem um servidor HTTP local na porta 8765. O projeto usa o navegador Chromium em três viewports (375, 768 e 1366px).

## O que verificar nos próximos lotes

- [ ] Chrome e WebKit em diferentes resoluções.
- [ ] Menu mobile com click, Enter, Space e Escape.
- [ ] Contrast ratio e automação de axe.
- [ ] Prints/snapshots comparativos da landing, cadastros e portal.
- [ ] Ambiente de teste PHP + MySQL, com banco descartável e fixtures de duas contas.
- [ ] Bloqueio de acesso não autenticado, consulta cruzada e CSRF.
- [ ] Fluxos positivos e negativos de cadastro, login, CRUD e upload.

**Status:** código de testes criado, mas ainda não executado nesta auditoria. O ambiente de trabalho não teve acesso às dependências para rodar o navegador; é necessária execução local ou em CI.
