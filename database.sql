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

select * from get_movimentacao(placa);
select * from get_conveniados_sorted(longitude, latitude);

------

create or replace function get_entradas_estacionamento(int) returns table(id_estacionamento integer, id_ponto_inicial integer, id_ponto_final integer) as
$$
	declare
		carro_a record;
		pontos record;
		estacionamentos record;
		tavadentro boolean := false;
		estacionamento_atual record;
		ponto_inicial record;
		ponto_final record;

	begin
		for pontos in select * from ponto p where p.id_carro = $1 loop
			for estacionamentos in select * from estacionamento e loop
				if ST_Contains(estacionamentos.area,pontos.local_ponto) then
					if tavadentro then
					else
						tavadentro := true;
						estacionamento_atual := estacionamentos;
						ponto_inicial := pontos;
					end if;
				else
					if tavadentro then
						if estacionamentos.id = estacionamento_atual.id then
							ponto_final := pontos;
							id_estacionamento := estacionamento_atual.id;
							id_ponto_inicial := ponto_inicial.id;
							id_ponto_final := ponto_final.id;
							return next ;
						end if;
					end if;
				end if;
			end loop;
		end loop;
	end;
$$
language plpgsql;

select * from get_entradas_estacionamento(1);

------

create or replace function get_movimentacao(int) returns table(estacionamento_nome varchar(255), dataEntrada timestamp, dataSaida timestamp, permanencia numeric, valor numeric) as
$$
	declare
		nome_estacionamento record;
		entrada record;
		saida record;
		preco_rec record;
		estacionamentos record;
		tempo_no_estacionamento interval;

	begin
		for estacionamentos in select * from get_entradas_estacionamento($1) loop

			select nome into nome_estacionamento from estacionamento e where e.id=estacionamentos.id_estacionamento;
			select data_ponto into entrada from ponto p where p.id=estacionamentos.id_ponto_inicial;
			select data_ponto into saida from ponto p where p.id=estacionamentos.id_ponto_final;

			estacionamento_nome := nome_estacionamento.nome;
			dataEntrada := entrada.data_ponto;
			dataSaida := saida.data_ponto;
			tempo_no_estacionamento := saida.data_ponto - entrada.data_ponto;
			permanencia := EXTRACT(EPOCH FROM tempo_no_estacionamento::INTERVAL)/60;
			select preco into preco_rec from estacionamento where id=estacionamentos.id_estacionamento;
			valor := (preco_rec.preco)*permanencia;
			return next;
		end loop;
	end;
$$
language plpgsql;

select * from get_movimentacao(1);

------

create or replace function get_conveniados(numeric, numeric) returns table(estacionamento_nome varchar(255), valor numeric, distancia numeric) as
$$
	declare
		nome_estacionamento record;
		entrada record;
		saida record;
		preco_rec record;
		estacionamentos record;
		tempo_no_estacionamento interval;

	begin
		for estacionamentos in select * from estacionamento loop

			estacionamento_nome  := estacionamentos.nome;
			valor := estacionamentos.preco;
			distancia = ST_Distance( ST_GeomFromText('POINT(' || $1 || ' ' || $2 || ')',4326)::geography ,estacionamentos.area);
			return next;
		end loop;
	end;
$$
language plpgsql;


-----

create or replace function get_conveniados_sorted(numeric, numeric) returns table(estacionamento_nome varchar(255), valor numeric, distancia numeric) as
$$
	declare
		nome_estacionamento record;
		entrada record;
		saida record;
		preco_rec record;
		estacionamentos record;
		tempo_no_estacionamento interval;

	begin
		for estacionamentos in select * from get_conveniados($1, $2) order by distancia loop

			estacionamento_nome  := estacionamentos.estacionamento_nome;
			valor := estacionamentos.valor;
			distancia = estacionamentos.distancia;
			return next;
		end loop;
	end;
$$
language plpgsql;


select * from get_conveniados_sorted(-50.9765625, -27.710886603438052);