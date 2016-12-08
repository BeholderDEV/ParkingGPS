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

insert into estacionamento (nome,preco, area) values ('Univali', 2.50, st_geomfromtext('POLYGON((-48.66563558578491 -26.917658074414668,-48.65718126296997 -26.91758154276435,-48.65722417831421 -26.91226246592006,-48.661558628082275 -26.911611914138287,-48.667030334472656 -26.913793161204776,-48.66563558578491 -26.917658074414668))', 4326));
insert into estacionamento (nome,preco, area) values ('Rio Grande', 2.50, st_geomfromtext('POLYGON((-57.76611328125 -29.96266823880552,-52.36083984375 -33.38386623304053,-49.28466796875 -28.65986367406166,-54.0966796875 -26.85164162108546,-57.76611328125 -29.96266823880552))', 4326));
insert into estacionamento (nome,preco, area) values ('Curitiba', 2.50, st_geomfromtext('POLYGON((-49.4989013671875 -25.48147903668929,-49.08966064453125 -25.674716920934443,-48.88092041015625 -25.354962879196894,-49.36431884765625 -25.220860161683355,-49.4989013671875 -25.48147903668929))', 4326));


------

create or replace function get_entradas_estacionamento(int) returns setof record as
$$
	declare
		carro_a record;
		pontos record;
		estacionamentos record;
		tavadentro boolean := false;
		estacionamento_atual record;
		ponto_inicial record;
		ponto_final record;
		saida record;

	begin
		for pontos in select * from ponto p where p.id_carro = $1 loop
			for estacionamentos in select * from estacionamento e loop
				raise notice 'aqui antes do if % , %' ,st_astext(estacionamentos.area),st_astext(pontos.local_ponto);
				if ST_Contains(estacionamentos.area,pontos.local_ponto) then
					if tavadentro then
						raise notice 'aqui no if';
					else
						tavadentro := true;
						estacionamento_atual := estacionamentos;
						ponto_inicial := pontos;
						raise notice 'aqui dentro';
					end if;
				else
					raise notice 'aqui não tem nada';
					if tavadentro then
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
