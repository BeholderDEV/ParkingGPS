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
  local_ponto geometry,
    id_carro integer
);


insert into estacionamento (nome,preco, area) values ('LinkinPark', 2.50, st_geomfromtext('POLYGON((-48.0 -26.0, -48.0 -25.9, -47.9 -25.9, -48.0 -26.0))', 4326));
insert into estacionamento (nome,preco, area) values ('Koch', 2.50, st_geomfromtext('POLYGON((-48.6 -26.9, -48.6 -26.9, -48.6 -26.9, -48.6 -26.9, -48.6 -26.9))', 4326));


------

create or replace function get_entradas_estacionamento(int) returns setof record as
$$
	declare
		carro_a record;
		pontos record;
		estacionamentos record;
		tadentro boolean := false;
		estacionamento_atual record;
		ponto_inicial record;
		ponto_final record;
		saida record;

	begin
		for pontos in select * from ponto p where p.id_carro = $1 loop
			for estacionamentos in select * from estacionamento e loop
				raise notice 'aqui antes do if % , %' ,estacionamentos.area,pontos.local_ponto;
				if ST_Contains(estacionamentos.area,pontos.local_ponto) then
					if tadentro then
						raise notice 'aqui no if';
					else
						tadentro := true;
						estacionamento_atual := estacionamentos;
						ponto_inicial := pontos;
						raise notice 'aqui dentro';
					end if;
				else
					raise notice 'aqui não tem nada';
					if tadentro then
						if estacionamentos.id = estacionamento_atual.id then
							ponto_final := pontos;
							saida.id_estacionamento := estacionamento_atual.id;
							saida.id_ponto_inicial := ponto_inicial.id;
							saida.id_ponto_final := ponto_final.id;
							raise notice 'aqui';
							return next saida;
						end if;
					end if;
				end if;
			end loop;
		end loop;
		return;

	end;
$$
language plpgsql;

select get_entradas_estacionamento(1);
