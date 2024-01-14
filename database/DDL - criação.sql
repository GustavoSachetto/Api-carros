create database api_carros;
use api_carros;

create table marca(
	id_marca int auto_increment not null primary key,
    nome_marca char(25) not null
);

create table modelo(
	id_modelo int auto_increment not null primary key,
    nome_modelo varchar(50) not null
);

create table combustivel(
	id_combustivel int auto_increment not null primary key,
    combustivel char(20) not null
);

create table transmissao(
	id_transmissao int auto_increment primary key not null,
    transmissao char(22) not null
);

create table veiculo(
	id_veiculo int auto_increment primary key not null,
    valor decimal(11.2) not null,
    piloto_automatico bit,
    climatizador bit,
    vidro_automatico bit,
    am_fm bit,
    entrada_auxiliar bit,
    bluetooth bit,
    cd_player bit,
    dvd_player bit,
    leitor_mp3 bit,
    entrada_usb bit,
    versao varchar(50) not null,
    imagem_um varchar(255) not null,
	imagem_dois varchar(255),
	imagem_tres varchar(255),
    ano_lancamento int not null,
    ano_producao int not null,
    porta int not null,
    motor decimal(2.1) not null,
    carrocerria char(20) not null,
    
	id_marca int not null,
    constraint FKid_marca foreign key (id_marca) references marca (id_marca),
    
    id_modelo int not null,
    constraint FKid_modelo foreign key (id_modelo) references modelo (id_modelo),
    
    id_combustivel int not null,
    constraint FKid_combustivel foreign key (id_combustivel) references combustivel (id_combustivel),
    
    id_transmissao int not null,
    constraint FKid_transmissao foreign key (id_transmissao) references transmissao (id_transmissao)
);