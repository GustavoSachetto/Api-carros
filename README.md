# Api-carros
Maravilhado com a ideia de consumir APIs busquei criar a minha própria, trazendo como tema __veículos__! Utilizei nela uma arquitetura __MVC__ usando como base a linguagem __PHP.__

#php #poo #api

* __Link de acesso:__ https://www.postman.com/api-carros-gs/workspace/api-carros-developer-workspace

## Desenvolvendo
Para construir uma __API-REST-FULL__ tive que estudar muitos conceitos que me trouxeram grandes experiências! Trabalhei com: 

* Programação Orientada a Objeto
* Arquitetura Rest.
* Configuração de rotas.
* Requisição do cliente.
* Resposta do servidor.
* Codigo status HTTP.
* Basic Authentication.
* Token Authentication.
* Implementação de cache.
* Banco de dados.
* Postman (Ferramenta de teste).
* Formatação de arquivos JSON.

## Comandos iniciais
Principais comandos para iniciar o projeto:
```
composer install
php cli --db set # Carrega as tabelas
php cli --db load # Carraga as informações para as tabelas
```

## Documentação
* __Framework:__ https://github.com/GustavoSachetto/Php-puro/tree/v1
* __Postman:__ https://documenter.getpostman.com/view/31981241/2sA3kaCK5V

## Banco de dados
O banco de dados dessa api conta com 6 tabelas, elas são: 
* `user` Armazena todos os usuários de acesso privilegiado da api.
* `brand` Armazena todas as marcas de veículos presente na api.
* `model` Armazena todos os modelos de veículos da api, trazendo dados da tabela: `brand`.
* `fuel` Armazena todos os combustíveis presente na api.
* `transmission` Armazena todas as transmissões presente na api.
* `vehicle` Armazena todos os veículos da api, trazendo dados das tabelas: `model`, `fuel` e `transmission`.

Todas as tabelas e alterações no banco estão acima no projeto, na pasta "database".

## Principais Rotas:
__Rotas do veículo (carro):__

| API                | CRUD           | AUTH               | DESCRIÇÃO                                                                   |
| :----------------- | -------------- | ------------------ | :-------------------------------------------------------------------------- |
| GET /              | __READ__       | __No Auth__        | Obtenha as informações sobre a api                                          |
| GET /cars          | __READ__       | __No Auth__        | Obtenha as ultimas cinco postagens da `vehicle` tabela                      |
| GET /cars?page=2   | __READ__       | __No Auth__        | Obtenha até 25 postagens por página da `vehicle` tabela                     |
| GET /cars/{id}     | __READ__       | __No Auth__        | Obtenha uma postagem pela busca por id da `vehicle` tabela                  |
| POST /cars         | __CREATE__     | __JWT Auth__       | Crie uma nova postagem da `vehicle` tabela                                  |
| PUT /cars          | __UPDATE__     | __JWT Auth__       | Atualize uma postagem da `vehicle` tabela                                   |
| DELETE /cars       | __DELETE__     | __JWT Auth__       | Delete uma postagem da `vehicle` tabela                                     |


__Rotas dos usuários:__

| API                    | CRUD           | AUTH               | DESCRIÇÃO                                                             |
| :--------------------- | -------------- | ------------------ | :-------------------------------------------------------------------- |
| GET /users          	 | __READ__       | __Basic Auth__     | Obtenha todas postagens da `user` tabela                     	       |
| GET /users/{id}     	 | __READ__       | __Basic Auth__     | Obtenha uma postagem da `user` tabela          			           |
| POST /users            | __CREATE__     | __Basic Auth__     | Crie uma nova postagem da `user` tabela                               |
| PUT /users/{id}        | __UPDATE__     | __Basic Auth__     | Atualize uma postagem da `user` tabela                                |
| DELETE /users/{id}     | __DELETE__     | __Basic Auth__     | Delete uma postagem da `user` tabela                                  |

__Rotas das marcas do veículo:__

| API                           | CRUD           | AUTH               | DESCRIÇÃO                                                                      |
| :---------------------------- | -------------- | ------------------ | :----------------------------------------------------------------------------- |
| GET /brands          	        | __READ__       | __No Auth__        | Obtenha todas postagens da `brand` tabela                     	               |
| GET /brands/{id}              | __READ__       | __No Auth__        | Obtenha todas postagens pela busca por id na `brand` tabela                    |
| POST /brands                  | __CREATE__     | __JWT Auth__       | Crie uma nova postagem da `brand` tabela                                       |
| PUT /brands/{id}              | __UPDATE__     | __JWT Auth__       | Atualize uma postagem da `brand` tabela                                        | 
| DELETE /brands/{id}           | __DELETE__     | __JWT Auth__       | Delete uma postagem da `brand` tabela                                          | 

__Para acessar todas as rotas da api:__ https://www.postman.com/api-carros-gs/workspace/api-carros-developer-workspace

## Exemplo de retorno
Este é um retorno padrão da "Api-carros". Todos os veículos consultados deveram ter esse formato base.
* __Tipo de arquivo:__ JSON

```
{
    "id": 4,
    "price": 77900,
    "brand_id": 3,
    "brand_name": "Chevrolet",
    "model_id": 3,
    "model_name": "Onix Plus",
    "version": "1.4 Ltz 5p",
    "images": [
        "https://http2.mlstatic.com/D_NQ_NP_635613-MLB72695882250_112023-O.webp",
        "https://http2.mlstatic.com/D_NQ_NP_775847-MLB72769680979_112023-O.webp",
        null
    ],
    "year": {
        "production": 2019,
        "release": 2019
    },
    "fuel_name": "Gasolina e Álcool",
    "doors": 4,
    "transmission_name": "Manual",
    "motor": 1.4,
    "bodywork": "Hatch",
    "comfort": {
        "automatic_pilot": false,
        "air_conditioner": true,
        "automatic_glass": true
    },
    "entertainment": {
        "am_fm": false,
        "auxiliary_input": true,
        "bluetooth": true,
        "cd_player": true,
        "dvd_player": true,
        "mp3_reader": true,
        "usb_port": false
    },
    "deleted": false
}
```

********************************
