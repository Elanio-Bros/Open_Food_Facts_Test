# Api Open Food Facts

>  This is a challenge by [Coodesh](https://coodesh.com/)

## Resume
Api tem como ideia puxar dados do banco de dados público [Open Food Facts](https://br.openfoodfacts.org) utilizando da framework Laravel para a inserção dos dados no mongodb via cron, a criação de rotas para listagem e manipulação dos dados, criação de testes de integração do sistema e autenticação via JWT para seguraça.

O sistema já vem com um admin pré-registrado:
> User: admin <br/>
> Email: admin@email.com.br <br/>
> type: admin <br/>
> Password: admin%123 <br/>

E também com um user pré-registrado:
> User: user <br/>
> Email: user@email.com.br <br/>
> type: user <br/>
> Password: user_123 <br/>

<details>
<summary> Detalhes do Teste</summary>

# Detalhes do Teste [Coodesh](https://coodesh.com/)

## Introdução

Nesse desafio trabalharemos no desenvolvimento de uma REST API para utilizar os dados do projeto Open Food Facts, que é um banco de dados aberto com informação nutricional de diversos produtos alimentícios.

O projeto tem como objetivo dar suporte a equipe de nutricionistas da empresa Fitness Foods LC para que eles possam revisar de maneira rápida a informação nutricional dos alimentos que os usuários publicam pela aplicação móvel.

### Antes de começar
 
- O projeto deve utilizar a Linguagem específica na avaliação. Por exempo: Python, R, Scala e entre outras;
- Considere como deadline da avaliação a partir do início do teste. Caso tenha sido convidado a realizar o teste e não seja possível concluir dentro deste período, avise a pessoa que o convidou para receber instruções sobre o que fazer.
- Documentar todo o processo de investigação para o desenvolvimento da atividade (README.md no seu repositório); os resultados destas tarefas são tão importantes do que o seu processo de pensamento e decisões à medida que as completa, por isso tente documentar e apresentar os seus hipóteses e decisões na medida do possível.

## O projeto
 
- Criar um banco de dados MongoDB usando Atlas: https://www.mongodb.com/cloud/atlas ou algum Banco de Dados SQL se não sentir confortável com NoSQL;
- Criar uma REST API com as melhores práticas de desenvolvimento, Design Patterns, SOLID e DDD.
- Integrar a API com o banco de dados criado para persistir os dados
- Recomendável usar Drivers oficiais para integração com o DB
- Desenvolver Testes Unitários

### Modelo de Dados:

Para a definição do modelo, consultar o arquivo [products.json](./products.json) que foi exportado do Open Food Facts, um detalhe importante é que temos dois campos personalizados para poder fazer o controle interno do sistema e que deverão ser aplicados em todos os alimentos no momento da importação, os campos são:

- `imported_t`: campo do tipo Date com a dia e hora que foi importado;
- `status`: campo do tipo Enum com os possíveis valores draft, trash e published;

### Sistema do CRON

Para prosseguir com o desafio, precisaremos criar na API um sistema de atualização que vai importar os dados para a Base de Dados com a versão mais recente do [Open Food Facts](https://br.openfoodfacts.org/data) uma vez ao día. Adicionar aos arquivos de configuração o melhor horário para executar a importação.

A lista de arquivos do Open Food, pode ser encontrada em: 

- https://challenges.coode.sh/food/data/json/index.txt
- https://challenges.coode.sh/food/data/json/data-fields.txt

Onde cada linha representa um arquivo que está disponível em https://challenges.coode.sh/food/data/json/{filename}.

É recomendável utilizar uma Collection secundária para controlar os históricos das importações e facilitar a validação durante a execução.

Ter em conta que:

- Todos os produtos deverão ter os campos personalizados `imported_t` e `status`.
- Limitar a importação a somente 100 produtos de cada arquivo.

### A REST API

Na REST API teremos um CRUD com os seguintes endpoints:

 - `GET /`: Detalhes da API, se conexão leitura e escritura com a base de dados está OK, horário da última vez que o CRON foi executado, tempo online e uso de memória.
 - `PUT /products/:code`: Será responsável por receber atualizações do Projeto Web
 - `DELETE /products/:code`: Mudar o status do produto para `trash`
 - `GET /products/:code`: Obter a informação somente de um produto da base de dados
 - `GET /products`: Listar todos os produtos da base de dados, adicionar sistema de paginação para não sobrecarregar o `REQUEST`.

## Extras

- **Diferencial 1** Configuração de um endpoint de busca com Elastic Search ou similares;
- **Diferencial 2** Configurar Docker no Projeto para facilitar o Deploy da equipe de DevOps;
- **Diferencial 3** Configurar um sistema de alerta se tem algum falho durante o Sync dos produtos;
- **Diferencial 4** Descrever a documentação da API utilizando o conceito de Open API 3.0;
- **Diferencial 5** Escrever Unit Tests para os endpoints  GET e PUT do CRUD;
- **Diferencial 6** Escrever um esquema de segurança utilizando `API KEY` nos endpoints. Ref: https://learning.postman.com/docs/sending-requests/authorization/#api-key


## Readme do Repositório

- Deve conter o título do projeto
- Uma descrição sobre o projeto em frase
- Deve conter uma lista com linguagem, framework e/ou tecnologias usadas
- Como instalar e usar o projeto (instruções)
- Não esqueça o [.gitignore](https://www.toptal.com/developers/gitignore)
- Se está usando github pessoal, referencie que é um challenge by coodesh:  

>  This is a challenge by [Coodesh](https://coodesh.com/)

## Finalização e Instruções para a Apresentação

1. Adicione o link do repositório com a sua solução no teste
2. Adicione o link da apresentação do seu projeto no README.md.
3. Verifique se o Readme está bom e faça o commit final em seu repositório;
4. Envie e aguarde as instruções para seguir. Sucesso e boa sorte. =)

## Suporte

Use a [nossa comunidade](https://discord.gg/rdXbEvjsWu) para tirar dúvidas sobre o processo ou envie uma mensagem diretamente a um especialista no chat da plataforma. 
</details>

<br/>
A aplicação pode ser executado em dois modo:

<details>
<summary>Com Docker</summary>

### Necessário
 - [Docker](https://www.docker.com/) 
 - [Docker-Compose](https://docs.docker.com/compose/)

Para começar, execute os comandos:

1. Para construir a imagem e inicializar os contêineres:
```bash
docker-compose -f "docker-compose.yml" up -d --build
```

2. Execute este comando para uma configuração rápida da aplicação:

``` bash
docker exec -it api bash -c "cp .env.example .env; php artisan key:generate; php artisan jwt:secret; php artisan migrate --seed"
```
Ou execute estes abaixo para:

3. Crie uma cópia do arquivo **.env**:
```bash
docker exec -it api cp .env.example .env
```
4. Gere a chave de criptografia do aplicativo:
```bash
docker exec -it api php artisan key:generate
```
5. Gerar chave de criptografia e autenticação JWT:
```bash
docker exec -it api php artisan jwt:secret
```
6. Crie bancos de dados e segmentos iniciais:
```bash
docker exec -it api php artisan migrate --seed
```

Com seu sistema agora configurado ele irá rodar para rodar nativamente na sua máquina em:[localhost](http://localhost/).

Se desejar, execute os testes para analisar se as rotas na aplicação estão em ordem execute:
```bash
docker exec -it api php artisan test
```
Se você quiser usar um produto para testes, use o comando:
```bash
docker exec -it api php artisan db:seed --class=ProductSeeder
```
</details>


<details>
<summary>Sem Docker</summary>

### Necessário
 - [PHP 8.0](https://www.php.net/)
 - [Composer](https://getcomposer.org/)

### Importante
Antes de ativar o projeto, você deve primeiro configurar o arquivo **.env**. Este arquivo é extremamente importante para o projeto porque contém as principais configurações do sistema. O arquivo [.env.example](./.env.example) servirá como base para o nosso sistema. As variáveis ​​a serem configuradas neste arquivo são
 
<details>
<summary>Configurações .env</summary>

### Database
`DB_HOST`-> host de banco de dados<br>
`DB_DATABASE`->O banco de dados principal<br>
`DB_PORT`->Porta usada no sistema de banco de dados<br>
`DB_USERNAME`->usuário do banco de dados<br>
`DB_PASSWORD`->senha do banco de dados<br>

</details>
<br>

Após fazer as configurações apropriadas no arquivo **.env**, execute alguns comandos de terminal dentro do repositório:

1. Instale todas as dependências do projeto com o composer:
```bash
composer install
```
2. Gerar chave de criptografia do aplicativo:
```bash
php artisan key:generate
```
3. Gerar chave de criptografia e autenticação JWT:
```bash
php artisan jwt:secret
```
4. Crie bancos de dados e segmentos iniciais
```bash
php artisan migrate --seed
```
5. Iniciar um servidor local
```bash
php artisan serve
```

## Finished
Se você quiser usá-lo em um servidor independente, você deve redirecionar para [/public/index.php](public/index.php) para que o aplicativo funcione corretamente.

Se desejar, execute os testes para analisar se as rotas na aplicação estão em ordem:
```bash
php artisan test
```

Se você quiser usar um produto para testes, use o comando:
```bash
php artisan db:seed --class=ProductSeeder
```

Para configurar o cron e a fila no laravel, siga as instruções de configuração:
- [queue](https://laravel.com/docs/10.x/queues#running-the-queue-worker)
- [cron](https://laravel.com/docs/10.x/scheduling#running-the-scheduler)