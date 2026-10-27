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

O workflow `.github/workflows/publish-rebbity-pages.yml` **na branch `main`** executa novamente os testes e depois faz o deploy com `actions/upload-pages-artifact` e `actions/deploy-pages`. Ele utiliza um commit previamente validado da branch de modernização, sem mesclar alterações PHP ainda não homologadas. As permissões do workflow são mínimas: `contents: read`, `pages: write`, `id-token: write`. Uma tentativa de configuração automática do Pages é feita por `actions/configure-pages`.

O deploy pela `main` foi confirmado com sucesso em 27/10/2026: https://github.com/HelioConde/Rebbity/actions/runs/40460035840. Para publicações futuras, atualize conscientemente o `ref` pinado no workflow da `main` após passar o QA. Se o deploy voltar a ser recusado por configurações do repositório, ajuste no GitHub: **Settings → Pages → Build and deployment → Source: GitHub Actions**. Se o ambiente `github-pages` limitar deploys à `main`, configure uma regra que permita a branch de publicação, ou mova o workflow já testado à branch de publicação aprovada. URL do deployment informada pelo GitHub: https://helioconde.github.io/Rebbity/ . A entrega do GitHub Actions foi confirmada; verificações externas de carregamento podem depender de propagação e cache.

**Nota sobre segurança:** alterações PHP do PR #1 são independentes da publicação estática. Não concluir que o backend está homologado porque o Pages foi publicado.

## Arquivos publicados
- `index.html`, `demo.html`, `sobre.html`, `404.html`
- `css/app.css`
- `js/app.js`, `js/demo.js`
- `assets/logo.png`, `assets/restaurant.png`, `assets/market.png`
- `.nojekyll`

Qualquer mudança nessa lista exige editar conscientemente o build e renovar os testes.


## Catálogos independentes (atualização de 27/10/2026)

- `demo.html?tipo=restaurante` mantém o catálogo do restaurante, inclusive dados anteriores em `rebbity-demo-catalog-v2`.
- `demo.html?tipo=mercado` inicia com exemplos de hortifruti, mercearia e bebidas e utiliza `rebbity-demo-market-v1`; as lojas **não compartilham** o mesmo armazenamento.
- O botão **Importar JSON** aceita até 1 MiB; valida IDs únicos, relações entre categoria e produto, textos e preços. Confirma a substituição antes de gravar.
- **Desfazer alteração** recupera o último estado local antes de um cadastro, edição, exclusão, restauração ou importação; não é histórico permanente.
- Os limites são de 60 categorias e 2.000 produtos por catálogo. Não existe backup remoto. Utilize **Exportar JSON** para guardar uma cópia local.
- O modo demonstrativo nunca transforma os exemplos em pedidos reais; não insira dados pessoais, senhas ou dados financeiros.
- O CI cobre fluxos de mercado e restaurante separados, recuperação após exclusão, importação inválida e válida, além de testar o layout em 5 resoluções.
