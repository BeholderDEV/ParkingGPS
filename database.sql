CREATE EXTENSION postgis;

create table estacionamento(
  id serial primary key,
	nome varchar (255),
  preco numeric,
  area geometry
);

create table carro(
  id serial primary key,
	placa varchar (7)
);

create table ponto(
  id serial primary key,
	data_ponto timestamp,
  local_ponto geometry
);
