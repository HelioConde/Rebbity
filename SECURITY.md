# Segurança — backend legado e demonstração pública

**Importante:** este repositório preserva código PHP/MySQL histórico e não deve ser publicado diretamente como aplicação pronta para usuários reais.

1. Substituir e revogar credenciais, senhas de teste e tokens que possam ter aparecido no código ou histórico. Remover da versão atual não apaga o histórico.
2. Manter segredos somente em variáveis de ambiente do provedor de hospedagem (nunca em GitHub Pages ou JavaScript público).
3. Usar prepared statements parametrizados nas operações SQL, inclusive criação/edição de restaurante, mercado, categoria e item.
4. Implementar sessões seguras (HttpOnly/Secure/SameSite), CSRF e autorização do proprietário de cada recurso.
5. Validar entrada e upload de imagens (tipo, extensão, assinatura real, tamanho, diretório fora do webroot quando possível).
6. Testar integridade referencial, repetição de requisições, limites e erros sem retornar detalhes do banco ao navegador.
7. Publicar no GitHub Pages **somente** o artefato estático auditado. O frontend demonstrativo não registra usuários reais e não tem banco.

A documentação registra riscos, mas **não certifica** o backend legado como corrigido.
## Proteção adicional do deploy estático (27/10/2026)
- A Action faz checkout de um commit estático previamente validado, e não copia os PHP da branch `main` para o site.
- Uma etapa adicional bloqueia a publicação se o pacote contiver PHP, SQL, bancos locais, chaves privadas, arquivos `.env` ou links simbólicos.
- O fluxo somente publica se os testes de páginas estáticas e o isolamento do artefato forem aprovados.
- Esses controles de CI **não corrigem** nem removem credenciais que possam existir no histórico do repositório; a revogação cabe ao responsável por essas credenciais.

## Controles de QA e publicação em PRs (27/10/2026)
- Em PRs, apenas o job de validação do snapshot público executa; nenhuma página é publicada por código ainda não integrado.
- O deploy exige sucesso da validação na **mesma execução** e reutiliza o artefato aprovado, reduzindo divergência entre código testado e publicado.
- Permissões `pages: write` e `id-token: write` ficam restritas ao job de deploy (não aos testes das PRs).
- A proteção por allowlist é repetida depois de baixar o artefato de CI, sem incluir scripts PHP, credenciais ou arquivos SQL legados.
- O snapshot usado no Pages permanece fixo e independente das PRs de PHP; essas PRs exigem revisão de segurança específica e não são homologadas por este workflow estático.

## Rebbity Pages — dados locais indisponíveis
A demonstração não tenta contornar ou ocultar erros de armazenamento do navegador. O snapshot `8131cf96a2616f19ba202a1ebbf8f28d58236ec0` anuncia a falha com `role="alert"` e orienta exportar JSON; nunca apresenta uma escrita recusada como salva. O bloqueio é coberto por regressão Playwright. Isso **não** implementa backup remoto nem altera a autenticação PHP original.
