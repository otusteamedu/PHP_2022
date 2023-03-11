# 10000 строк
insert into films (id, name)
values (
           generate_series(1, 10000),
           substr(gen_random_uuid()::text, 1, 1000)
       )

insert into halls(id, name, count_rows, count_places)
values (
        generate_series(1, 10000),
        substr(gen_random_uuid()::text, 1, 10000),
        random(),
        random()
    )

insert into seances (id, film_id, date, price)
select * from (select generate_series(1, 10000) as Id, (select Id from films order by RANDOM() limit 1) as film_id, cast('2014-01-20 20:00:00' as "date") as zv, random() as tmp) as test

insert into orders (id, seance_id, hall_id, row, seat, date, count)
select * from (select generate_series(1, 10000) as Id, (select Id from seances order by RANDOM() limit 1) as seance_id, (select Id from halls order by RANDOM() limit 1) as hall_id, random(), random(), cast('2014-01-20 20:00:00' as "date") as zv, random()) as test

# 1000000 строк
insert into films (id, name)
values (
    generate_series(1, 1000000),
    substr(gen_random_uuid()::text, 1, 1000000)
)

insert into halls(id, name, count_rows, count_places)
values (
    generate_series(1, 1000000),
    substr(gen_random_uuid()::text, 1, 1000000),
    random(),
    random()
)

insert into seances (id, film_id, date, price)
select * from (select generate_series(1, 1000000) as Id, (select Id from films order by RANDOM() limit 1) as film_id, cast('2014-01-20 20:00:00' as "date") as zv, random() as tmp) as test

insert into orders (id, seance_id, hall_id, row, seat, date, count)
select * from (select generate_series(1, 1000000) as Id, (select Id from seances order by RANDOM() limit 1) as seance_id, (select Id from halls order by RANDOM() limit 1) as hall_id, random(), random(), cast('2014-01-20 20:00:00' as "date") as zv, random()) as test