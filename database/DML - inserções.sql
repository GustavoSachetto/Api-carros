use api_carros;

insert into combustivel (nome_combustivel) values
('Gasolina'),
('Gasolina e Álcool'),
('Álcool'),
('Diesel'),
('Gás Natural'),
('Elétrico'),
('Hidrogênio');

insert into transmissao (nome_transmissao) values
('Manual'), 
('Automática'),
('Automatizada'),
('Continuamente variável');

insert into marca (nome_marca) values 
('Audi'),
('Bmw'),
('Chevrolet'),
('Citroen'),
('Fiat'),
('Ford'),
('Gurgel'),
('Honda'),
('Hyundai'),
('JAC'),
('Jeep'),
('KIA'),
('Land Rover'),
('Mercedes-Benz'),
('Mitsubishi'),
('Nissan'),
('Peugeot'),
('Puma'),
('Renault'),
('Subaru'),
('Suzuki'),
('Toyota'),
('Volvo'),
('Volkswagen');

insert into modelo (nome_modelo, id_marca) values 
("Prisma", 3),
("Onix", 3),
("Onix Plus", 3),
("Cruze", 3),
("Cruze Sport6 RS", 3),
("Spin", 3),
("Spin Activ", 3),
("Tracker", 3),
("Equinox", 3),
("Trailblazer", 3),
("Silverado", 3),
("Montana", 3),
("S10 High Country", 3),
("S10 Cabine Dupla", 3),
("S10 Cabine Simples", 3),
("S10 Midnight", 3),
("S10 Z71", 3),
("Camaro", 3),
("Bolt EV", 3),
("Bolt EUV", 3);

insert into veiculo (valor, versao, imagem_um, imagem_dois, imagem_tres, ano_producao, ano_lancamento, portas, motor, carroceria, 
piloto_automatico, climatizador, vidro_automatico, am_fm, entrada_auxiliar, bluetooth, cd_player, dvd_player, leitor_mp3, entrada_usb, 
id_modelo, id_combustivel, id_transmissao) values 
("66900.00", "1.4 MPFI LT V8", 
"https://image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17445058936.jpg?s=fill&w=1920&h=1440&q=75", 
"https://image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17445015235.jpg?s=fill&w=1920&h=1440&q=75",
"https://image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17450436217.jpg?s=fill&w=1920&h=1440&q=75",
2018, 2019, 4, "1.4", "Sedã", true, false, false, true, false, false, false, false, false, false, 1, 2, 1);