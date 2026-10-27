# Revisão adicional do portal PHP

Esta etapa amplia a branch de segurança, **sem integrar o backend ao site público**.

- DELETE de item e subcategoria: parâmetros inteiros validados e condição `id_client` no WHERE.
- Criação de item: verifica se a categoria pertence ao parceiro autenticado, usa prepared statements e valida uploads.
- Criação de subcategoria + item: transação SQL, para evitar subcategoria vazia se o segundo INSERT falhar.
- Upload opcional limitado a 2 MB, apenas PNG/JPEG/WebP, MIME detectado no servidor e imagem de até 4096 px.
- Listagem de categorias: consulta por proprietário e escapamento HTML/JS dos nomes para evitar injeção de script.

**Pendências para uma implantação real:** CSRF em todas as ações, cadastro e todos os demais endpoints ainda não auditados, controle de tentativas de login, configuração de esquema com backup e testes end-to-end de integração MySQL. Não há validação de banco em GitHub Pages.