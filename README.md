# Api-carros
Acostumado com a ideia de consumir APIs busquei criar a minha própria, trazendo como tema __veículos__! Utilizei nela uma arquitetura padrão, usando como base a linguagem __PHP.__

#php #poo #api

## Desenvolvendo
Para construir uma __API-REST-FULL__ tive que estudar muitos conceitos que me trouxeram grandes experiências! Trabalhei com: 

* Request (solicitação, permissão e status das rotas).
* Reponse (headers, status e contentType da página).
* Ferramenta de teste (Postman).
* Formatação de arquivos JSON (conversão e inversão de formato).
* Entre outros...

## Documentação
* __URL consumo:__ http://localhost/Api-carros/api/v1/
* __Site da documentação:__ https://www.linkedin.com/in/gustavo-sachetto/

__Rotas do veículo (carro):__

| API                | CRUD           | DESCRIÇÃO                                                                   |
| :----------        | -------------- | :-------------------------------------------------------------------------- |
| GET /              | __READ__       | Obtenha os detalhes sobre o criador                                         |
| GET /cars          | __READ__       | Obtenha as ultimas cinco postagens da `veiculo` tabela                      |
| GET /cars?page=2   | __READ__       | Obtenha até cinco postagens por páginação da `veiculo` tabela               |
| GET /cars/{id}     | __READ__       | Obtenha um veículo atráves da consulta por id da `veiculo` tabela           |
| POST /cars         | __CREATE__     | Crie uma nova postagem da `veiculo` tabela                                  |

## Banco de dados
Todas as tabelas e alterações no banco estão na pasta database.

## Exemplo
Este é um retorno padrão da `Api-carros`! Todos os veículos consultados deveram ter esse formato base.
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
