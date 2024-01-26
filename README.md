# Api-carros
Acostumado com a ideia de consumir APIs busquei criar a minha própria, trazendo como tema __veículos__! Utilizei nela uma arquitetura padrão __MVC__ usando como base a linguagem __PHP.__

#php #poo #api

## Desenvolvendo
Para construir uma __API-REST-FULL__ tive que estudar muitos conceitos que me trouxeram grandes experiências! Trabalhei com: 

* Request (enviar e receber dados).
* Rotas (configuração, permissão e stauts).
* Reponse (headers, status e contentType da página).
* Ferramenta de teste (Postman).
* Formatação de arquivos JSON (conversão e inversão de formato).
* Entre outros...

## Documentação
* __URL da API:__ https://gustavosachettoapi.000webhostapp.com/api/v1/cars
* __Teste rotas no postman:__ https://www.postman.com/api-carros-gs/workspace/api-carros-developer-workspace

## Banco de dados
O banco de dados dessa api conta com 6 tabelas, elas são: 
* `usuário` Armazena todos os usuários de acesso privilegiado da api.
* `marca` Armazena todas as marcas de veículos presente na api.
* `modelo` Armazena todos os modelos de veículos da api, trazendo dados da tabela: `marca`.
* `combustivel` Armazena todos os combustíveis presente na api.
* `transmissao` Armazena todas as transmissões presente na api.
* `veiculo` Armazena todos os veículos da api, trazendo dados das tabelas: `modelo`, `combustivel` e `transmissao`.

Todas as tabelas e alterações no banco estão acima no projeto, na pasta "database".

## Principais Rotas:
__Rotas do veículo (carro):__

| API                | CRUD           | AUTH               | DESCRIÇÃO                                                                   |
| :----------        | -------------- | ------------------ | :-------------------------------------------------------------------------- |
| GET /              | __READ__       | __No Auth__        | Obtenha os detalhes sobre o criador                                         |
| GET /cars          | __READ__       | __No Auth__        | Obtenha as ultimas cinco postagens da `veiculo` tabela                      |
| GET /cars?page=2   | __READ__       | __No Auth__        | Obtenha até cinco postagens por páginação da `veiculo` tabela               |
| GET /cars/{id}     | __READ__       | __No Auth__        | Obtenha um veículo atráves da consulta por id da `veiculo` tabela           |
| POST /cars         | __CREATE__     | __Basic Auth__     | Crie uma nova postagem da `veiculo` tabela                                  |

__Rotas dos usuários:__

| API                    | CRUD           | AUTH               | DESCRIÇÃO                                                                   |
| :----------            | -------------- | ------------------ | :-------------------------------------------------------------------------- |
| GET /users          	 | __READ__       | __Basic Auth__     | Obtenha todas postagens da `usuario` tabela                     	     |
| GET /users/{id}     	 | __READ__       | __Basic Auth__     | Obtenha uma postagem da `usuario` tabela          			     |
| POST /users            | __CREATE__     | __Basic Auth__     | Crie uma nova postagem da `usuario` tabela                                  |
| PUT /users/{id}        | __UPDATE__     | __Basic Auth__     | Atualize uma postagem da `usuario` tabela                                   |
| DELETE /users/{id}     | __DELETE__     | __Basic Auth__     | Delete uma postagem da `usuario` tabela                                     |

__Rotas dos modelos do veículo:__

| API                              | CRUD           | AUTH               | DESCRIÇÃO                                                                      |
| :----------         		   | -------------- | ------------------ | :--------------------------------------------------------------------------    |
| GET /carmodels          	   | __READ__       | __No Auth__        | Obtenha todas postagens da `modelo` tabela                     	          |
| GET /carmodels/bycarmodels/{id}  | __READ__       | __No Auth__        | Obtenha uma postagem atráves da consulta por id da `modelo` tabela             |
| GET /carmodels/bybrand/{id}      | __READ__       | __No Auth__        | Obtenha todas postagens atráves da consulta por id_marca na `modelo` tabela    |
| POST /carmodels                  | __CREATE__     | __Basic Auth__     | Crie uma nova postagem da `modelo` tabela                                      |
| PUT /carmodels/{id}              | __UPDATE__     | __Basic Auth__     | Atualize uma postagem da `modelo` tabela                                       | 

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
		"producao": 2018,
		"lancamento": 2019
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
