# Rebbity — Design System e critérios de conclusão

## Objetivo
Modernizar a plataforma antiga de parceiros sem expor credenciais, dados de cadastro nem endpoints PHP em GitHub Pages. A demonstração Pages usa dados de exemplo, enquanto a aplicação comercial original requer hospedagem com backend e banco separados.

## Taste Skill
- Espaçamento: múltiplos de 4px, com 8/12/16/24/32 como escala principal.
- Painéis, botões e cartões consistentes; estados claros para foco, carregamento, erro e vazio.
- Contraste: confirmar WCAG AA em texto, form e alertas. Preferir fundos neutros com uma cor de ação reconhecível.

## Web Design Guidelines
- Navegação por teclado e foco visível, rótulos de campos, cabeçalhos semânticos, dimensões de toque mínimas, feedback para ações destrutivas.
- Respeitar reduced-motion; layouts adaptativos sem rolagem horizontal em 390, 768, 1366 e 1600px.
- Nunca alegar persistência remota, pagamento ou login verdadeiro na demonstração Pages.

## Awesome Design / Image to Code
- Preservar a identidade de marketplace de restaurante e mercado.
- Hierarquia recomendada: pesquisa, navegação por categorias, produto, preço, carrinho/resultado, confirmação.
- Capturas reais antes de cada redesenho; evitar trocar os ativos históricos por arte genérica.

## GitHub Pages e isolamento
- Fluxo publicado no workflow publish-rebbity-pages.yml extrai a demonstração estática de snapshot validado.
- Verificar em cada mudança que nenhum PHP, SQL, upload privado, credencial ou configuração de banco chegue a dist-pages.
- A plataforma PHP/MySQL legado **não executa** no GitHub Pages. Não apresentar a demonstração como produção segura.

## Playwright CLI
- Auditoria visual desktop/mobile, navegação por teclado, feedback de operações locais, exportação/importação de dados fictícios, console, rede e acessibilidade.
- Build, segurança e QA da demonstração não substituem testes de integração de cadastro/autenticação do servidor PHP.

## Critério de pronto
Página pública sem backend, sem segredo no artefato, fluxo de demonstração funcional, CI verde; implementação real só após credenciais externas, SQL parametrizado, CSRF, sessões, upload seguro e revisão LGPD.
## Gate do deploy
O job `publish-rebbity-pages` preserva o checkout do snapshot validado, monta um conjunto restrito de recursos estáticos, bloqueia arquivos PHP, SQL, bancos e chaves no `dist-pages` e só depois executa Playwright e deploy. Essa separação impede que uma alteração do backend legado seja publicada inadvertidamente como se fosse JavaScript de cliente.

## Gate de QA do Pages (27/10/2026)
- Fluxo separado em **validate → deploy**, com PRs executando somente validação. Mesmo commit/snapshot, mesmo pacote para teste e publicação.
- Testar HTML, cartão de produtos e CRUD de exemplo em cinco resoluções com Chromium/Playwright. Capturas ficam como artefatos para análise; o checkout é imutável e usa o SHA `d53e4d36690a1c13a44ede1f223731f525854d28`.
- Não mesclar mudanças no backend como solução de Pages. A adoção de um snapshot público mais recente requer PR própria, revisão de arquivos permitidos e confirmação do novo SHA.
- O bundle não inclui PHP, SQL, SQLite, banco remoto, chaves, .env nem links simbólicos. O navegador usa apenas dados de demonstração salvos localmente.
