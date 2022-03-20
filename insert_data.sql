--insert genre
insert into genre (title)
values
('ужасы'),
('комедия'),
('триллер'),
('фильм катастрофа'),
('детектив'),
('боевик'),
('мелодрама'),
('детский');

--insert films
do
$$
    declare
        noun text[] := '{боль, фигура, основное, чтение, писатель, перспектива, темнота, изменение, рассказ, нож, торговля, определение, управление, страх, разработка, тело, беда, самолет, взгляд, отдых, возможность, страна, господин, личность, трава, дело, сеть, гора, хлеб, ставка, озеро, коммунист, тысяча, сотрудник, факт, старуха, существо, факт, ресторан, вершина, тенденция, трава, практика, инициатива, признак, хозяйство, храм, честь, столик, подразделение}';
        adj  text[] := '{офицерский, мутный, многолетний, лишенный, жуткий, любопытный, связанный, многолетний, парадный, легендарный, металлический, товарный, присущий, административный, компьютерный, мужской, прекрасный, весенний, густой, лишенный, ровный, худой, сплошной, текущий, страховой, нынешний, конкретный, точный, рабочий, западный, заметный, прохожий, ровный, единственный, альтернативный, практический, быстрый, казенный, странный, бетонный, коммунальный, защитный, интимный, головной, ближний, сухой, обширный, конечный, готовый, криминальный}';

    begin
        for index in 1..10000
            loop
                insert into film (film_name, description, premier_date, genre_id)
                values (concat(initcap(adj[1 + random() * (array_length(adj, 1) - 1)]), ' ',
                               noun[1 + random() * (array_length(noun, 1) - 1)], '. Часть ', random_between(1, 5)),
                        random_string(5000),
                        NOW() - (random() * (interval '180 days')) + '10 days',
                        random_between(1, 8));
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
       random_between(1, 10000),
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
                VALUES (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 10000)),
                       (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 10000)),
                       (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 10000)),
                       (1, concat('Рецензия критика ', random_between(1, 1000)), null, null, random_between(1, 10000)),
                       (2, concat('Рецензия киноакадемии ', random_between(1, 1000)), null, null, random_between(1, 10000)),
                       (2, concat('Рецензия киноакадемии ', random_between(1, 1000)), null, null, random_between(1, 10000)),
                       (4, null, true, null, random_between(1, 10000)),
                       (5, null, true, null, random_between(1, 10000)),
                       (9, null, null, CURRENT_DATE, random_between(1, 10000)),
                       ( 9, null, null, CURRENT_DATE, random_between(1, 10000)),
                       ( 9, null, null, CURRENT_DATE, random_between(1, 10000)),
                       ( 9, null, null, (CURRENT_DATE + '20 days'::interval day), random_between(1, 10000)),
                       ( 9, null, null, (CURRENT_DATE + '20 days'::interval day), random_between(1, 10000)),
                       ( 4, null, false, null, random_between(1, 10000));
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
