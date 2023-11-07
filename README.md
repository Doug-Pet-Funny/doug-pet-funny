# Doug Pet Funny

## Versão: 0.1.0

## Status do Projeto: 🚧 Em Andamento

## Tópicos

- [Descrição do projeto](#descrição-do-projeto)

- [Funcionalidades](#funcionalidades)

- [Distribuição](#distribuição)

- [Pré-requisitos](#pré-requisitos)

- [Como rodar a aplicação](#como-rodar-a-aplicação)
  - [Com Docker](#com-docker)
  - [Sem Docker](#sem-docker)

- [Testes realizados](#testes-realizados)
   - [Informativo](#informativo)
   - [Testes de Sistema](#testes-de-sistema)
   - [Testes de Aceitação](#testes-de-aceitação)
   - [Testes de Caixa Branca](#testes-de-caixa-branca)

- [Banco de Dados](#banco-de-dados)

- [Linguagens, dependências e libs utilizadas](#linguagens-dependencias-e-libs-utilizadas)

- [Desenvolvedores/Contribuintes](#desenvolvedorescontribuintes)

## Descrição do projeto

O projeto consiste em um site com um painel administrativo do tipo ERP para organização e gerenciamento dos recursos do petshop Doug Pet Funny

## Funcionalidades

- Gerenciamento de Clientes e Pets
- Gerenciamento de Pedidos
- Dashboard interativa para relatório de pedidos

## Distribuição

TODO: Link para teste da versão disponibilizada.

## Pré-requisitos

- [Docker](https://www.docker.com/)
- Acesso à internet

ou

- [PHP](https://www.php.net/) +8.2
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en)
- Acesso à internet.

## Como rodar a aplicação

### Com Docker

#### 1. Clone o repositório e acesse o diretório

Realize o clone do repositório utilizando o comando:

```bash
git clone https://github.com/Doug-Pet-Funny/doug-pet-funny.git
```

#### 2. Acesse a pasta do projeto

Acesse a pasta clonada com o utilizando o comando:

```bash
cd doug-pet-funny
```

#### 3. Abra o Terminal

Abra um terminal ou prompt de comando no diretório onde você clonou o repositório do projeto.

#### 4. Instale as dependências do Laravel

Execute o seguinte comando para instalar as dependências do Laravel usando o Composer em Docker:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

#### 5. Inicialize os contêineres Docker com Laravel Sail

Para iniciar todos os contêineres Docker em segundo plano, você pode iniciar o Sail no modo "desanexado":

```bash
sail up -d
```

#### 6. Instale as dependências do Node.js

Execute o seguinte comando para instalar as dependências Node do projeto usando o NPM em Docker:

```bash
sail npm install
```

#### 7. Gere uma chave de aplicativo

Execute o seguinte comando para gerar uma chave de aplicativo:

```bash
sail artisan key:generate
```

#### 8. Gere um link com storage

Execute o seguinte comando para gerar um link simbólico com a pasta storage:

```bash
sail artisan storage:link
```

#### 9. Execute as migrações e as sementes (se aplicável)

Se o projeto Laravel requer migrações e sementes, execute os seguintes comandos:

```bash
sail artisan migrate
sail artisan db:seed
```

#### 12. Inicie o servidor de desenvolvimento Node

Por fim, inicie o servidor de desenvolvimento Node com o seguinte comando:

```bash
sail npm run dev
```

### Sem Docker

#### 1. Clone o repositório e acesse o diretório

Realize o clone do repositório utilizando o comando:

```bash
git clone https://github.com/Doug-Pet-Funny/doug-pet-funny.git
```

#### 2. Acesse a pasta do projeto

Acesse a pasta clonada com o utilizando o comando:

```bash
cd doug-pet-funny
```

#### 3. Abra o Terminal

Abra um terminal ou prompt de comando no diretório onde você clonou o repositório do projeto.

#### 4. Instale as dependências do Laravel

Execute o seguinte comando para instalar as dependências do Laravel usando o Composer:

```bash
composer install
```

#### 5. Instale as dependências do Node.js

Execute o seguinte comando para instalar as dependências Node do projeto usando o npm:

```bash
npm install
```

#### 6. Configure o arquivo .env

Renomeie o arquivo `.env.example` para `.env`. Você pode fazer isso manualmente ou executar o seguinte comando:

```bash
cp .env.example .env
```

Em seguida, abra o arquivo `.env` e configure as variáveis de ambiente, como o banco de dados, de acordo com as necessidades do seu projeto.

#### 7. Configure as credenciais do banco de dados

Em seu arquivo .env, configure as credenciais do banco de dados no seguinte trecho:

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

#### 8. Gere uma chave de aplicativo

Execute o seguinte comando para gerar uma chave de aplicativo:

```bash
php artisan key:generate
```

#### 9. Gere um link com storage

Execute o seguinte comando para gerar um link simbólico com a pasta storage:

```bash
php artisan storage:link
```

#### 10. Execute as migrações e as sementes (se aplicável)

Se o projeto Laravel requer migrações e sementes, execute os seguintes comandos:

```bash
php artisan migrate
php artisan db:seed
```

#### 11. Inicie o servidor de desenvolvimento PHP

Inicie o servidor de desenvolvimento do Laravel com o seguinte comando:

```bash
php artisan serve
```

#### 12. Inicie o servidor de desenvolvimento Node

Por fim, inicie o servidor de desenvolvimento Node com o seguinte comando:

```bash
npm run dev
```

Se tudo foi configurado corretamente, seu projeto Laravel será acessível em `http://127.0.0.1:8000`.

## Testes realizados

### Informativo

| CLIENTE      | Douglas                                                                           | AMBIENTE DE TESTE      | 0.2                                          |
|--------------|-----------------------------------------------------------------------------------|------------------------|----------------------------------------------|
| PROJETO      | Doug Pet Funny                                                                    | HARDWARE               | Notebook Lenovo Ryzen 7520U                  |
| COLABORADOR  | Mateus Maranhão, Mateus Stefanelli, Vitor Pinto, Felipe Portari, Rafael Vicentini | SISTEMA OPERACIONAL    | Linux 23.04                                  |
| REVISADO     | Mateus Stefanelli e Felipe                                                        | DESCRIÇÃO DO SOFTWARE  | Opera GX versão LVL 5 (core: 102.0.4880.104) |
| DATA CRIAÇÃO | 07/09/2023                                                                        | AMBIENTE DE TESTE      | 0.2                                          |
| TESTADO POR  | Mateus Maranhão, Mateus Stefanelli, Felipe Portari, Rafael Vicentini              | HARDWARE               | Notebook Dell Intel 7 Oitava Geração         |

### Testes de Sistema

| ID | TITULO | FUNCIONALIDADE/COMPONENTE | EXECUÇÃO                    | RESULTADO ESPERADO                    | STATUS | OBS. |
|----|--------|---------------------------|-----------------------------|---------------------------------------|--------|------|
| 1  | Login  | Campo usuário e senha     | Email correto e senha correta   | Login concluído                       | ok     |      |
| 2  | Login  | Campo usuário e senha     | Email correto e senha incorreta  | Retorna uma mensagem + falha no login | ok     |      |
| 3  | Login  | Campo usuário e senha     | Email correto e senha vazia   | Retorna uma mensagem + falha no login | ok     |      |
| 4  | Login  | Campo usuário e senha     | Email incorreto e senha correta  | Retorna uma mensagem + falha no login | ok     |      |
| 5  | Login  | Campo usuário e senha     | Email incorreto e senha incorreta | Retorna uma mensagem + falha no login | ok     |      |
| 6  | Login  | Campo usuário e senha     | Email vazio e senha correta   | Retorna uma mensagem + falha no login | ok     |      |
| 7  | Login  | Campo usuário e senha     | Ambos vazios                | Retorna uma mensagem + falha no login | ok     |      |
| 8  | Login  | Campo usuário e senha     | Email incorreto e senha vazia  | Retorna uma mensagem + falha no login | ok     |      |

### Testes de Aceitação

| ID | REQUISITO        | OPERAÇÃO                                                                             | RESULTADO ESPERADO                                                       | COMENTÁRIO DO CLIENTE | STATUS | RISCOS/AÇÕES |
|----|------------------|--------------------------------------------------------------------------------------|--------------------------------------------------------------------------|-----------------------|--------|--------------|
| 1  | Recuperar senha  | Inserir um email existente/cadastrado e receber a recuperação de senha no email      | Receber um email com o link de redefinição de senha, Alteração da senha. |                       | OK     |              |
| 2  | Editar um pedido | Trocar informações de um pedido                                                      | Atualizar um pedido                                                      |                       | OK     |              |
| 3  | Login            | Inserir um email existente/cadastrado e sua respectiva senha + Clicar no botão login | Entrar no sistema                                                        |                       | OK     |              |
| 4  | Editar um pedido | Trocar informações de um pedido                                                      | Atualizar um pedido                                                      |                       | OK     |              |

### Testes de Caixa Branca

| PROJETO / SISTEMA | Doug Pet Funny                 |
|-------------------|--------------------------------|
| REVISOR           | Mateus Rodrigues e Vitor Bizarra|
| DATA DA REVISÃO   | 06/11/2023                     |

| ID | ITEM                                                               | STATUS | ARTEFATO COM ERRO | CORREÇÕES A SEREM REALIZADAS |
|----|--------------------------------------------------------------------|--------|-------------------|------------------------------|
| 1  | O código está documentado conforme os padrões da empresa?          | SIM    |                   |                              |
| 2  | Os arquivos e classes estão com a nomenclatura significativa?      | SIM    |                   |                              |
| 3  | As variáveis e as constantes estão com nomenclatura significativa? | SIM    |                   |                              |
| 4  | Existe algum loop sem condição de parada?                          | NÃO    |                   |                              |
| 5  | Existe alguma variável não inicializada?                           | NÃO    |                   |                              |
| 6  | O código obedece a arquitetura definida para o sistema?            | SIM    |                   |                              |
| 7  | Foi realizado o tratamento de exceções?                            | SIM    |                   |                              |

## Banco de Dados

Para a criação das tabelas do banco de dados utilizamos o comando:

```bash
php artisan migrate
```

Ou, se estiver utilizando Docker com Laravel Sail:

```bash
sail artisan migrate
```

## Linguagens, dependencias e libs utilizadas

- Laravel
- Docker
- Composer
- NPM

## Desenvolvedores/Contribuintes

<table>
        <tbody>
            <tr>
                <td align="center" width="14.28%">
                    <a href="https://github.com/felipeportari">
                        <img src="https://avatars.githubusercontent.com/u/124217908?s=96&v=4" width="100px;"
                            alt="Felipe Portari" />
                        <br />
                        <sub><b>Felipe Portari</b></sub>
                    </a>
                </td>
                <td align="center" width="14.28%">
                    <a href="https://github.com/mateusmaranhaogit">
                        <img src="https://avatars.githubusercontent.com/u/101333760?s=96&v=4" width="100px;"
                            alt="Mateus Maranhão" />
                        <br />
                        <sub><b>Mateus Maranhão</b></sub>
                    </a>
                </td>
                <td align="center" width="14.28%">
                    <a href="https://github.com/MateusSemh">
                        <img src="https://avatars.githubusercontent.com/u/103202120?s=96&v=4" width="100px;"
                            alt="Mateus Sem H" />
                        <br />
                        <sub><b>Mateus Sem H</b></sub>
                    </a>
                </td>
                <td align="center" width="14.28%">
                    <a href="https://github.com/RPL13">
                        <img src="https://avatars.githubusercontent.com/u/99340714?s=96&v=4" width="100px;"
                            alt="Raphael Vicentini" />
                        <br />
                        <sub><b>Raphael Vicentini</b></sub>
                    </a>
                </td>
                <td align="center" width="14.28%">
                    <a href="https://github.com/vitorbizarra">
                        <img src="https://avatars.githubusercontent.com/u/79993997?v=4" width="100px;"
                            alt="Vitor Bizarra" />
                        <br />
                        <sub><b>Vitor Bizarra</b></sub>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>

## Licença

The MIT License (MIT)

## Copyright ©️ 2023 - Doug Pet Funny
