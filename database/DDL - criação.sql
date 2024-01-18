create database api_carros;
use api_carros;

create table usuario(
	id int auto_increment not null primary key,
    nome varchar(100) not null,
    email varchar(255) unique not null,
	acesso_admin bit not null,
    senha varchar(255) not null
);

create table marca(
	id int auto_increment not null primary key,
    nome_marca char(25) not null unique
);

create table modelo(
	id int auto_increment not null primary key,
    nome_modelo varchar(50) not null,
    
	id_marca int not null,
    constraint FKid_marca foreign key (id_marca) references marca (id),
    
    constraint UNmodelo_marca unique (nome_modelo, id_marca)
);

create table combustivel(
	id int auto_increment not null primary key,
    nome_combustivel char(20) not null unique
);

create table transmissao(
	id int auto_increment primary key not null,
    nome_transmissao char(22) not null unique
);

create table veiculo(
	id int auto_increment primary key not null,
    valor decimal(11,2) not null,
	versao varchar(50) not null,
    imagem_um varchar(255) not null,
	imagem_dois varchar(255),
	imagem_tres varchar(255),
	ano_producao int not null,
    ano_lancamento int not null,
    portas int not null,
    motor decimal(2,1) not null,
    carroceria char(20) not null,
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
    
    id_modelo int not null,
    constraint FKid_modelo foreign key (id_modelo) references modelo (id),
    
    id_combustivel int not null,
    constraint FKid_combustivel foreign key (id_combustivel) references combustivel (id),
    
    id_transmissao int not null,
    constraint FKid_transmissao foreign key (id_transmissao) references transmissao (id)
);