/* Залы */
insert into halls(name)
values ('Red'),
       ('Blue'),
       ('Green'),
       ('White');

/* Ряды */
do
$$
    begin
        for hall in 1..4
            loop
                for number in 1..20
                    loop
                        insert into rows(hall_id, number)
                        VALUES (hall, number);
                    end loop;
            end loop;
    end;
$$;

/* Места */
do
$$
    begin
        for row in 1..80
            loop
                for number in 1..20
                    loop
                        insert into seats(number, row_id)
                        VALUES (number, row);
                    end loop;
            end loop;
    end;
$$;


/* Фильмы */
insert into movies(name, duration, rental_price)
values ('Человек паук', '02:05', 150),
       ('Железный человек', '03:15', 200),
       ('Супермен', '02:10', 220),
       ('Бэтмен', '02:35', 175),
       ('Доктор Стрэндж', '02:15', 215),
       ('Халк', '01:55', 215);

/* Сеансы 10 000 */
insert into sessions(id, movie_id, hall_id, start_at, end_at, markup)
select gs.id,
       random_integer(1, 6),
       random_integer(1, 4),
       random_timestamp(),
       random_timestamp(),
       random_integer(50, 200)
from generate_series(1, 10000) as gs(id);

/* Сеансы 1 000000 */
insert into sessions(id, movie_id, hall_id, start_at, end_at, markup)
select gs.id,
       random_integer(1, 6),
       random_integer(1, 4),
       random_timestamp(),
       random_timestamp(),
       random_integer(50, 200)
from generate_series(10001, 1000000) as gs(id);