# Rebbity — migração de credenciais PHP

As configurações históricas incluíam segredos no próprio repositório. Este ajuste remove valores embutidos no código atual, mas não remove o histórico de commits.

## Antes de integrar no servidor PHP
1. Revogar e **rotacionar** credenciais antigas no painel da hospedagem, inclusive banco e FTP.
2. Disponibilizar no processo PHP, fora do Git e fora do diretório público, as variáveis REBBITY_DB_HOST, REBBITY_DB_USER, REBBITY_DB_PASSWORD e REBBITY_DB_NAME.
3. Testar a conexão em ambiente de homologação com dados fictícios.
4. Conferir a sintaxe com php -l config.php, php -l config2.php e php -l backupconfig.php.
5. Antes de aceitar dados reais, revisar SQL parametrizado, CSRF, controle de permissões e política de privacidade.
6. Se for necessária limpeza do histórico Git, planejar em separado, pois pode exigir reescrita de branches e clones.

## GitHub Pages
A publicação pública deve continuar contendo apenas recursos estáticos. Nunca incluir PHP, SQL, credenciais ou banco no artefato. Não há autenticação real nem dados compartilhados na demonstração.
