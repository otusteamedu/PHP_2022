--insert films
do
$$
    begin
        for index in 11..100
            loop
                insert into film (film_id, film_name)
                values (index, concat('Название фильма. Часть - ', random_between(1, 20)));
            end loop;
    end;
$$;

--insert hall
insert into cinema_hall (hall_id, name, quantity_of_places)
select gs.id,
       concat('Зал № ', random_between(1, 20), '(', random_string(1), ')'),
       random_between(20, 100)
from generate_series(1, 20) as gs(id);

--insert place_type
insert into place_type (place_type_id, type)
values (1, 'VIP'),
       (2, 'средний'),
       (3, 'бюджет');

--insert session
insert into session (session_id, title, time)
values (1, 'утро', '09:00'),
       (2, 'день', '12:00'),
       (3, 'день 2', '15:00'),
       (4, 'вечер', '19:00'),
       (5, 'ночь', '23:00');

--insert price
insert into price (price_id, hall_id, place_type_id, session_id, film_id, amount)
select gs.id,
       random_between(1, 20),
       random_between(1, 3),
       random_between(1, 5),
       random_between(1, 100),
       random_between(100, 800)
from generate_series(1, 2000) as gs(id);

--insert ticket
insert into ticket (ticket_id, price_id, purchase_date)
select gs.id,
       random_between(1, 2000),
       NOW() - (random() * (interval '180 days')) + '10 days'
from generate_series(1, 10000) as gs(id);

--вставка 10000 записей value
do
$$
    begin
        for index in 1..720
            loop
                INSERT INTO attr_value (attr_id, text_val, bool_val, date_val, film_id)
                VALUES (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 100)),
                       (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 100)),
                       (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 100)),
                       (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 100)),
                       (2, concat('Рецензия киноакадемии ', random_between(1, 1000)), null, null, random_between(1, 100)),
                       (2, concat('Рецензия киноакадемии ', random_between(1, 1000)), null, null, random_between(1, 100)),
                       (4, null, true, null, random_between(1, 100)),
                       (5, null, true, null, random_between(1, 100)),
                       (9, null, null, CURRENT_DATE, random_between(1, 100)),
                       ( 9, null, null, CURRENT_DATE, random_between(1, 100)),
                       ( 9, null, null, CURRENT_DATE, random_between(1, 100)),
                       ( 9, null, null, (CURRENT_DATE + '20 days'::interval day), random_between(1, 100)),
                       ( 9, null, null, (CURRENT_DATE + '20 days'::interval day), random_between(1, 100)),
                       ( 4, null, false, null, random_between(1, 100));
            end loop;
    end;
$$;

--вставка 1000000 записей value
-- do
-- $$
--     begin
--         for index in 1..72000
--             loop
--                 INSERT INTO attr_value (attr_id, text_val, bool_val, date_val, film_id)
--                 VALUES (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 100)),
--                        (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 100)),
--                        (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 100)),
--                        (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 100)),
--                        (2, concat('Рецензия киноакадемии ', random_between(1, 1000)), null, null, random_between(1, 100)),
--                        (2, concat('Рецензия киноакадемии ', random_between(1, 1000)), null, null, random_between(1, 100)),
--                        (4, null, true, null, random_between(1, 100)),
--                        (5, null, true, null, random_between(1, 100)),
--                        (9, null, null, CURRENT_DATE, random_between(1, 100)),
--                        ( 9, null, null, CURRENT_DATE, random_between(1, 100)),
--                        ( 9, null, null, CURRENT_DATE, random_between(1, 100)),
--                        ( 9, null, null, (CURRENT_DATE + '20 days'::interval day), random_between(1, 100)),
--                        ( 9, null, null, (CURRENT_DATE + '20 days'::interval day), random_between(1, 100)),
--                        ( 4, null, false, null, random_between(1, 100));
--             end loop;
--     end;
-- $$;

--обнулить автоинкремент таблицы attr_value
--TRUNCATE TABLE attr_value RESTART IDENTITY;
