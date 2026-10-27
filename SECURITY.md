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
## Atualização de configuração (27/10/2026)
As três configurações históricas (config.php, config2.php, backupconfig.php) passaram a exigir variáveis de ambiente REBBITY_DB_HOST, REBBITY_DB_USER, REBBITY_DB_PASSWORD e REBBITY_DB_NAME. Ausências causam erro HTTP 503 sem expor credenciais. **Configurar no provedor PHP antes da integração** para evitar indisponibilidade do backend legado.

Senhas ou tokens anteriormente expostos precisam ser revogados/rotacionados no provedor, inclusive FTP. Remover da versão atual não apaga o histórico Git. O GitHub Pages continua publicando somente arquivos estáticos auditados.
