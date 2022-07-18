INSERT INTO hall (id, name)
VALUES (1, 'Красный');
INSERT INTO hall (id, name)
VALUES (2, 'Зеленый');
INSERT INTO hall (id, name)
VALUES (3, 'Синий');

INSERT INTO place (id, row, place, hall_id)
VALUES (1, 1, 1, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (2, 2, 1, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (3, 3, 1, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (4, 4, 1, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (5, 5, 1, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (6, 1, 2, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (7, 2, 2, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (8, 3, 2, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (9, 4, 2, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (10, 5, 2, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (11, 1, 3, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (12, 2, 3, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (13, 3, 3, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (14, 4, 3, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (15, 5, 3, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (16, 1, 4, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (17, 2, 4, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (18, 3, 4, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (19, 4, 4, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (20, 5, 4, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (21, 1, 5, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (22, 2, 5, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (23, 3, 5, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (24, 4, 5, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (25, 5, 5, 1);
INSERT INTO place (id, row, place, hall_id)
VALUES (26, 1, 1, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (27, 2, 1, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (28, 3, 1, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (29, 1, 2, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (30, 2, 2, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (31, 3, 2, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (32, 1, 3, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (33, 2, 3, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (34, 3, 3, 2);
INSERT INTO place (id, row, place, hall_id)
VALUES (35, 1, 1, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (36, 1, 2, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (37, 1, 3, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (38, 1, 4, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (39, 2, 1, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (40, 2, 2, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (41, 2, 3, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (42, 2, 4, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (43, 3, 1, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (44, 3, 2, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (45, 3, 3, 3);
INSERT INTO place (id, row, place, hall_id)
VALUES (46, 3, 4, 3);

create or replace function random_string(length integer) returns text as
$$
declare
    chars  text[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    i      integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql;

create or replace function random_int(low integer, high integer) returns integer as
$$
begin
    return floor(random() * (high - low + 1) + low);
end;
$$ language plpgsql;

create or replace function random_price(low integer, high integer) returns integer as
$$
BEGIN
    return round((random() * (high - low + 1) + low)::numeric, 2);
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_datetime(start_date timestamp, end_date timestamp) RETURNS TIMESTAMP AS
$$
BEGIN
    return (select start_date::timestamp) + random() * (end_date::timestamp - start_date::timestamp);
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_time() RETURNS TIME AS
$$
DECLARE
    random_time time;
BEGIN
    random_time := date_trunc('second', (select timestamp '2022-01-01 03:40:00' +
                                                random() *
                                                (timestamp '2022-01-01 01:20:00' - timestamp '2022-01-01 03:40:00'))::time)::time;
    RETURN random_time;
END ;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_price_multiplier() RETURNS FLOAT AS
$$
BEGIN
    return round((random() * 1 + 1)::numeric, 2);
END;
$$ LANGUAGE plpgsql;

INSERT INTO film (id, name, duration, base_price)
select gs.id,
       random_string(15),
       random_time(),
       random_int(150, 500)
from generate_series(1, 1000) as gs(id);

INSERT INTO session (id, film_id, time, price_multiplier)
select gs.id,
       random_int(1, 1000),
       random_datetime('2022-01-01 09:00:00', '2022-07-01 18:00:00'),
       random_price_multiplier()
from generate_series(1, 1000000) as gs (id);

INSERT INTO customer(id, phone)
select gs.id,
       random_int(1000000, 9999999)
from generate_series(1, 150000) as gs(id);

INSERT INTO hall_session (session_id, hall_id)
select random_int(1, 1000000),
       random_int(1, 3)
from generate_series(1, 1000000) as gs(id);

INSERT INTO ticket(id, session_id, customer_id, place_id, full_price)
select gs.id,
       random_int(1, 1000000),
       random_int(1, 150000),
       random_int(1, 46),
       random_price(150, 1000)
from generate_series(1, 10000000) as gs(id)
ON CONFLICT DO NOTHING;
