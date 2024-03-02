# Api-carros
Maravilhado com a ideia de consumir APIs busquei criar a minha própria, trazendo como tema __veículos__! Utilizei nela uma arquitetura padrão __MVC__ usando como base a linguagem __PHP.__

#php #poo #api

## Desenvolvendo
Para construir uma __API-REST-FULL__ tive que estudar muitos conceitos que me trouxeram grandes experiências! Trabalhei com: 

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

## Documentação
* __URL da API:__ indisponivel temporariamente
* __Teste rotas no postman:__ https://www.postman.com/api-carros-gs/workspace/api-carros-developer-workspace
* __Site (colaboração [@Gustavo Gualda](https://github.com/iCrowleySHR)):__ https://consumo-api-carros.vercel.app/

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
| :----------        | -------------- | ------------------ | :-------------------------------------------------------------------------- |
| GET /              | __READ__       | __No Auth__        | Obtenha os detalhes sobre o criador                                         |
| GET /cars          | __READ__       | __No Auth__        | Obtenha as ultimas cinco postagens da `vehicle` tabela                      |
| GET /cars?page=2   | __READ__       | __No Auth__        | Obtenha até cinco postagens por páginação da `vehicle` tabela               |
| GET /cars/{id}     | __READ__       | __No Auth__        | Obtenha um veículo atráves da consulta por id da `vehicle` tabela           |
| POST /cars         | __CREATE__     | __Beader Token__   | Crie uma nova postagem da `vehicle` tabela                                  |

__Rotas dos usuários:__

| API                    | CRUD           | AUTH               | DESCRIÇÃO                                                                   |
| :----------            | -------------- | ------------------ | :-------------------------------------------------------------------------- |
| GET /users          	 | __READ__       | __Basic Auth__     | Obtenha todas postagens da `user` tabela                     	     |
| GET /users/{id}     	 | __READ__       | __Basic Auth__     | Obtenha uma postagem da `user` tabela          			     |
| POST /users            | __CREATE__     | __Basic Auth__     | Crie uma nova postagem da `user` tabela                                  |
| PUT /users/{id}        | __UPDATE__     | __Basic Auth__     | Atualize uma postagem da `user` tabela                                   |
| DELETE /users/{id}     | __DELETE__     | __Basic Auth__     | Delete uma postagem da `user` tabela                                     |

__Rotas dos modelos do veículo:__

| API                              | CRUD           | AUTH               | DESCRIÇÃO                                                                      |
| :----------         		   | -------------- | ------------------ | :--------------------------------------------------------------------------    |
| GET /carmodels          	   | __READ__       | __No Auth__        | Obtenha todas postagens da `model` tabela                     	          |
| GET /carmodels/bycarmodels/{id}  | __READ__       | __No Auth__        | Obtenha uma postagem atráves da consulta por id da `model` tabela             |
| GET /carmodels/bybrand/{id}      | __READ__       | __No Auth__        | Obtenha todas postagens atráves da consulta por id_marca na `model` tabela    |
| POST /carmodels                  | __CREATE__     | __Beader Token__   | Crie uma nova postagem da `model` tabela                                      |
| PUT /carmodels/{id}              | __UPDATE__     | __Beader Token__   | Atualize uma postagem da `model` tabela                                       | 

__Para acessar todas as rotas da api:__ https://www.postman.com/api-carros-gs/workspace/api-carros-developer-workspace

## Exemplo de retorno
Este é um retorno padrão da "Api-carros". Todos os veículos consultados deveram ter esse formato base.
* __Tipo de arquivo:__ JSON

```
{
	"id": 1,
	"valor": "66900.00",
	"id_marca": 3,
	"marca": "Chevrolet",
	"id_modelo": 1,
	"modelo": "Prisma",
	"versao": "1.4 MPFI LT V8",
	"imagens": [
		"https://image.webmotors.com.br/_fotos/anunciousados/gigante/",
		"https://image.webmotors.com.br/_fotos/anunciousados/gigante/",
		"https://image.webmotors.com.br/_fotos/anunciousados/gigante/"
	],
	"ano": {
		"producao": "2018",
		"lancamento": "2019"
	},
	"combustivel": "Gasolina e Álcool",
	"portas": 4,
	"transmissao": "Manual",
	"motor": "1.4",
	"carroceria": "Sedã",
	"conforto": {
		"piloto_automatico": true,
		"climatizador": false,
		"vidro_automatico": false
	},
	"entretenimento": {
		"am_fm": true,
		"entrada_auxiliar": false,
		"bluetooth": false,
		"cd_player": false,
		"dvd_player": false,
		"leitor_mp3": false,
		"entrada_usb": false
	}
}
```

********************************
