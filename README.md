<div align="center">
  <h1>🍔 Rebbity — Portal de Parceiros</h1>
  <p><strong>Projeto histórico de uma plataforma web para cadastro e operação de parceiros de delivery.</strong></p>
  <p><img alt="PHP" src="https://img.shields.io/badge/PHP-Backend-777BB4?logo=php&logoColor=white"> <img alt="MySQL" src="https://img.shields.io/badge/MySQL-Dados-4479A1?logo=mysql&logoColor=white"> <img alt="Status" src="https://img.shields.io/badge/status-legado-64748b"></p>
</div>

## O que este projeto demonstra

O Rebbity reuniu uma **página para atrair parceiros** e áreas internas para experimentar cadastro de mercados/restaurantes, organização de categorias, itens de cardápio e serviços relacionados a delivery.

A proposta é maior que uma landing page, mas **não há comprovação de que esses fluxos estejam prontos para operação comercial atual**.

## Estrutura encontrada

| Caminho | Papel |
| --- | --- |
| `index.html` | Página de apresentação e entrada para parceiros |
| `portal/index.html` | Interface de portal de operações |
| `portal/cardapio.html` | Tela de cardápio |
| `insert_restaurant.php` / `insert_market.php` | Rotinas históricas de inclusão |
| `portal/insertItem.php` | Inclusão de itens |
| `authentication.php` | Fluxo legado de autenticação |
| `config.php`, `config2.php`, `backupconfig.php` | Configuração a ser auditada |
| `banco_teste.sql` | Script SQL histórico, não migrado automaticamente |
| `css/`, `js/`, `img/` | Identidade visual e recursos |

## Visualizar localmente

Para a parte estática:

```bash
git clone https://github.com/HelioConde/Rebbity.git
cd Rebbity
python -m http.server 8000
```

Abra `http://localhost:8000`. Para as rotinas PHP é necessário **servidor PHP e banco compatível configurado**, em um ambiente de teste separado.

> **Importante:** o código do portal tem referências a autenticação/sessões históricas que precisam ser auditadas. Não presuma que acessar `portal/index.html` representa uma área protegida: a proteção deve ser aplicada no servidor.


## Estado atual da modernização

O código modernizado está em PR, não necessariamente implantado. Veja o [status de cada uma das 26 etapas](docs/STATUS_IMPLEMENTACAO.md), com testes e pendências explícitas. A versão protegida do portal usa `portal/index.php` e requer PHP/MySQL; `portal/index.html` apenas redireciona.

Para executar localmente sem credenciais reais, consulte [ambiente e segurança](docs/AMBIENTE_E_SEGURANCA.md).

## Plano de modernização (2026)

Consulte a [auditoria e roteiro de execução](docs/AUDITORIA_E_ROADMAP.md) e o [design system inicial](docs/DESIGN_SYSTEM.md).

A primeira etapa introduz tokens, foco visível, movimento reduzido e uma lista explícita de rotas AJAX permitidas. **Isso não corrige a autenticação, o controle de acesso nem a exposição histórica de segredos**. Antes de publicar: rotacione todas as credenciais versionadas, proteja o portal no servidor e execute os testes de segurança do roteiro.

## Para retomar com segurança

- Auditar configurações e **trocar credenciais antigas** caso tenham sido expostas.
- Validar todas as queries e permissões; adotar instruções SQL parametrizadas.
- Implementar autenticação/sessões seguras e controle de acesso por função.
- Isolar a aplicação do público até testes de cadastro, upload, exclusão e edição.
- Revisar conformidade e tratamento de dados pessoais de parceiros e clientes.

Este repositório permanece como **registro de aprendizado em PHP e produto de delivery**.

Desenvolvido por [Hélio Conde](https://github.com/HelioConde).

## Publicação da demonstração com gate de QA (27/10/2026)
A Action `.github/workflows/publish-rebbity-pages.yml` passa a executar em PRs e na `main`. O job `validate` sempre faz checkout do snapshot público fixado em `d53e4d36690a1c13a44ede1f223731f525854d28`, gera `dist-pages` por allowlist, bloqueia PHP/SQL/segredos/links simbólicos e roda os testes Playwright em cinco resoluções. Somente após aprovação o job `deploy` baixa **o mesmo artefato** da execução e publica no Pages. PRs jamais executam o deploy.

Este gate **não incorpora automaticamente** os arquivos PHP de outras PRs. O site demonstrativo permanece congelado no snapshot validado até uma migração estática aprovada atualizar explicitamente o SHA. O snapshot não contém `package-lock.json`, então a instalação continua com `npm install` e não é apresentada como reprodução perfeita das versões transitivas. O navegador Chromium é instalado sem buscar bibliotecas adicionais do Ubuntu via `apt-get`.

## Aviso correto quando o armazenamento local falha (27/10/2026)
A demonstração publicada usa o snapshot estático revisado `8131cf96a2616f19ba202a1ebbf8f28d58236ec0`, desenvolvido na branch `fix/rebbity-demo-storage-feedback-20261027`. Se o navegador bloquear `localStorage` (por permissão ou limite de espaço), o painel **não anuncia falsamente “salvo” ou “catálogo carregado”**: mantém uma mensagem de erro acessível e orienta exportar JSON. As edições continuam visíveis na sessão, mas podem desaparecer ao recarregar. O Playwright simula a falha, verifica a mensagem, a exportação e a troca de tipo de loja em cinco resoluções.

O Pages continua verificando por allowlist o mesmo pacote que será publicado, sem PHP, SQL nem credenciais.
