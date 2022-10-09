INSERT INTO hall (id, name)
VALUES (1, 'Большой зал');

-- добавление мест
SELECT insert_seats(1, 20, 30);

-- добавление фильмов
SELECT insert_movie(1000000);

-- добавление сессий
select insert_sessions(1000000);

-- добавление покупателей
select insert_customers(1000000);

-- добавление билетов
select insert_tickets(1000000);
