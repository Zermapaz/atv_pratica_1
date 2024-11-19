create database pratica_1;
use pratica_1;

CREATE TABLE cliente(
cliente_pk  int primary key not null auto_increment,
nome_cliente varchar(50),
email_cliente varchar(50),
telefone_cliente varchar(11)
);

CREATE TABLE colaborador(
colaborador_pk int primary key not null auto_increment,
nome_colaborador varchar(50),
email_colaborador varchar(50),
telefone_colaborador varchar(11)
);

CREATE TABLE chamado(
chamado_pk int primary key not null auto_increment,
titulo_chamado varchar(50),
cliente_pk int not null,
FOREIGN KEY (cliente_pk) REFERENCES cliente(cliente_pk),
colaborador_pk int not null,
FOREIGN KEY (colaborador_pk) REFERENCES colaborador(colaborador_pk),
descricao varchar(500),
criticidade varchar(15),
estatus varchar(20),
data_abertura date
);


