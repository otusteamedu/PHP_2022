/* 1. Фильмы с самыми длинными названиями */
SELECT f.id, f.name FROM film f
ORDER BY length(f.name) DESC
LIMIT 20;

/* Оптимизация: добавляем функциональный индекс */
CREATE INDEX film__length_name__ind ON film (length(name));

/* 2. Самые дорогие фильмы */
SELECT f.id, f.name, f.base_price FROM film f
ORDER BY f.base_price DESC
LIMIT 20;

/* Оптимизация: добавляем индекс */
CREATE INDEX film__base_price__ind ON film (base_price);

/* 3. Самые продолжительные фильмы */
SELECT f.id, f.name, f.duration FROM film f
ORDER BY f.duration DESC
LIMIT 20;

/* Оптимизация: добавляем индекс */
CREATE INDEX film__duration__ind ON film (duration);

/* 4. 20 самых прибыльных фильмов */
SELECT f.name, SUM(t.price) as total_sum
FROM ticket t
     JOIN schedule sch ON sch.id = t.schedule_id
     JOIN film f ON f.id = sch.film_id
WHERE t.status = true
GROUP BY f.name
ORDER BY total_sum DESC
LIMIT 20;

/* Оптимизация: переделываем запрос */
SELECT f.name, s.total_sum
FROM (
         SELECT sch.film_id, SUM(t.price) as total_sum
         FROM ticket t
                  JOIN schedule sch ON sch.id = t.schedule_id
         WHERE t.status = true
         GROUP BY sch.film_id
         ORDER BY total_sum DESC
         LIMIT 20
     ) s
         JOIN film f ON f.id = s.film_id;

/* 5. Расписание на текущую дату */
SELECT s.id, s.begin_session, f.name, c.name
FROM schedule s
     JOIN cinema_hall c ON s.cinema_hall_id = c.id
     JOIN film f ON s.film_id = f.id
WHERE date_trunc('day', s.begin_session) = CURRENT_DATE
ORDER BY s.begin_session;

/* Оптимизация: добавляем функциональный индекс */
CREATE INDEX schedule__date_trunc_begin_session__ind ON schedule (date_trunc('day', begin_session));

/* 6. Самые дорогие билеты */
SELECT t.id, t.price, t.status, sch.begin_session, f.name AS film,
       ch.name AS cinema_hall, p.row, p.col
FROM ticket t
    JOIN schedule sch ON t.schedule_id = sch.id
    JOIN film f ON sch.film_id = f.id
    JOIN cinema_hall ch ON ch.id = sch.cinema_hall_id
    JOIN cinema_hall_place_relation r ON t.cinema_hall_place_relation_id = r.id
    JOIN place p on r.place_id = p.id
ORDER BY t.price DESC
LIMIT 20;

/* Оптимизация: создаем индекс */
CREATE INDEX ticket__price__ind ON ticket (price);


/* Самые большие объекты БД */
SELECT pn.nspname || '.' || pc.relname AS name,
       pg_size_pretty(pg_total_relation_size(pc.oid)) AS total_size,
       pg_size_pretty(pg_relation_size(pc.oid)) AS rel_size
FROM pg_class pc
    LEFT JOIN pg_namespace pn on pc.relnamespace = pn.oid
WHERE pn.nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(pc.oid) DESC
LIMIT 15;

/* Самые часто используемые индексы */
SELECT * FROM pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5;

/* Самые редко используемые индексы */
SELECT * FROM pg_stat_user_indexes
ORDER BY idx_scan
LIMIT 5;