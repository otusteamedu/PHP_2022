-- Otus homeWork #11 (cinema DB, extended version)
-- Fill DB by data
-- (SMALL amount of records ~1.000)

-- clear previous data
-- @hint use WHERE 1=1 to skip warn notifications
delete from "user" WHERE 1=1;
delete from "place" WHERE 1=1;
delete from "movie" WHERE 1=1;
delete from "hall" WHERE 1=1;
delete from "schedule" WHERE 1=1;
delete from "order" WHERE 1=1;

-- cinema halls
INSERT INTO public.hall (id, name) VALUES (1, 'Hall #1');
INSERT INTO public.hall (id, name) VALUES (2, 'Hall #2');
INSERT INTO public.hall (id, name) VALUES (3, 'Hall #3');

-- movies
insert into movie(id, name, duration)
select gs.id,
       random_string((5 + random() * 20)::integer),
       random_integer(60, 180) 
from generate_series(1, 1000) as gs(id);

-- places in halls
ALTER SEQUENCE place_id_seq RESTART WITH 1;
do
$$
    begin
        for i in 1..10
            loop
                for j in 1..20
                    loop
                        for k in 1..3
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
from generate_series(1, 1000) as gs(id);

-- movies schedule
INSERT INTO public.schedule 
(id, hall_id, movie_id, start_time, price)
select gs.id,
       random_integer(1, 3),
       random_integer(1, 1000),
       random_timestamp(),
       random_integer(100, 500)
from generate_series(1, 100) as gs(id);

-- users orders 
INSERT INTO public."order" 
(id, user_id, schedule_id, paytime, place_id) 
select gs.id,
       random_integer(1, 1000),
       random_integer(1, 100),
       random_timestamp(),
       random_integer(1, 600) 
from generate_series(1, 200) as gs(id);