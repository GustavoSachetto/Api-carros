use api_carros;

insert into usuario (nome, email, senha, acesso_admin) values 
('Gustavo Sachetto da Cruz', 'admin@email.com', '$2y$10$mUsr/jxR6XXs8lgXeaukPu/zkkOTIsX2dUus43h9sDBCuDu/upY/e', true),
('Usuário padrão', 'default@email.com', '$2y$10$R4iNbyE5R7WY7rB592SpRe8fpdoCpqNbU1sAR16o9gaA6GmFfdUri', false);

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
("Bolt EUV", 3),
("Classe C", 14);


insert into veiculo (valor, versao, imagem_um, imagem_dois, imagem_tres, ano_producao, ano_lancamento, portas, motor, carroceria, 
piloto_automatico, climatizador, vidro_automatico, am_fm, entrada_auxiliar, bluetooth, cd_player, dvd_player, leitor_mp3, entrada_usb, 
id_modelo, id_combustivel, id_transmissao) values 
("66900.00", "1.4 MPFI LT V8", 
"https://image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17445058936.jpg?s=fill&w=1920&h=1440&q=75", 
"https://image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17445015235.jpg?s=fill&w=1920&h=1440&q=75",
"https://image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17450436217.jpg?s=fill&w=1920&h=1440&q=75",
2018, 2019, 4, "1.4", "Sedã", true, false, false, true, false, false, false, false, false, false, 1, 2, 1),
("78890.00", "1.6 Sport Turbo 4p",
"https://http2.mlstatic.com/D_NQ_NP_953549-MLB74022792667_012024-O.webp",
"https://http2.mlstatic.com/D_NQ_NP_655077-MLB73920317892_012024-O.webp",
"https://http2.mlstatic.com/D_NQ_NP_970213-MLB73920181326_012024-O.webp",
2014, 2014, 4, "1.6", "Sedã", true, true, true, true, true, true, true, true, true, true, 20, 1, 2),
("189900.99", "6.2 v8 Gasolina ss Automático",
"https://http2.mlstatic.com/D_NQ_NP_654304-MLA73599919881_122023-O.webp",
"https://http2.mlstatic.com/D_NQ_NP_798574-MLB73507390372_122023-O.webp",
null,
2012, 2012, 2, "6.2", "Coupé", true, true, true, true, true, true, true, true, true, true, 18, 2, 2),
("77900.80", "1.4 Ltz 5p",
"https://http2.mlstatic.com/D_NQ_NP_635613-MLB72695882250_112023-O.webp",
"https://http2.mlstatic.com/D_NQ_NP_775847-MLB72769680979_112023-O.webp",
null,
2019, 2019, 4, "1.4", "Hatch", false, true, true, false, true, true, true, true, true, false, 3, 2, 1),
("215990.66", "Ev 66 kw Elétrico",
"https://http2.mlstatic.com/D_NQ_NP_657050-MLB73629919458_122023-O.webp",
null,
null,
2023, 2024, 4, 0, "", true, true, true, true, true, true, true, true, true, true, 18, 6, 2);