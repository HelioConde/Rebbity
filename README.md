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

## Para retomar com segurança

- Auditar configurações e **trocar credenciais antigas** caso tenham sido expostas.
- Validar todas as queries e permissões; adotar instruções SQL parametrizadas.
- Implementar autenticação/sessões seguras e controle de acesso por função.
- Isolar a aplicação do público até testes de cadastro, upload, exclusão e edição.
- Revisar conformidade e tratamento de dados pessoais de parceiros e clientes.

Este repositório permanece como **registro de aprendizado em PHP e produto de delivery**.

Desenvolvido por [Hélio Conde](https://github.com/HelioConde).
