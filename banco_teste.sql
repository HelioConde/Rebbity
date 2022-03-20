create database banco_teste;


create table cliente_restaurante (
    cod_cliente int NOT NULL AUTO_INCREMENT,
    nome varchar (30) not null NOT NULL,
    tel int NOT NULL,
    email varchar (30)  NOT NULL,
    senha varchar (25)  NOT NULL,
	banco varchar(30) not null NOT NULL,
    agencia varchar (30) not null NOT NULL,
    Conta  int not null NOT NULL,
    Digito  int not null NOT NULL,
    cidade varchar (25) not null NOT NULL,
    cep int not null NOT NULL,
    estado varchar(35) NOT NULL NOT NULL,
    bairro varchar(35)not null NOT NULL,
    endereço varchar (45) not null NOT NULL,
    complemento varchar (35)  not null NOT NULL,
	cnpj int  null,
    nome_resp_loja varchar (45) not null NOT NULL,
    cpf int not null NOT NULL,
    rg int not null NOT NULL,
	PRIMARY KEY(cod_cliente)
    ) ENGINE=innoDB DEFAULT CHARSET=utf8;


    
 
create table cliente_mercado ( 
    cod_cliente int NOT NULL AUTO_INCREMENT,
    nome varchar (30) not null NOT NULL,
    tel int not null NOT NULL,
    email varchar (30) not null NOT NULL,
    senha varchar (25) not null NOT NULL,
	banco varchar(30) not null NOT NULL ,
    agencia varchar (30) not null NOT NULL,
    Conta  int not null NOT NULL,
    Digito  int not null NOT NULL,
    cidade varchar (25) NOT NULL,
    cep int not null NOT NULL,
    estado varchar(35) NOT NULL,
    bairro varchar(35)not null NOT NULL,
    endereço varchar (45) not null NOT NULL,
    complemento varchar (35)  not null NOT NULL,
    cnpj int  null,
    nome_resp_loja varchar (45) not null NOT NULL,
    cpf int not null NOT NULL,
    rg int not null NOT NULL, 
	PRIMARY KEY(cod_cliente)
) ENGINE=innoDB DEFAULT CHARSET=utf8;