/*Заполняем справочники*/

insert into movie(name, price, created_at, updated_at)
SELECT 'Movie ' || a.n, cast(random()*(900-400)+400 as int), now(), now()
FROM generate_series(5, 20) as a(n);

/*Залы с количеством мест и коэффициентом цены*/
insert into hall(name, rate, seats_number, created_at, updated_at) values ('Большой зал', 1, 100, now(), now());
insert into hall(name, rate, seats_number, created_at, updated_at) values ('Малый зал 1', 1.2, 50, now(), now());
insert into hall(name, rate, seats_number, created_at, updated_at) values ('Малый зал 2', 1.3, 42, now(), now());
insert into hall(name, rate, seats_number, created_at, updated_at) values ('Камерный зал', 2.2, 20, now(), now());

/*Зоны мест с коэффициентом(зеленая - 2, оранжевая 1,5 , синяя - 1,2, серая - 1)*/
insert into zone(name, rate,  created_at, updated_at) values ('Зеленая', 2,  now(), now());
insert into zone(name, rate,  created_at, updated_at) values ('Оранжевая', 1.5, now(), now());
insert into zone(name, rate,  created_at, updated_at) values ('Желтая', 1.2, now(), now());
insert into zone(name, rate,  created_at, updated_at) values ('Сереая', 1, now(), now());

/*Справочник времени начала сеанса с коэффициентом цены. */
insert into time_type(name, rate, minTime, maxTime, created_at, updated_at) values ('Утро', 0.75, '08:00:00', '12:00:00',now(), now());
insert into time_type(name, rate, minTime, maxTime, created_at, updated_at) values ('Дневное время', 0.8, '12:00:00', '16:00:00',now(), now());
insert into time_type(name, rate, minTime, maxTime, created_at, updated_at) values ('Ранний вечер', 1, '16:00:00', '19:00:00',now(), now());
insert into time_type(name, rate, minTime, maxTime, created_at, updated_at) values ('Пик', 1.5, '19:00:00', '22:00:00',now(), now());
insert into time_type(name, rate, minTime, maxTime, created_at, updated_at) values ('Ночь', 0.5, '23:00:00', '24:00:00',now(), now());

/*Типы дней с коэффициентом цены. */
insert into days_type(name, rate,  created_at, updated_at) values ('Паздничный день', 2,  now(), now());
insert into days_type(name, rate,  created_at, updated_at) values ('Будний', 1,  now(), now());
insert into days_type(name, rate,  created_at, updated_at) values ('Пятница', 1.2,  now(), now());
insert into days_type(name, rate,  created_at, updated_at) values ('Выходной', 2,  now(), now());


/*Заполняем места и распределяем по зонам. Просто равномерно делим места на все зоны. У нас 4 зоны, поэтому по 25% мест на каждую зону */
do $$
declare
ele record;
begin
for ele in select hall_id, seats_number
           from hall
           order by hall_id
    loop
    insert into place(zone_id, hall_id, number, created_at, updated_at)
    SELECT CASE
               WHEN a.n >= 1 and a.n <= ele.seats_number*0.25  THEN 1
               WHEN a.n > ele.seats_number*0.25 and a.n <= ele.seats_number*0.5  THEN 2
               WHEN a.n > ele.seats_number*0.5 and a.n <= ele.seats_number*0.75  THEN 3
               WHEN a.n > ele.seats_number*0.75 and a.n <= ele.seats_number  THEN 4
               END zone_id,
           ele.hall_id, a.n, now(), now()
    FROM generate_series(1, ele.seats_number) as a(n);
    end loop;
end;
$$;

/*Заполняем билеты*/
do $$
declare
rec record;
begin
for rec in select session_id, seats_number, h.hall_id hall_id
           from session s
           inner join hall h on h.hall_id = s.hall_id
           order by session_id
        loop
           insert into ticket(place_id, session_id, created_at, updated_at)
           SELECT (select place_id from place where hall_id = rec.hall_id and number = a.n), rec.session_id,  now(), now()
           FROM generate_series(1, rec.seats_number, 1) as a(n);

        end loop;
end;
$$;


/*Типы дней с коэффициентом цены. */
insert into "user" (name) values ('Виктор');
insert into "user" (name) values ('Мария');

insert into request_type(request_type_id, name) values (1, 'Количество билетов проданных за период');
insert into request_type(request_type_id, name) values (2, 'Прибыль за период');

insert into request_status(request_status_id, name) values (1, 'Принята в обработку');
insert into request_status(request_status_id, name) values (2, 'Выполняется');
insert into request_status(request_status_id, name) values (3, 'Выполнена');
insert into request_status(request_status_id, name) values (4, 'Ошибка выполнения.');
