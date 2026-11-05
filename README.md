# Sistema de Entregas

Aplicação web para gerenciar clientes e pedidos de uma empresa de logística, desenvolvida em **Laravel** com banco de dados **PostgreSQL** hospedado no **Neon**. Projeto Avaliativo do 2º Bimestre, 4º período, Engenharia de Software, Centro Universitário Campo Real. Avalia as disciplinas de Banco de Dados II e Back-end.

O banco de dados usado é o desenvolvido por um dos integrantes no 1º bimestre (schema `Matheus_trabalho_BD`), com as tabelas `cliente`, `pedido`, `pagamento`, `entrega`, `motorista`, `veiculo`, `rota`, `ocorrencia` e `log_status_entrega`.

## Integrantes

- Gabriel Goes
- Matheus
- Gustavo

## Tecnologias

- PHP 8.4 ou superior
- Laravel 13
- PostgreSQL (hospedado no Neon)
- Blade (templates)
- Git e GitHub
- PHPUnit (testes automatizados)

## Requisitos para rodar

- PHP 8.4 ou superior, com as extensões `pdo_pgsql`, `mbstring`, `xml`, `curl`, `zip` e `intl`
- Composer
- Acesso ao banco do Neon (a string de conexão é passada pelo grupo e não fica no repositório)

## Como configurar

1. Clone o repositório e entre na pasta:

```bash
git clone https://github.com/GabrielGoesdev13/projetobancoback.git
cd projetobancoback
```

2. Instale as dependências:

```bash
composer install
```

3. Crie o arquivo de ambiente e gere a chave da aplicação:

```bash
cp .env.example .env
php artisan key:generate
```

4. Abra o arquivo `.env` e troque o bloco do banco de dados pelos dados do Neon:

```
DB_CONNECTION=pgsql
DB_HOST=SEU_HOST_DO_NEON
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=SEU_USUARIO
DB_PASSWORD=SUA_SENHA
DB_SSLMODE=require
DB_SCHEMA=Matheus_trabalho_BD
```

5. No mesmo arquivo, troque estas três linhas, porque o banco não possui as tabelas de sessão, cache e fila do Laravel:

```
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
CACHE_STORE=file
```

6. Confira se o Laravel enxerga as tabelas:

```bash
php artisan tinker --execute="echo DB::table('cliente')->count();"
```

Deve aparecer a quantidade de clientes cadastrados.

**Importante:** o arquivo `.env` contém a senha do banco e não deve ser enviado ao GitHub. Ele já está no `.gitignore`.

## Como executar

```bash
php artisan serve
```

Acesse `http://127.0.0.1:8000`. A página inicial redireciona para a lista de clientes.

Se estiver usando o GitHub Codespaces, abra a aplicação pelo endereço encaminhado da porta 8000, na aba **Portas**.

## Como executar os testes

```bash
php artisan test
```

Os testes rodam em um banco SQLite em memória, configurado no arquivo `phpunit.xml`, e não acessam o banco do Neon. A estrutura das tabelas é criada para o teste pela migration `create_sistema_entregas_tables`.

Testes implementados:

| Teste | Tipo | O que verifica |
|---|---|---|
| `test_lista_de_clientes_exibe_os_dados_cadastrados` | Rota web | A listagem abre (status 200) e mostra os dados do cliente |
| `test_cadastro_de_cliente_grava_no_banco_e_redireciona` | Rota web | O cadastro grava no banco e redireciona para a listagem |
| Testes de API | Rota de API | A completar |

## Estrutura do código (Back-end)

| Recurso | Arquivos |
|---|---|
| Models | `app/Models` (uma Model para cada tabela, com relacionamentos) |
| Resource Controllers | `ClienteController` e `PedidoController` em `app/Http/Controllers` |
| Rotas web | `routes/web.php` |
| Views Blade | `resources/views/clientes`, `resources/views/pedidos` e `resources/views/layouts` |
| Migrations | `database/migrations` |
| Testes | `tests/Feature/ClienteWebTest.php` |

As Models apontam para as tabelas já existentes no Neon, com chaves primárias próprias (`id_cliente`, `id_pedido` e assim por diante) e sem as colunas `created_at` e `updated_at`.

A migration `create_sistema_entregas_tables` só cria cada tabela se ela ainda não existir. No Neon, onde as tabelas já existem, ela não altera nada. No banco de testes, que começa vazio, ela cria toda a estrutura. O método `down()` é vazio de propósito, para que um rollback não apague as tabelas reais.

## Rotas web

### Clientes

| Método | Rota | Objetivo |
|---|---|---|
| GET | `/clientes` | Lista os clientes, com paginação |
| GET | `/clientes/create` | Formulário de cadastro |
| POST | `/clientes` | Grava um novo cliente |
| GET | `/clientes/{cliente}` | Mostra os dados de um cliente |
| GET | `/clientes/{cliente}/edit` | Formulário de edição |
| PUT/PATCH | `/clientes/{cliente}` | Atualiza um cliente |
| DELETE | `/clientes/{cliente}` | Exclui um cliente |

### Pedidos

| Método | Rota | Objetivo |
|---|---|---|
| GET | `/pedidos` | Lista os pedidos, com o nome do cliente |
| GET | `/pedidos/create` | Formulário de cadastro |
| POST | `/pedidos` | Grava um novo pedido |
| GET | `/pedidos/{pedido}` | Mostra os dados de um pedido |
| GET | `/pedidos/{pedido}/edit` | Formulário de edição |
| PUT/PATCH | `/pedidos/{pedido}` | Atualiza um pedido |
| DELETE | `/pedidos/{pedido}` | Exclui um pedido |

Exemplo de uso: para cadastrar um cliente, acesse `/clientes`, clique em **Novo cliente**, preencha todos os campos (o banco não aceita e-mail, telefone ou cidade vazios) e clique em **Salvar**.

Um pedido que já tem pagamentos ou entregas ligados a ele não pode ser excluído, e o sistema mostra uma mensagem explicando o motivo.

## Rotas de API

A completar.

## Banco de dados

Objetos do PostgreSQL (índices, functions, stored procedures e triggers), scripts SQL e procedimento de backup e restauração: a completar.

## Versionamento

O código-fonte é mantido neste repositório Git, e cada integrante faz commits com o próprio usuário.