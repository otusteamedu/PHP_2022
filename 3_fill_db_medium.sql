-- Otus homeWork #11 (cinema DB, extended version)
-- Fill DB by data
-- (MEDIUM amount of records ~10.000)

-- clear previous data
-- @hint use WHERE 1=1 to skip warn notifications
delete from "user" WHERE 1=1;
delete from "place" WHERE 1=1;
delete from "movie" WHERE 1=1;
delete from "hall" WHERE 1=1;
delete from "schedule" WHERE 1=1;
delete from "order" WHERE 1=1;

-- cinema halls
insert into hall(id, name)
select gs.id,
       random_string((5 + random() * 20)::integer)
from generate_series(1, 100) as gs(id);

-- movies
insert into movie(id, name, duration)
select gs.id,
       random_string((5 + random() * 20)::integer),
       random_integer(60, 180)
from generate_series(1, 10000) as gs(id);

-- places in halls
ALTER SEQUENCE place_id_seq RESTART WITH 1;

-- we have total places: 20 * 30 * 10 = 60000
do
$$
begin
for i in 1..20
            loop
                for j in 1..30
                    loop
                        for k in 1..100
                            loop
                                INSERT INTO place (row, number, hall_id)
                                VALUES (i, j, k);
end loop;
end loop;
end loop;
end;
$$;

-- users
INSERT INTO public.user
(id, login, password, name)
select gs.id,
       random_string((5 + random() * 20)::integer),
       random_string((6 + random() * 10)::integer),
       random_string((7 + random() * 20)::integer)
from generate_series(1, 10000) as gs(id);

-- movies schedule
INSERT INTO public.schedule
(id, hall_id, movie_id, start_time, price)
select gs.id,
       random_integer(1, 10),
       random_integer(1, 10000),
       random_timestamp(),
       random_integer(100, 1000)
from generate_series(1, 10000) as gs(id);

-- users orders
INSERT INTO public."order"
(id, user_id, schedule_id, paytime, place_id)
select gs.id,
       random_integer(1, 10000),
       random_integer(1, 10000),
       random_timestamp(),
       random_integer(1, 60000)
from generate_series(1, 10000) as gs(id);