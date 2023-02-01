-- генератор на 10000 записей
insert into movies(
    id, name, description, duration, is_deleted
)
select
    gs.id,
    random_string((2+random()*48)::integer),
    random_string((1+random()*254)::integer),
    (90+random()*90)::integer,
    (random() < 0.1)::bool
from
    generate_series(1, 100000) as gs(id);



-- 1440
insert into halls_places (hall_id, line, number)
select halls.id, gs1.line, gs2.number
from
    halls,
    generate_series(1, 15) as gs1(line),
    generate_series(1, 32) as gs2(number);


insert into movies_shows (movie_id, hall_id, price, start_date)
select
    m.id,
    (1+random()*2)::integer,
        10*(35+random()*10)::integer,
        (current_date - INTERVAL '30 day')
        + trunc(random()  * 80) * '1 day'::interval
        + trunc(random()  * 144) * '10 minute'::interval
from movies as m, (select generate_series(1, 10)) as g;


-- рандомно продаем билетики
WITH vars AS (
    SELECT
        (select count(*) from halls_places) as countPlaces,
        (select min(id) from halls_places) as minPlaces,
        (select count(*) from movies_shows) as countShows,
        (select min(id) from movies_shows) as minShows
)
insert into tickets (id, show_id, place_id, created_at)
select
    gs.id,
    (vars.minShows+random()*(vars.countShows-1))::integer as show_id,
    (vars.minPlaces+random()*(vars.countPlaces-1))::integer as place_id,
    (current_date - INTERVAL '30 day')
        + trunc(random()  * 30) * '1 day'::interval
        + trunc(random()  * 144) * '10 minute'::interval
from
    vars,
    generate_series(1, 10000000) as gs(id);
