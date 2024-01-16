use api_carros;

select * from marca;

select * from modelo;

select * from combustivel;

select * from transmissao;

select * from veiculo;

select veiculo.*, modelo.nome_modelo, modelo.id_marca,  marca.nome_marca, combustivel.nome_combustivel, transmissao.nome_transmissao from veiculo 
inner join modelo on veiculo.id_modelo = modelo.id
inner join marca on modelo.id_marca = marca.id
inner join combustivel on veiculo.id_combustivel = combustivel.id
inner join transmissao on veiculo.id_transmissao = transmissao.id where veiculo.id = 2;