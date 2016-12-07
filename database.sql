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


insert into estacionamento (nome,preco, area) values ('LinkinPark', 2.50, st_geomfromtext('POLYGON((-48.0 -26.0, -48.0 -25.9, -47.9 -25.9, -48.0 -26.0))', 4326));
insert into estacionamento (nome,preco, area) values ('Koch', 2.50, st_geomfromtext('POLYGON((-48.6 -26.9, -48.6 -26.9, -48.6 -26.9, -48.6 -26.9, -48.6 -26.9))', 4326));
