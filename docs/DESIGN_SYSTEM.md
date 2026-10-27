# Rebbity — Design System v0.1 (fundação)

> Base observada no CSS legado; valores ainda precisam ser validados por contraste e testes visuais. A inclusão de tokens **não significa** que todos os componentes existentes os utilizem.

## Direção

- **Produto:** portal de cadastro e operação de parceiros de delivery.
- **Personalidade:** acolhedor, profissional, objetivo, sem telas excessivamente densas.
- **Hierarquia:** ação principal evidente; navegação separada de conteúdo; formulários em etapas; feedback imediato.
- **Prioridade:** acessibilidade e legibilidade antes de efeitos decorativos.

## Tokens propostos

| Categoria | Token | Valor inicial |
| --- | --- | --- |
| Marca | `--rb-brand` | `#ea1d2c` (vermelho já usado no portal) |
| Texto | `--rb-text` | `#3e3e3e` |
| Superfície | `--rb-surface` | `#ffffff` |
| Fundo alternativo | `--rb-surface-muted` | `#f2f2f2` |
| Foco | `--rb-focus` | `#005fcc` |
| Espaçamento | `--rb-space-{1..8}` | `4,8,12,16,20,24,32,40px` |
| Arredondamento | `--rb-radius-sm/md/lg` | `6/10/16px` |
| Sombra | `--rb-shadow-sm` | `0 2px 8px rgb(0 0 0 / 10%)` |

Arquivos: `css/foundation.css` (compartilhado), `css/index.css` (landing) e `portal/css/style.css` (área interna). Migrar seletores antigos para tokens gradualmente.

## Componentes e comportamento

1. **Navegação:** links de verdade, estado ativo, foco visível, menu mobile com botão e `aria-expanded`, fechar por Escape.
2. **Botões:** variantes primário/secundário/destrutivo; desabilitado com explicação; nenhum botão sem ação.
3. **Campos:** `label` único por id, tipos corretos, `required`, mensagens associadas por `aria-describedby`, sem esconder erros apenas por cor.
4. **Formulários:** um grupo de decisões por etapa, indicadores de progresso e preservação de entradas.
5. **Cards:** títulos curtos, conteúdo útil e CTA; sem acumular caixas desnecessárias.
6. **Diálogos:** foco contido, retorno ao elemento disparador e fechamento acessível.
7. **Feedback:** `role=alert` para falhas, estados de carregamento e vazio, sucesso sem redirecionar silenciosamente.
8. **Listas de itens:** ações editar/excluir com confirmação, loading e resultados que respeitam a autorização do parceiro.

## Layout e tipografia

- Base 16px, títulos responsivos via `clamp()`, largura de texto 65–75 caracteres.
- Alvos interativos adequados ao toque, preferencialmente 44×44px.
- Grid progressivo para mobile; a sidebar não deve cobrir o conteúdo.
- Comparar em 320px, 375px, 390px, 768px, 1024px, 1366px e 1920px.

## Checklist de aceite visual

- [ ] Contraste do texto e foco verificado conforme WCAG AA.
- [ ] Todo elemento interativo funciona por Tab/Enter/Space e indica foco.
- [ ] Animação reduzida respeita preferências do sistema.
- [ ] Zoom 200% funciona sem perda de conteúdo.
- [ ] Screenshots de referência e screenshots depois da alteração foram revisados.
- [ ] Componentes usam tokens em vez de novas cores e espaçamentos avulsos.

## Estado

Fundação documentada. Redesenho de telas, migração de CSS e auditoria de acessibilidade **pendentes**. Ver `docs/AUDITORIA_E_ROADMAP.md`.

## Demonstração pública — regras validadas na main

A demonstração estática do GitHub Pages e o portal PHP de parceiros são produtos tecnicamente distintos. O PHP/MySQL modernizado nesta branch **não** é distribuído nem homologado pelo Pages. A publicação da demonstração depende do workflow `publish-rebbity-pages.yml`, com validação Playwright em cinco resoluções e reutilização do artefato aprovado.

## Gate de QA do Pages (27/10/2026)
- Fluxo separado em **validate → deploy**, com PRs executando somente validação. Mesmo commit/snapshot, mesmo pacote para teste e publicação.
- Testar HTML, cartão de produtos e CRUD de exemplo em cinco resoluções com Chromium/Playwright. Capturas ficam como artefatos para análise; o checkout está fixado no snapshot público atualizado `8131cf96a2616f19ba202a1ebbf8f28d58236ec0`.
- Não mesclar mudanças no backend como solução de Pages. A adoção de um snapshot público mais recente requer PR própria, revisão de arquivos permitidos e confirmação do novo SHA.
- O bundle não inclui PHP, SQL, SQLite, banco remoto, chaves, .env nem links simbólicos. O navegador usa apenas dados de demonstração salvos localmente.

## Feedback de gravação indisponível
O editor apresenta alerta visual e semântico (`role="alert"`, `aria-live="assertive"`) quando `localStorage.setItem` falha. A mensagem de erro não pode ser substituída por confirmações falsas ao editar, desfazer, importar ou trocar de loja. O usuário pode exportar um JSON com o estado em memória antes de fechar a página. Snapshot público homologado: `8131cf96a2616f19ba202a1ebbf8f28d58236ec0`. Testes Playwright repetem a falha em cinco larguras.
