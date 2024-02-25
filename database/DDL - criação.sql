create database cars_api;
use cars_api;

create table user(
	id int unsigned auto_increment primary key,
    name varchar(100) not null,
    email varchar(255) unique not null,
	admin_access boolean not null,
    password_hash varchar(255) not null
);

create table brand(
	id int unsigned auto_increment primary key,
    name char(25) unique not null
);

create table model(
	id int unsigned auto_increment primary key,
    name varchar(50) not null,
    
	brand_id int unsigned not null,
    constraint FK_brand_model foreign key (brand_id) references brand(id),
    
    constraint UQ_model unique (name, brand_id)
);

create table fuel(
	id int unsigned auto_increment primary key,
    name char(20) unique not null
);

create table transmission(
	id int unsigned auto_increment primary key,
    name char(22) unique not null
);

create table vehicle(
	id int unsigned auto_increment primary key,
    price decimal(11,2) not null,
	version varchar(50) not null,
    primary_image varchar(255) not null,
	secondary_image varchar(255),
	tertiary_image varchar(255),
	production_year year not null,
    release_year year not null,
    doors int not null,
    motor decimal(2,1) not null,
    bodywork char(20) not null,
	automatic_pilot boolean,
    air_conditioner boolean,
    automatic_glass boolean,
    am_fm boolean,
    auxiliary_input boolean,
    bluetooth boolean,
    cd_player boolean,
    dvd_player boolean,
    mp3_reader boolean,
    usb_port boolean,
    
    model_id int unsigned not null,
    constraint FK_model_vehicle foreign key (model_id) references model(id),
    
    fuel_id int unsigned not null,
    constraint FK_fuel_vehicle foreign key (fuel_id) references fuel(id),
    
    transmission_id int unsigned not null,
    constraint FK_transmission_vehicle foreign key (transmission_id) references transmission(id),
    
    constraint UQ_vehicle unique (version, model_id, fuel_id, transmission_id)
);
