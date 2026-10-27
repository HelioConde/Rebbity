# Rebbity no GitHub Pages

URL prevista: https://helioconde.github.io/Rebbity/

## Separação correta

O GitHub Pages distribui somente HTML, CSS, JavaScript e imagens. O site público do Pages está em `pages/`, não expõe o portal PHP nem executa MySQL. Ao publicar, `scripts/build-pages.mjs` copia **apenas** os arquivos explicitamente permitidos para `dist-pages/`, incluindo algumas imagens da identidade original. Arquivos PHP, SQL, `.env` e dados de outros diretórios não fazem parte do artefato.

A página `demo.html` permite testar categorias/produtos sem login. Tudo fica no localStorage deste navegador; não há conta compartilhada ou banco remoto. Evite dados reais de clientes/fornecedores. O botão Restaurar exemplo solicita confirmação.

## Desenvolvimento / QA

```bash
npm install
npx playwright install chromium
npm run build:pages
npm run test:pages
```

Playwright testa telas de 320, 375, 768, 1366 e 1920 px, navegação de teclado, console JavaScript, overflow, CRUD local, persistência e download JSON. As screenshots aparecem como artifact `rebbity-pages-screenshots` do workflow.

## Publicação

O workflow `.github/workflows/deploy-pages.yml` executa os testes e só então faz o deploy com `actions/upload-pages-artifact` e `actions/deploy-pages`. As permissões do workflow são mínimas: `contents: read`, `pages: write`, `id-token: write`. Uma tentativa de configuração automática do Pages é feita por `actions/configure-pages`.

Se o deploy for recusado por configurações da conta/repositório, ajuste no GitHub: **Settings → Pages → Build and deployment → Source: GitHub Actions**. Se o ambiente `github-pages` limitar deploys à `main`, configure uma regra que permita a branch de publicação, ou mova o workflow já testado à branch de publicação aprovada. A URL só deve ser apresentada como **ativa** após verificar um deployment concluído com sucesso.

**Nota sobre segurança:** alterações PHP do PR #1 são independentes da publicação estática. Não concluir que o backend está homologado porque o Pages foi publicado.

## Arquivos publicados
- `index.html`, `demo.html`, `sobre.html`, `404.html`
- `css/app.css`
- `js/app.js`, `js/demo.js`
- `assets/logo.png`, `assets/restaurant.png`, `assets/market.png`
- `.nojekyll`

Qualquer mudança nessa lista exige editar conscientemente o build e renovar os testes.
