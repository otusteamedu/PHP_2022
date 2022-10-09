-- количество сессий для каждого фильма за последние 7 дней
explain
SELECT movie_id, count(*)
FROM session
where start between now() - (interval '7 day') and now()
GROUP BY movie_id;


-- Выбор покупателя с самыми большими тратами на билеты
explain
SELECT sum(price), customer_id
FROM ticket
GROUP BY customer_id
ORDER BY sum(price) desc
LIMIT 1;

-- Получение премьер на ближайшую неделю
explain
SELECT *
FROM movie
WHERE premiere_date BETWEEN now() AND now() + (interval '7 day');

---------------------------------------------------------------------------------

-- Сумма продаж по каждому фильму за прошлую неделю
explain
SELECT m.name, sum(t.price)
FROM ticket t
         INNER JOIN session s ON s.id = t.session_id
         INNER JOIN movie m ON s.movie_id = m.id
WHERE s.start BETWEEN now() - (interval '7 days') AND now()::date
GROUP BY m.name
ORDER BY sum(t.price) DESC;

-- 10 самых популярных фильмов по количеству проданных билетов и стоимость проданных билетов на эти фильмы
explain
SELECT m.name, count(t.*), sum(t.price)
FROM movie m
         INNER JOIN session s ON m.id = s.movie_id
         INNER JOIN ticket t ON s.id = t.session_id
GROUP BY m.name
ORDER BY count(t.*) DESC
LIMIT 10;

-- Фильмы, которые показывают сегодня
explain
SELECT DISTINCT m.name
FROM movie m
         INNER JOIN session s ON m.id = s.movie_id
WHERE start::date = now()::date;
